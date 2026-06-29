<?php

namespace App\Http\Controllers;

use App\Models\VehiculeConcessionnaire;
use App\Models\Marque;
use App\Services\WasabiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class VehiculeController extends Controller
{
    public function __construct(
        protected WasabiService $wasabiService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Liste des véhicules';
        $data['menu'] ='véhicules';

        $data['user'] = Auth::user();
        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "L'utilisateur est introuvable.");
            return back();
        }

        // Récupérer les véhicules concessionnaires triés par ID décroissant
        $data['vehiculeConcessionnaires'] = VehiculeConcessionnaire::where('concessionnaire_id', $data['user']->id)
        ->with('marque')
        ->orderBy('id', 'desc')->get()
        ->map(fn (VehiculeConcessionnaire $vehicule) => $this->attachVehicleFileUrls($vehicule));

        $data['marques'] = Marque::orderBy('id', 'desc')->get();

        return view('vehicule.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'marque_id' => 'required|exists:marques,id',
            'modele' => 'required|string|max:200',
            'prix' => 'nullable|integer',
            'description' => 'required|string',
            'garantie' => 'nullable|string|max:300',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|file|image|max:5120', // Augmenté à 5MB pour test
            'fichier' => 'nullable|file|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();

        if (empty($user)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable.");
            return back();
        }

        DB::beginTransaction();
        try {
            // Création du véhicule concessionnaire
            $vehicule = new VehiculeConcessionnaire();
            $vehicule->name = $request->name;
            $vehicule->concessionnaire_id = $user->id; // Utiliser l'ID de l'utilisateur connecté
            $vehicule->marque_id = $request->marque_id;
            $vehicule->modele = $request->modele;
            $vehicule->prix = $request->prix ?? 0;
            $vehicule->description = $request->description;
            $vehicule->garantie = $request->garantie;


            // Traitement des photos
            if ($request->hasFile('photos')) {
                $photos = $request->file('photos');
                $photosPaths = [];

                foreach ($photos as $image) {
                    if ($image->isValid()) {
                        $photosPaths[] = $this->wasabiService->uploadFile(
                            $image,
                            config('wasabi.vehicule_image_directory', 'images/vehicules'),
                            'vehicule'
                        );
                    }
                }

                if (!empty($photosPaths)) {
                    $vehicule->photos = $photosPaths; // Utiliser directement le tableau car le modèle a un cast 'array'
                }
            }

            // Traitement du fichier
            if ($request->hasFile('fichier')) {
                $vehicule->fichier = $this->wasabiService->uploadFile(
                    $request->file('fichier'),
                    config('wasabi.vehicule_file_directory', 'fichiers/vehicules'),
                    'fichier'
                );
            }

            $vehicule->save();
            DB::commit();


            session()->flash('type', 'alert-success');
            session()->flash('message', "Véhicule enregistré avec succès.");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur est survenue lors de l'enregistrement du véhicule : " . $e->getMessage());
            return back();
        }
    }


    public function update(Request $request, $id)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'marque_id' => 'required|exists:marques,id',
            'modele' => 'required|string|max:200',
            'prix' => 'nullable|integer',
            'description' => 'required|string',
            'garantie' => 'nullable|string|max:300',
            'photos' => 'nullable|array',
            'photos.*' => 'file|image|max:2048',
            'fichier' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vehicule = VehiculeConcessionnaire::find($id);

        if (!$vehicule) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Véhicule introuvable.");
            return back();
        }

        $user = auth()->user();

        if (empty($user)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable.");
            return back();
        }

        DB::beginTransaction();
        try {
            // Mettre à jour les champs du véhicule
            $vehicule->name = $request->name;
            $vehicule->marque_id = $request->marque_id;
            $vehicule->modele = $request->modele;
            $vehicule->prix = $request->prix ?? 0;
            $vehicule->description = $request->description;
            $vehicule->garantie = $request->garantie;

            // Gestion des photos existantes et nouvelles
            $currentPhotos = $vehicule->photos ?: [];
            
            // Supprimer les photos marquées pour suppression
            if ($request->has('deleted_photos')) {
                foreach ($request->deleted_photos as $deletedPhoto) {
                    $this->deleteFile($deletedPhoto);
                    
                    // Retirer de la liste des photos actuelles
                    $currentPhotos = array_filter($currentPhotos, function($photo) use ($deletedPhoto) {
                        return $photo !== $deletedPhoto;
                    });
                }
            }
            
            // Ajouter les nouvelles photos
            if ($request->hasFile('photos')) {
                $photos = $request->file('photos');

                foreach ($photos as $image) {
                    if ($image->isValid()) {
                        $currentPhotos[] = $this->wasabiService->uploadFile(
                            $image,
                            config('wasabi.vehicule_image_directory', 'images/vehicules'),
                            'vehicule'
                        );
                    }
                }
            }
            
            // Mettre à jour les photos (réindexer le tableau)
            $vehicule->photos = array_values($currentPhotos);

            // Traitement du fichier
            if ($request->hasFile('fichier')) {
                $this->deleteFile($vehicule->fichier, 'fichiers/vehicules');

                $vehicule->fichier = $this->wasabiService->uploadFile(
                    $request->file('fichier'),
                    config('wasabi.vehicule_file_directory', 'fichiers/vehicules'),
                    'fichier'
                );
            }

            $vehicule->save();
            DB::commit();

            session()->flash('type', 'alert-success');
            session()->flash('message', "Véhicule mis à jour avec succès.");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur est survenue lors de la mise à jour du véhicule : " . $e->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        $vehicule = VehiculeConcessionnaire::find($id);

        if (!$vehicule) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Véhicule introuvable.");
            return back();
        }

        DB::beginTransaction();
        try {
            // Supprimer les photos du véhicule
            $photos = $vehicule->photos; // Utiliser directement le cast array
            if ($photos && is_array($photos)) {
                foreach ($photos as $photo) {
                    $this->deleteFile($photo);
                }
            }

            // Supprimer le fichier
            $this->deleteFile($vehicule->fichier, 'fichiers/vehicules');

            // Supprimer le véhicule
            $vehicule->delete();
            DB::commit();

            session()->flash('type', 'alert-success');
            session()->flash('message', "Véhicule supprimé avec succès.");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur est survenue lors de la suppression du véhicule.");
            return back();
        }
    }

    protected function attachVehicleFileUrls(VehiculeConcessionnaire $vehicule): VehiculeConcessionnaire
    {
        $photos = is_array($vehicule->photos) ? $vehicule->photos : [];

        $vehicule->photo_urls = array_map(
            fn (?string $photo) => $this->fileUrl($photo),
            $photos
        );

        $vehicule->fichier_url = $this->fileUrl($vehicule->fichier, 'fichiers/vehicules');

        return $vehicule;
    }

    protected function fileUrl(?string $path, string $legacyDirectory = ''): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if ($this->isWasabiPath($path)) {
            return $this->wasabiService->temporaryUrl($path) ?: $this->wasabiPublicUrl($path);
        }

        if ($legacyDirectory !== '' && !str_contains($path, '/')) {
            return asset(trim($legacyDirectory, '/') . '/' . $path);
        }

        return asset($path);
    }

    protected function deleteFile(?string $path, string $legacyDirectory = ''): void
    {
        if (empty($path)) {
            return;
        }

        if (filter_var($path, FILTER_VALIDATE_URL) || $this->isWasabiPath($path)) {
            $this->wasabiService->deleteFile($path);
            return;
        }

        $legacyPath = str_contains($path, '/')
            ? public_path($path)
            : public_path(trim($legacyDirectory, '/') . '/' . $path);

        if (File::exists($legacyPath)) {
            File::delete($legacyPath);
        }
    }

    protected function isWasabiPath(string $path): bool
    {
        $wasabiDirectories = [
            config('wasabi.vehicule_image_directory', 'images/vehicules'),
            config('wasabi.vehicule_file_directory', 'fichiers/vehicules'),
        ];

        foreach ($wasabiDirectories as $directory) {
            if (str_starts_with(ltrim($path, '/'), trim($directory, '/') . '/')) {
                return true;
            }
        }

        return false;
    }

    protected function wasabiPublicUrl(string $path): string
    {
        return rtrim((string) config('wasabi.url'), '/') . '/' . ltrim($path, '/');
    }



}
