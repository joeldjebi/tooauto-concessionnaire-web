<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Redirector;
use Session;
use App\Models\Userconcessionnaire;
use App\Models\Concessionnaire;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected SmsService $smsService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showlogin()
    {
        return view('auth.login');
    }

    /**
     * connexion des utilisateurs
     * @param Request $request
     */
    public function login(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = $request->has('remember'); // Option "souviens-toi de moi"
// dd($credentials);
        // Tentative d'authentification
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user(); // Récupère l'utilisateur authentifié

                // Vérifie si l'utilisateur a un concessionnaire enregistré
                $hasconcessionnaire = Concessionnaire::where('userconcessionnaire_id', $user->id)->exists();

                if ($hasconcessionnaire) {
                    return redirect()->route('dashboard'); // Redirection vers le tableau de bord
                } else {
                    // Redirection vers la page d'enregistrement de l'établissement
                    session()->flash('type', 'alert-success');
                    session()->flash('message', "Félicitations ! Votre compte a été créé avec succès. Maintenant, il est temps de configurer votre établissement. Veuillez enregistrer les informations relatives à votre établissement pour commencer à utiliser toutes les fonctionnalités de notre plateforme.");
                    return redirect()->route('concessionnaire.create');
                }
        } else {
            // En cas d'informations d'identification incorrectes
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Informations de connexion incorrectes.');
            return back();
        }
    }




     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showregister()
    {
        $data['title'] ='Inscriptions';
        $data['menu'] ='register';

        return view('auth.register',$data);
    }

    public function showConcessionnaireRegister()
    {
        $data['title'] = 'Inscription concessionnaire';
        $data['menu'] = 'register-concessionnaire';

        return view('auth.register_concessionnaire', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ecole  $ecole
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:userconcessionnaires',
            'email' => 'nullable|string|email|max:255|unique:userconcessionnaires',
            'password' => 'required|string|min:8|confirmed',
            'cgu' => 'accepted', // Vérifie que les conditions générales sont acceptées
        ]);

        // Création du concessionnaire utilisateur
        $concessionnaire = Userconcessionnaire::create([
            'nom' => html_entity_decode($request->nom),
            'prenoms' => html_entity_decode($request->prenoms),
            'indicatif' => '+225',
            'mobile' => html_entity_decode($request->mobile),
            'email' => html_entity_decode($request->email),
            'password' => Hash::make($request->password), // Hash du mot de passe
            'role' => 1,
        ]);

        // Vérification si l'utilisateur a bien été créé
        if (!empty($concessionnaire)) {
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Votre inscription a été effectuée avec succès');

            return redirect('/login');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');

            return back();
        }
    }

    public function registerConcessionnaire(Request $request)
    {
        $request->validate([
            'concessionnaire_email' => 'required|string|email|max:255|unique:concessionnaires,email',
            'concessionnaire_mobile_fix' => 'required|string|max:20|unique:concessionnaires,mobile_fix',
            'concessionnaire_mobile' => 'required|string|max:20|unique:concessionnaires,contact',
            'siege_social' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:userconcessionnaires,email',
            'mobile' => 'required|string|max:20|unique:userconcessionnaires,mobile',
            'fonction' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'cgu' => 'accepted',
        ]);

        DB::beginTransaction();
        try {
            $user = Userconcessionnaire::create([
                'nom' => html_entity_decode($request->nom),
                'prenoms' => html_entity_decode($request->prenoms),
                'indicatif' => '+225',
                'mobile' => html_entity_decode($request->mobile),
                'fonction' => html_entity_decode($request->fonction),
                'email' => html_entity_decode($request->email),
                'password' => Hash::make($request->password),
				'role' => 1,
            ]);

            Concessionnaire::create([
                'contact' => html_entity_decode($request->concessionnaire_mobile),
                'email' => html_entity_decode($request->concessionnaire_email),
                'siege_social' => html_entity_decode($request->siege_social),
                'adresse' => html_entity_decode($request->siege_social),
                'userconcessionnaire_id' => $user->id,
                'mobile_fix' => html_entity_decode($request->concessionnaire_mobile_fix),
                'is_whatsapp' => $request->boolean('concessionnaire_is_whatsapp') ? '1' : '0',
            ]);

            DB::commit();
            Auth::login($user);

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Votre compte et votre concessionnaire ont été créés avec succès.');

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur est survenue lors de la création du compte : " . $e->getMessage());

            return back()->withInput();
        }
    }
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showpasswordforget()
    {
        return view('auth.password_forget');
    }

    /**
     * Envoie un SMS via l'API MTarget.
     *
     * @param string $to Numéro du destinataire (avec indicatif)
     * @param string $message Message à envoyer
     * @param string $senderId Nom ou numéro de l'expéditeur
     * @return array Réponse de l'API
     */
    private function sendSms($to, $message, $senderId = 'TOO AUTO')
    {
        $response = $this->smsService->sendSmsMtarget($message, $to, $senderId);

        return [
            'status' => 200,
            'body' => $response,
            'json' => json_decode($response, true),
        ];
    }

    /**
     * Traite la demande de mot de passe oublié et envoie un OTP par SMS
     */
    public function postPasswordForget(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $fullPhone = '+225' . $request->phone;
        $phone = $request->phone;
        $otp = rand(100000, 999999);
        session(['otp' => $otp, 'otp_phone' => $fullPhone, 'phone' => $phone]);
        $message = "Votre code de réinitialisation est : $otp";
        $smsResult = $this->sendSms($fullPhone, $message);

        if ($smsResult['status'] == 200) {
            return redirect()->route('auth.otp')->with('success', 'Le code OTP a été envoyé par SMS.');
        } else {
            return back()->with('error', "Erreur lors de l'envoi du SMS. Veuillez réessayer.");
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otpSaisi = $request->otp;
        $otpSession = session('otp');
        $phoneSession = session('otp_phone');
        $phone = session('phone');
        if ($otpSaisi == $otpSession) {
            session(['otp_verified' => true]);
            return redirect()->route('password.reset.form')->with('success', 'Code OTP vérifié. Veuillez choisir un nouveau mot de passe.');
        } else {
            return back()->with('error', 'Code OTP incorrect. Veuillez réessayer.');
        }
    }

    public function resetPassword(Request $request)
    {
        // Vérifier que l'utilisateur a bien validé l'OTP
        if (!session('otp_verified') || !session('otp_phone')) {
            return redirect()->route('auth.otp')->with('error', 'Veuillez valider le code OTP.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $phone = session('phone');
        $user = \App\Models\Userconcessionnaire::where('mobile', $phone)->first();
        if (!$user) {
            return back()->with('error', 'Utilisateur introuvable.');
        }
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        // Nettoyer la session OTP
        session()->forget(['otp', 'otp_phone', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès. Vous pouvez vous connecter.');
    }

}
