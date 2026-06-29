<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Inscription concessionnaire</title>
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <style>
            .login-wrapper .login-content {
                width: initial;
            }
            .login-wrapper .login-content.user-login .login-userset {
                background: #ffffff;
                box-shadow: 0px 4px 60px 0px rgba(190, 190, 190, 0.27);
                margin: 0;
                padding: 40px;
                border: 1px solid #e8ebed;
            }
            .login-wrapper .login-content .login-logo {
                text-align: center;
                max-width: 100%;
            }
            .form-section-title {
                border-bottom: 1px solid #e8ebed;
                margin: 20px 0;
                padding-bottom: 10px;
            }
        </style>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            <div class="account-content">
                <div class="login-wrapper login-new">
                    <div class="container">
                        <div class="login-content user-login">
                            <form action="{{ route('register.concessionnaire.store') }}" method="POST">
                                @csrf
                                <div class="login-logo">
                                    <img src="assets/img/logo.png" width="100" alt="img">
                                    <a href="index.html" class="login-logo logo-white">
                                        <img src="assets/img/logo-white.png" alt="">
                                    </a>
                                </div>
                                <div class="login-userset">
                                    @if(session()->has("message"))
                                        <div style="padding: 10px" class="alert {{ session()->get('type') }}">{{ session()->get('message') }}</div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="login-userheading">
                                        <h3>Créer un compte concessionnaire</h3>
                                        <h4>Renseignez le compte utilisateur et les informations principales du concessionnaire</h4>
                                    </div>

                                    <h5 class="form-section-title">Informations concessionnaire</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Email concessionnaire</label>
                                                <div class="form-addons">
                                                    <input type="email" class="form-control" name="concessionnaire_email" value="{{ old('concessionnaire_email') }}" required>
                                                    <img src="../assets/img/icons/mail.svg" alt="image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Fixe</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">+225</span>
                                                    <input type="text" class="form-control" name="concessionnaire_mobile_fix" value="{{ old('concessionnaire_mobile_fix') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Mobile concessionnaire</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">+225</span>
                                                    <input type="text" class="form-control" name="concessionnaire_mobile" value="{{ old('concessionnaire_mobile') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Siège social</label>
                                                <div class="form-addons">
                                                    <input type="text" class="form-control" name="siege_social" value="{{ old('siege_social') }}" required>
                                                    <img src="../assets/img/icons/places.svg" alt="image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="form-section-title">Utilisateur</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Nom</label>
                                                <div class="form-addons">
                                                    <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
                                                    <img src="../assets/img/icons/user-icon.svg" alt="image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Prénoms</label>
                                                <div class="form-addons">
                                                    <input type="text" class="form-control" name="prenoms" value="{{ old('prenoms') }}" required>
                                                    <img src="../assets/img/icons/user-icon.svg" alt="image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Email utilisateur</label>
                                                <div class="form-addons">
                                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                                    <img src="../assets/img/icons/mail.svg" alt="image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-login">
                                                <label>Mobile utilisateur</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">+225</span>
                                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-login">
                                                <label>Fonction</label>
                                                <div class="form-addons">
                                                    <input type="text" class="form-control" name="fonction" value="{{ old('fonction') }}" required>
                                                    <img src="../assets/img/icons/users.svg" alt="image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-login">
                                        <label>Mot de passe</label>
                                        <div class="pass-group">
                                            <input type="password" class="pass-input" name="password" required id="password">
                                            <span class="fas toggle-password fa-eye-slash" data-target="password"></span>
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <label>Confirmer le mot de passe</label>
                                        <div class="pass-group">
                                            <input type="password" class="pass-input" name="password_confirmation" required id="password_confirmation">
                                            <span class="fas toggle-password fa-eye-slash" data-target="password_confirmation"></span>
                                        </div>
                                    </div>
                                    <div class="form-login authentication-check">
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs">
                                                <input type="checkbox" name="cgu" id="cgu-checkbox" required>
                                                <span class="checkmarks"></span>
                                                J'accepte les
                                                <a href="#" class="hover-a">conditions générales et la confidentialité</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <button class="btn btn-login" type="submit" id="submit-button" disabled>Créer le compte</button>
                                    </div>
                                    <div class="signinform">
                                        <h4>Vous avez déjà un compte ? <a href="{{ route('login') }}" class="hover-a">Connectez-vous</a></h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".toggle-password").forEach(toggleIcon => {
                    toggleIcon.addEventListener("click", function () {
                        const targetInput = document.getElementById(this.getAttribute("data-target"));
                        targetInput.setAttribute("type", targetInput.getAttribute("type") === "password" ? "text" : "password");
                        this.classList.toggle("fa-eye");
                        this.classList.toggle("fa-eye-slash");
                    });
                });

                const checkbox = document.getElementById("cgu-checkbox");
                const submitButton = document.getElementById("submit-button");
                checkbox.addEventListener("change", function () {
                    submitButton.disabled = !checkbox.checked;
                });
            });
        </script>
    </body>
</html>
