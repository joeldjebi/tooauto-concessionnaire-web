<?php

namespace App\Http\Controllers;

use App\Models\GestionnaireDeFlotte;
use App\Models\Fonction;
use App\Models\Chauffeur;
use App\Models\Categorie_piece;
use App\Models\Garage_flotte;
use App\Models\Type_de_piece;
use App\Models\Concessionnaire;
use App\Models\Type_de_vehicule;
use App\Models\Pays;
use App\Models\Ville;
use App\Models\Commune;
use App\Models\Type_de_demande;
use App\Models\Vehicule_concessionnaire;
use App\Models\Annonce_concessionnaire;
use App\Models\Annonce;
use App\Models\Article;
use App\Models\Alert;
use App\Models\Rdv_concessionnaire;
use App\Models\Sous_categorie_piece;
use App\Models\OffreConcessionnaire;
use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserConcessionnaire;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $data['title'] = 'Tableau de bord';
        $data['menu'] = 'dashboard';

        // Récupérer l'utilisateur connecté
        $data["user"] = Userconcessionnaire::where([
            'id' => auth()->user()->id,
        ])->first();

        $data['pays'] = Pays::all();
        $data['villes'] = Ville::all();
        $data['communes'] = Commune::all();

        $data['concessionnaire'] = Concessionnaire::where('userconcessionnaire_id', auth()->user()->id)->first();

        if (empty($data['concessionnaire'])) {
            session()->flash('type', 'alert-success');
            session()->flash('message', "Lle concessionnaire est introuvable.");
            return view('concessionnaire.create', $data);
        }

        $data['countRdvEnattente'] = Rdv_concessionnaire::where([
            'concessionnaire_id' => $data['concessionnaire']->id,
            'statut' => 0
        ])->count();

        $data['vehiculeCount'] = Vehicule_concessionnaire::where([
            'concessionnaire_id' => $data['concessionnaire']->id,
        ])->count();

        $data['countAnnonce'] = Annonce_concessionnaire::where([
            'concessionaire_id' => $data['concessionnaire']->id,
        ])->count();

        $data['marques'] = Marque::all();

        $data['annonceconcessionnaires'] = Annonce_concessionnaire::where([
            'concessionaire_id' => $data['concessionnaire']->id,
            'statut' => 1
        ])
        ->with('marque', 'type_de_piece', 'type_de_vehicule', 'gestionnaire_de_flotte', 'type_de_demande', 'user')
        ->orderBy('created_at', 'desc')
        ->get();

        // dd($data['annonceconcessionnaires']);

        // Retourner la vue avec les données
        return view('dashboard', $data);
    }

    public function indexAdminUsers()
    {
        if (!$this->currentUserIsFirstAdmin()) {
            abort(403);
        }

        $data['title'] = 'Administrateurs';
        $data['menu'] = 'admins';
        $data['user'] = Userconcessionnaire::find(auth()->id());
        $data['admins'] = Userconcessionnaire::where('role', 1)
            ->orderBy('id')
            ->get();

        return view('admins.index', $data);
    }

    public function storeAdminUser(Request $request)
    {
        if (!$this->currentUserIsFirstAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:userconcessionnaires,email',
            'mobile' => 'required|string|max:20|unique:userconcessionnaires,mobile',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Userconcessionnaire::create([
            'nom' => html_entity_decode($validated['nom']),
            'prenoms' => html_entity_decode($validated['prenoms']),
            'indicatif' => '+225',
            'mobile' => html_entity_decode($validated['mobile']),
            'fonction' => 'Administrateur',
            'email' => html_entity_decode($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => 1,
        ]);

        session()->flash('type', 'alert-success');
        session()->flash('message', 'Administrateur créé avec succès.');

        return redirect()->route('admins.index');
    }

    private function currentUserIsFirstAdmin(): bool
    {
        $user = auth()->user();

        if (!$user || (int) $user->role !== 1) {
            return false;
        }

        $firstAdminId = Userconcessionnaire::where('role', 1)
            ->orderBy('id')
            ->value('id');

        return (int) $user->id === (int) $firstAdminId;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexPieceAuto()
    {
        $data['title'] ='Pièce auto';
        $data['menu'] ='piece-auto';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = Userconcessionnaire::where([
            'id' => auth()->user()->id,
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['categorie_pieces'] = Categorie_piece::orderBy('id', 'desc')->get();
        $data['type_de_pieces'] = Type_de_piece::orderBy('id', 'desc')->get();
        $data['marques'] = Marque::orderBy('id', 'desc')->get();
        $data['sous_categorie_pieces'] = Sous_categorie_piece::orderBy('id', 'desc')->get();

        $data['annonceconcessionnaires'] = Annonce_concessionnaire::where([
            'concessionaire_id' => $data['user']->id,
            'statut' => 1
        ])
        ->with('marque', 'type_de_piece', 'type_de_vehicule', 'gestionnaire_de_flotte', 'type_de_demande', 'user')
        ->get();

        // dd($data['categorie_pieces'], $data['type_de_pieces'], $data['sous_categorie_pieces'], $data['marques']);

        return view('annonce.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function addPieceAuto()
    {
        $data['title'] ='Ajouter une pièce auto';
        $data['menu'] ='piece-auto';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = GestionnaireDeFlotte::where([
            'id' => auth()->user()->id,
            'role' => '01'
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['categorie_pieces'] = Categorie_piece::orderBy('id', 'desc')->get();
        $data['type_de_pieces'] = Type_de_piece::orderBy('id', 'desc')->get();
        $data['marques'] = Marque::orderBy('id', 'desc')->get();
        $data['sous_categorie_pieces'] = Sous_categorie_piece::orderBy('id', 'desc')->get();

        $data['annonces'] = Annonce::where('gestionnaire_de_flotte_id', auth()->user()->id)
        ->where('statut', 1)
        ->with('categorie_piece', 'type_de_piece', 'sous_categorie_piece', 'marque')
        ->paginate(15);

        // dd($data['categorie_pieces'], $data['type_de_pieces'], $data['sous_categorie_pieces'], $data['marques']);

        return view('pieceauto.add', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function editPieceAuto($id)
    {
        $data['title'] ='Modifier une pièce auto';
        $data['menu'] ='piece-auto';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = GestionnaireDeFlotte::where([
            'id' => auth()->user()->id,
            'role' => '01'
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['categorie_pieces'] = Categorie_piece::orderBy('id', 'desc')->get();
        $data['type_de_pieces'] = Type_de_piece::orderBy('id', 'desc')->get();
        $data['marques'] = Marque::orderBy('id', 'desc')->get();
        $data['sous_categorie_pieces'] = Sous_categorie_piece::orderBy('id', 'desc')->get();

        $data['item'] = Annonce::where(['gestionnaire_de_flotte_id' => auth()->user()->id, 'id' => $id])->first();

        // dd($data['categorie_pieces'], $data['type_de_pieces'], $data['sous_categorie_pieces'], $data['marques']);

        return view('pieceauto.edit', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePieceAuto(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'libelle' => 'required|string', // Correction de 'non' à 'nom'
            'type_de_piece_id' => 'required|exists:type_de_pieces,id',
            'marque_id' => 'required|exists:marques,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'categorie_piece_id' => 'required|exists:categorie_pieces,id',
            'sous_categorie_piece_id' => 'required|exists:sous_categorie_pieces,id',
            'modele' => 'required|string',
        ]);

        // Récupérer l'utilisateur authentifié
        $gestionnaireDeFlotte = Auth::user();

        // Vérification de la présence de l'utilisateur
        if (!$gestionnaireDeFlotte) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "L'utilisateur est introuvable.");
            return back();
        }

        $annonce = new Annonce();

        // Gestion de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/annonce'), $imageName);
            $imagePath = $imageName;
            $annonce->image = $imagePath;
        }

        $annonce->libelle = $request->libelle;
        $annonce->description = $request->description;
        $annonce->type_de_piece_id = $request->type_de_piece_id;
        $annonce->marque_id = $request->marque_id;
        $annonce->type_etablissement_id = 1;
        $annonce->modele = $request->modele;
        $annonce->gestionnaire_de_flotte_id = $gestionnaireDeFlotte->id;
        $annonce->categorie_piece_id = $request->categorie_piece_id;
        $annonce->sous_categorie_piece_id = $request->sous_categorie_piece_id;

        // Sauvegarde du chauffeur
        if ($annonce->save()) {
            session()->flash('type', 'alert-success');
            session()->flash('message', "Annonce créé avec succès.");
            return back();
        } else {
            // Si la sauvegarde échoue
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Erreur lors de la création de l'annonce.");
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updatePieceAuto(Request $request, $id)
    {
        // Validation des entrées
        $request->validate([
            'libelle' => 'required|string', // Correction de 'non' à 'nom'
            'type_de_piece_id' => 'required|exists:type_de_pieces,id',
            'marque_id' => 'required|exists:marques,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'categorie_piece_id' => 'required|exists:categorie_pieces,id',
            'sous_categorie_piece_id' => 'required|exists:sous_categorie_pieces,id',
            'modele' => 'required|string',
        ]);

        // Récupérer l'utilisateur authentifié
        $gestionnaireDeFlotte = Auth::user();

        // Vérification de la présence de l'utilisateur
        if (!$gestionnaireDeFlotte) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "L'utilisateur est introuvable.");
            return back();
        }

        $annonce = Annonce::find($id);

        if (!$annonce) {
            return response()->json([
                'success' => false,
                'message' => 'Annonce introuvable.',
            ], 404);
        }

        // Sauvegarde des photos
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Supprimer l'ancienne image si elle existe
            if ($annonce->image && file_exists(public_path('images/annonce/' . $annonce->image))) {
                unlink(public_path('images/annonce/' . $annonce->image));
            }

            // Générer un nouveau nom pour l'image
            $imageName = 'annonce-' . time() . '.' . $image->getClientOriginalExtension();

            // Déplacer l'image dans le répertoire des images
            $image->move(public_path('images/annonce'), $imageName);

            // Mettre à jour le champ image pour l'utilisateur
            $annonce->image = $imageName;
        }

        $annonce->libelle = $request->libelle;
        $annonce->description = $request->description;
        $annonce->type_de_piece_id = $request->type_de_piece_id;
        $annonce->marque_id = $request->marque_id;
        $annonce->modele = $request->modele;
        $annonce->gestionnaire_de_flotte_id = $gestionnaireDeFlotte->id;
        $annonce->categorie_piece_id = $request->categorie_piece_id;
        $annonce->sous_categorie_piece_id = $request->sous_categorie_piece_id;

        // Sauvegarde du chauffeur
        if ($annonce->save()) {
            session()->flash('type', 'alert-success');
            session()->flash('message', "Annonce mise a jour avec succès.");
            return back();
        } else {
            // Si la sauvegarde échoue
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Erreur lors de la mise a jour de l'annonce.");
            return back();
        }
    }

    public function destroyPieceAuto($id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Véhicule introuvable.");
            return back();
        }

        DB::beginTransaction();
        try {
            // Supprimer les images du véhicule
            $images = json_decode($annonce->image, true);
            if ($images) {
                foreach ($images as $image) {
                    if (file_exists(public_path($image))) {
                        unlink(public_path($image)); // Supprimer le fichier photo
                    }
                }
            }

            // Supprimer le véhicule
            $annonce->delete();
            DB::commit();

            session()->flash('type', 'alert-success');
            session()->flash('message', "Annonce supprimé avec succès.");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur est survenue lors de la suppression de l'annonce.");
            return back();
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function indexGarage()
    {
        $data['title'] ='Garage auto';
        $data['menu'] ='garage-auto';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = GestionnaireDeFlotte::where([
            'id' => auth()->user()->id,
            'role' => '01'
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['garage_flottes'] = Garage_flotte::where('gestionnaire_de_flotte_id', auth()->user()->id)
        ->where('statut', 1)
        ->paginate(15);

        return view('garage.index', $data);

    }

    /**
     * Stocke un nouveau garage dans la base.
     */
    public function storeGarage(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:200',
            // On n'inclut plus 'gestionnaire_de_flotte_id' dans la validation,
            // car on va le forcer à être l'id de l'utilisateur authentifié.
            'adresse'       => 'nullable|string|max:500',
            'adresse_map'   => 'nullable|string|max:500',
            'contact'       => 'nullable|string|max:20',
        ]);

        // Forcer l'id de l'utilisateur authentifié comme gestionnaire_de_flotte_id
        $validatedData['gestionnaire_de_flotte_id'] = auth()->id();

        Garage_flotte::create($validatedData);

        session()->flash('type', 'alert-success');
        session()->flash('message', "Garage créé avec succès.");
        return back();
    }

    /**
     * Met à jour un garage existant.
     */
    public function updateGarage(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:200',
                Rule::unique('garage_flottes')->ignore($id),
            ],
            // On n'inclut plus 'gestionnaire_de_flotte_id' dans la validation.
            'adresse'       => 'nullable|string|max:500',
            'adresse_map'   => 'nullable|string|max:500',
            'contact'       => 'nullable|string|max:20',
        ]);

        // Forcer l'id de l'utilisateur authentifié comme gestionnaire_de_flotte_id
        $validatedData['gestionnaire_de_flotte_id'] = auth()->id();

        $garage = Garage_flotte::findOrFail($id);
        $garage->update($validatedData);

        session()->flash('type', 'alert-success');
        session()->flash('message', "Garage mis à jour avec succès.");
        return back();
    }

    public function destroyGarage($id)
    {
        $garage = Garage_flotte::findOrFail($id);
        $garage->delete();
        session()->flash('type', 'alert-danger');
        session()->flash('message', "Garage supprimé avec succès.");
        return back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexArticle()
    {
        $data['title'] ='Article auto';
        $data['menu'] ='article-auto';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = GestionnaireDeFlotte::where([
            'id' => auth()->user()->id,
            'role' => '01'
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['articles'] = Article::where('gestionnaire_de_flotte_id', auth()->user()->id)->paginate(15);

        return view('article.index', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeArticle(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'libelle' => 'required|string', // Correction de 'non' à 'nom'
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'amount' => 'required',
        ]);

        // Récupérer l'utilisateur authentifié
        $gestionnaireDeFlotte = Auth::user();

        // Vérification de la présence de l'utilisateur
        if (!$gestionnaireDeFlotte) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "L'utilisateur est introuvable.");
            return back();
        }

        $article = new Article();

        // Gestion de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/article'), $imageName);
            $imagePath = $imageName;
            $article->image = $imagePath;
        }

        $article->libelle = $request->libelle;
        $article->description = $request->description;
        $article->amount = $request->amount;
        $article->gestionnaire_de_flotte_id = $gestionnaireDeFlotte->id;
        $article->created_by = $gestionnaireDeFlotte->id;

        // Sauvegarde du chauffeur
        if ($article->save()) {
            session()->flash('type', 'alert-success');
            session()->flash('message', "article créé avec succès.");
            return back();
        } else {
            // Si la sauvegarde échoue
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Erreur lors de la création de l'article.");
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateArticle(Request $request, $id)
    {
        // Validation des entrées
        $request->validate([
            'libelle' => 'required|string', // Correction de 'non' à 'nom'
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'amount' => 'required',
        ]);

        // Récupérer l'utilisateur authentifié
        $gestionnaireDeFlotte = Auth::user();

        // Vérification de la présence de l'utilisateur
        if (!$gestionnaireDeFlotte) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "L'utilisateur est introuvable.");
            return back();
        }

        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'article introuvable.',
            ], 404);
        }

        // Sauvegarde des photos
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Supprimer l'ancienne image si elle existe
            if ($article->image && file_exists(public_path('images/article/' . $article->image))) {
                unlink(public_path('images/article/' . $article->image));
            }

            // Générer un nouveau nom pour l'image
            $imageName = 'article-' . time() . '.' . $image->getClientOriginalExtension();

            // Déplacer l'image dans le répertoire des images
            $image->move(public_path('images/article'), $imageName);

            // Mettre à jour le champ image pour l'utilisateur
            $article->image = $imageName;
        }

        $article->libelle = $request->libelle;
        $article->description = $request->description;
        $article->amount = $request->amount;

        // Sauvegarde du chauffeur
        if ($article->save()) {
            session()->flash('type', 'alert-success');
            session()->flash('message', "article mise a jour avec succès.");
            return back();
        } else {
            // Si la sauvegarde échoue
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Erreur lors de la mise a jour de l'article.");
            return back();
        }
    }

    public function destroyArticle($id)
    {
        $article = Article::find($id);

        if (!$article) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Véhicule introuvable.");
            return back();
        }

        DB::beginTransaction();
        try {
            // Supprimer les images du véhicule
            $images = json_decode($article->image, true);
            if ($images) {
                foreach ($images as $image) {
                    if (file_exists(public_path($image))) {
                        unlink(public_path($image)); // Supprimer le fichier photo
                    }
                }
            }

            // Supprimer le véhicule
            $article->delete();
            DB::commit();

            session()->flash('type', 'alert-success');
            session()->flash('message', "article supprimé avec succès.");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur est survenue lors de la suppression de l'article.");
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexConcessionnaire()
    {
        $data['title'] ='Liste des concessionnaire';
        $data['menu'] ='index-concessionnaire';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = GestionnaireDeFlotte::where([
            'id' => auth()->user()->id,
            'role' => '01'
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['type_de_demandes'] = Type_de_demande::all();
        $data['type_de_pieces'] = Type_de_piece::all();
        $data['type_de_vehicules'] = Type_de_vehicule::all();
        $data['marques'] = Marque::all();
        $data['concessionnaires'] = Concessionnaire::where('statut', 1)->paginate(15);

        return view('concessionnaire.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexConcessionnaireHistoriqueRdv()
    {
        $data['title'] ='Liste des rdv';
        $data['menu'] ='rdv-concessionnaire';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = Userconcessionnaire::where([
            'id' => auth()->user()->id,
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['type_de_demandes'] = Type_de_demande::all();
        $data['type_de_pieces'] = Type_de_piece::all();
        $data['type_de_vehicules'] = Type_de_vehicule::all();
        $data['marques'] = Marque::all();
        $data['concessionnaires'] = Userconcessionnaire::where('statut', 1)->get();

        $data['rdv_concessionnaires'] = Rdv_concessionnaire::where('concessionnaire_id', auth()->user()->id)
        ->with(['gestionnaireDeFlotte', 'user'])
        ->orderBy('created_at', 'desc')
        ->get();

        // dd($data['rdv_concessionnaires']);

        return view('rdv.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexUsagerHistoriqueRdv()
    {
        $data['title'] ='Liste des usagers';
        $data['menu'] ='usager-historique-rdv';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = Userconcessionnaire::where([
            'id' => auth()->user()->id,
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['type_de_demandes'] = Type_de_demande::all();
        $data['type_de_pieces'] = Type_de_piece::all();
        $data['type_de_vehicules'] = Type_de_vehicule::all();
        $data['marques'] = Marque::all();
        $data['concessionnaires'] = Userconcessionnaire::where('statut', 1)->get();

        $data['rdv_concessionnaires'] = Rdv_concessionnaire::where('concessionnaire_id', auth()->user()->id)
        ->whereNotNull('user_id')
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('rdv.usager_rdv', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexConcessionnaireVehicule($id)
    {
        $data['title'] ='Liste des concessionnaire';
        $data['menu'] ='index-concessionnaire';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = Concessionnaire::where([
            'id' => auth()->user()->id,
            'role' => '01'
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }


        $data['vehicule_concessionnaires'] = Vehicule_concessionnaire::where('concessionnaire_id', $id)
        ->with('couleur_vehicule', 'marque')
        ->get();

        // dd($data['vehicule_concessionnaires']);

        return view('concessionnaire.vehicule', $data);

    }

    public function storeDemandeConcessionnaire(Request $request)
    {
        // Validation des données envoyées depuis le formulaire
        $validatedData = $request->validate([
            'type_de_demande_id'   => 'required|integer|exists:type_de_demandes,id',
            'type_de_piece_id'     => 'required|integer|exists:type_de_pieces,id',
            'type_de_vehicule_id'  => 'required|integer|exists:type_de_vehicules,id',
            'marque_id'            => 'required|integer|exists:marques,id',
            'modele'               => 'required|string|max:255',
            'message'              => 'required|string',
            'concessionaire_id'    => 'required|integer|exists:concessionaires,id',
        ]);

        $validatedData['concessionnaire_id'] = auth()->id();

        // Création de l'enregistrement dans la table annonce_concessionnaires
        $annonce = Annonce_concessionnaire::create($validatedData);

        // Redirection avec message de succès (vous pouvez adapter la redirection)
        session()->flash('type', 'alert-success');
        session()->flash('message', "Demande enregistrée avec succès.");
        return back();
    }

    public function storeRdvConcessionnaire(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'statut' => 'required|integer|in:0,1,2,3',
            'rdv_id' => 'required|integer|exists:rdv_concessionnaires,id',
            'reponse_concessionnaire' => 'nullable|string',
            // 'jour' => 'nullable|string|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            // 'heure' => 'nullable|string',
        ]);

        $validatedData['concessionnaire_id'] = auth()->id();

        // Si le statut est "Accepté" (1), alors la date/heure est requise
        // if ($validatedData['statut'] == 1) {
        //     if (empty($validatedData['jour']) || empty($validatedData['heure'])) {
        //         return back()->withErrors(['jour' => 'Le jour et l\'heure sont requis pour un rendez-vous accepté.'])->withInput();
        //     }
        // }

        // Mise à jour du rendez-vous existant au lieu de créer un nouveau
        $rdv = Rdv_concessionnaire::where('id', $request->rdv_id)
        ->where('concessionnaire_id', $validatedData['concessionnaire_id'])
            ->first();

        if ($rdv) {
            $rdv->update($validatedData);
            // Redirection avec un message de succès
            session()->flash('type', 'alert-success');
            session()->flash('message', "Rendez-vous mis à jour avec succès.");
            return back();
        }else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Rendez-vous introuvable.");
            return back();
        }
    }

    public function updateRdvConcessionnaire(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'statut' => 'required|integer|in:0,1,2,3',
            'rdv_id' => 'required|integer',
            'reponse_concessionnaire' => 'nullable|string',
        ]);

        $rdv = Rdv_concessionnaire::where('id', $request->rdv_id)
        ->where('concessionnaire_id', auth()->id())
        ->first();

        if ($rdv) {
            $rdv->update($validatedData);
            // Redirection avec un message de succès
            session()->flash('type', 'alert-success');
            session()->flash('message', "Rendez-vous mis à jour avec succès.");
            return back();
        }else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Rendez-vous introuvable.");
            return back();
        }
    }






    /**
     * Show the form for creating a new resource.
     */
    public function indexFonction()
    {
        $data['title'] ='Les fonction';
        $data['menu'] ='fonction';

        // Récupérer l'utilisateur connecté avec le rôle '01'
        $data["user"] = Concessionnaire::where([
            'id' => auth()->user()->id,
            'role' => '01'
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Utilisateur introuvable ou rôle non autorisé.");
            return back();
        }

        $data['fonctions'] = Fonction::where('concessionnaire_id', auth()->user()->id)->paginate(15);

        return view('fonction.index', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFonction(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'libelle' => [
                'required',
                'string',
                Rule::unique('fonctions')->where(function ($query) {
                    return $query->where('concessionnaire_id', auth()->id());
                })
            ],
        ], [
            'libelle.unique' => 'La fonction ":input" existe déjà.',
        ]);

        // Récupérer l'utilisateur authentifié
        $concessionnaire = Auth::user();

        // Vérification de la présence de l'utilisateur
        if (!$concessionnaire) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "L'utilisateur est introuvable.");
            return back();
        }

        $fonction = new Fonction();

        $fonction->libelle = $request->libelle;
        $fonction->concessionnaire_id = $concessionnaire->id;

        // Sauvegarde de la fonction
        if ($fonction->save()) {
            session()->flash('type', 'alert-success');
            session()->flash('message', "Fonction créé avec succès.");
            return back();
        } else {
            // Si la sauvegarde échoue
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Erreur lors de la création de la fonction.");
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateFonction(Request $request, $id)
    {
        // Validation des entrées
        $request->validate([
            'libelle' => 'required|string',
        ]);

        // Récupérer l'utilisateur authentifié
        $concessionnaire = Auth::user();

        // Vérification de la présence de l'utilisateur
        if (!$concessionnaire) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "L'utilisateur est introuvable.");
            return back();
        }

        $fonction = Fonction::find($id);

        if (!$fonction) {
            return response()->json([
                'success' => false,
                'message' => 'Fonction introuvable.',
            ], 404);
        }

        $fonction->libelle = $request->libelle;
        $fonction->concessionnaire_id = $concessionnaire->id;

        // Sauvegarde du chauffeur
        if ($fonction->save()) {
            session()->flash('type', 'alert-success');
            session()->flash('message', "Fonction mise a jour avec succès.");
            return back();
        } else {
            // Si la sauvegarde échoue
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Erreur lors de la mise a jour de la fonction.");
            return back();
        }
    }

    public function destroyFonction($id)
    {
        $fonction = Fonction::find($id);

        if (!$fonction) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Fonction introuvable.");
            return back();
        }

        DB::beginTransaction();
        try {
            // Supprimer de la fonction
            $fonction->delete();
            DB::commit();

            session()->flash('type', 'alert-success');
            session()->flash('message', "Fonction supprimé avec succès.");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur est survenue lors de la suppression de la fonction.");
            return back();
        }
    }

    /**
     * Affiche le formulaire de mise à jour du profil
     */
    public function profil()
    {
        $data['title'] = 'Mon profil';
        $data['menu'] = 'profil';
        $data['user'] = auth()->user();

        return view('profil.update', $data);
    }

    /**
     * Met à jour les informations du profil
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $userconcessionnaire = Userconcessionnaire::where('id', $user->id)->first();
            if (empty($userconcessionnaire)) {
                session()->flash('type', 'alert-danger');
                session()->flash('message', "Utilisateur introuvable.");
                return back();
            }

            // Mise à jour des informations de base
            $userconcessionnaire->nom = $request->nom;
            $userconcessionnaire->prenoms = $request->prenoms;
            $userconcessionnaire->mobile = $request->mobile;

            $userconcessionnaire->save();
            DB::commit();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Profil mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue lors de la mise à jour du profil.');
        }

        return back();
    }

    /**
     * Affiche le formulaire de changement de mot de passe
     */
    public function password()
    {
        $data['title'] = 'Changer le mot de passe';
        $data['menu'] = 'password';
        $data['user'] = auth()->user();

        return view('profil.password', $data);
    }

    /**
     * Met à jour le mot de passe
     */
    public function updatepassword(Request $request)
    {
        $user = auth()->user();

        // Validation des données
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'new_password_confirmation' => 'required|same:new_password'
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis.',
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'new_password.required' => 'Le nouveau mot de passe est requis.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'new_password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'new_password_confirmation.required' => 'La confirmation du mot de passe est requise.',
            'new_password_confirmation.same' => 'La confirmation du mot de passe ne correspond pas.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Mise à jour du mot de passe
            $user->password = Hash::make($request->new_password);
            $user->save();

            DB::commit();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Mot de passe mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue lors de la mise à jour du mot de passe.');
        }

        return back();
    }

    public function annonceSent()
    {
        $data['title'] = 'Annonces envoyées';
        $data['menu'] = 'annonce';

        $data['user'] = auth()->user();

        $data['concessionnaire'] = Concessionnaire::where('userconcessionnaire_id', auth()->user()->id)->first();
        if (empty($data['concessionnaire'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Vous n'avez pas encore enregistré votre établissement.");
            return back();
        }
        $data['offre_concessionnaires'] = OffreConcessionnaire::where('concessionnaire_id', auth()->user()->id)->get();

        return view('annonce.concessionnaire', $data);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
