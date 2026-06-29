
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>S'inscrire</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

		<!-- Main CSS -->
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
        </style>

    </head>
    <body class="account-page">
		<div class="main-wrapper">
			<div class="account-content">
				<div class="login-wrapper login-new">
                    <div class="container">
                        <div class="login-content user-login">

                            <form action="{{ route('registers') }}" method="POST">
                                <div class="login-logo">
                                    <img src="assets/img/logo.png"  width="100" alt="img">
                                    <a href="index.html" class="login-logo logo-white">
                                        <img src="assets/img/logo-white.png" alt="">
                                    </a>
                                </div>
                                @csrf
                                <div class="login-userset">
                                    @if(session()->has("message"))
                                        <div style="padding: 10px" class="alert {{session()->get('type')}}">{{ session()->get('message') }} </div>
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
                                        <h3>S'inscrire</h3>
                                        <h4>Créer un nouveau compte TOOauto en toute sérénité et en toute transparence</h4>
                                    </div>
                                    <div class="form-login">
                                        <label>Nom</label>
                                        <div class="form-addons">
                                            <input type="text" class="form-control" name="nom" required>
                                            <img src="../assets/img/icons/user-icon.svg" alt="image">
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <label>Prénoms</label>
                                        <div class="form-addons">
                                            <input type="text" class="form-control" name="prenoms" required>
                                            <img src="../assets/img/icons/user-icon.svg" alt="image">
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <label>Adresse e-mail</label>
                                        <div class="form-addons">
                                            <input type="text" class="form-control" name="email" required>
                                            <img src="../assets/img/icons/user-icon.svg" alt="image">
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <label>Numéro de téléphone</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+225</span>
                                            <input type="text" class="form-control" name="mobile" required>
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
                                        <button class="btn btn-login" type="submit" id="submit-button" disabled>S'inscrire</button>
                                    </div>
                                    <div class="signinform">
                                        <h4>Vous avez déjà un compte ? <a href="{{ route('login') }}" class="hover-a">Connectez-vous</a></h4>
                                        <h4>Créer le compte et le concessionnaire ? <a href="{{ route('register.concessionnaire') }}" class="hover-a">Inscription concessionnaire</a></h4>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
			</div>
            <div class="sidebar-settings nav-toggle" id="layoutDiv">
                <div class="sidebar-content sticky-sidebar-one">
                    <div class="sidebar-header">
                        <div class="sidebar-theme-title">
                            <h5>Theme Customizer</h5>
                            <p>Customize &amp; Preview in Real Time</p></div>
                            <div class="close-sidebar-icon d-flex">
                                <a class="sidebar-refresh me-2" onclick="resetData()">⟳</a>
                                <a class="sidebar-close" href="#">X</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Sélectionne tous les éléments avec la classe "toggle-password"
                const toggleIcons = document.querySelectorAll(".toggle-password");

                toggleIcons.forEach(toggleIcon => {
                    toggleIcon.addEventListener("click", function () {
                        // Récupère l'id du champ cible via l'attribut "data-target"
                        const targetId = this.getAttribute("data-target");
                        const targetInput = document.getElementById(targetId);

                        // Bascule le type du champ entre "password" et "text"
                        const currentType = targetInput.getAttribute("type");
                        const newType = currentType === "password" ? "text" : "password";
                        targetInput.setAttribute("type", newType);

                        // Change l'icône pour refléter l'état actuel
                        this.classList.toggle("fa-eye");
                        this.classList.toggle("fa-eye-slash");
                    });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const checkbox = document.getElementById("cgu-checkbox");
                const submitButton = document.getElementById("submit-button");

                // Désactive ou active le bouton selon l'état de la checkbox
                checkbox.addEventListener("change", function () {
                    submitButton.disabled = !checkbox.checked;
                });
            });
        </script>
    </body>

</html>
