
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Connexion</title>

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

                            <form action="{{ route('logins') }}" method="POST">
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
                                        <h3>Se connecter</h3>
                                        <h4>Accédez au panneau Dreamspos en utilisant votre e-mail et votre mot de passe.</h4>
                                    </div>
                                    <div class="form-login">
                                        <label class="form-label">Adresse E-mail </label>
                                        <div class="input-group">
                                              <input type="text" class="form-control" name="email">
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <label>Mot de passe</label>
                                        <div class="pass-group">
                                            <input type="password" class="pass-input" name="password" id="password">
                                            <span class="fas toggle-password fa-eye-slash" id="togglePassword"></span>
                                        </div>
                                    </div>
                                    <div class="form-login authentication-check">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                                        <input type="checkbox">
                                                        <span class="checkmarks"></span>Souviens-toi de moi
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <a class="forgot-link" href="{{ route('password.forget') }}">Mot de passe oublié?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <button class="btn btn-login" type="submit">Se connecter</button>
                                    </div>
                                    <div class="signinform">
                                        <h4>Nouveau sur notre plateforme ?<a href="{{ route('register') }}" class="hover-a"> Créez un compte</a></h4>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                            <p>Copyright © 2023 DreamsPOS. All rights reserved</p>
                        </div>
                    </div>
                </div>
			</div>
        <div class="sidebar-settings nav-toggle" id="layoutDiv"><div class="sidebar-content sticky-sidebar-one"><div class="sidebar-header"><div class="sidebar-theme-title"><h5>Theme Customizer</h5><p>Customize &amp; Preview in Real Time</p></div><div class="close-sidebar-icon d-flex"><a class="sidebar-refresh me-2" onclick="resetData()">⟳</a><a class="sidebar-close" href="#">X</a></div></div><div class="sidebar-body p-0"><form id="theme_color" method="post"><div class="theme-mode mb-0"><div class="theme-body-main"><div class="theme-head"><h6>Theme Mode</h6><p>Enjoy Dark &amp; Light modes.</p></div><div class="row"><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="theme-mode" id="light_mode" class="check color-check stylemode lmode" value="light_mode" checked=""><label for="light_mode" class="checktoggles"><img src="assets/img/theme/theme-img-01.jpg" alt=""><span class="theme-name">Light Mode</span></label></div></div></div></div><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="theme-mode" id="dark_mode" class="check color-check stylemode" value="dark_mode"><label for="dark_mode" class="checktoggles"><img src="assets/img/theme/theme-img-02.jpg" alt=""><span class="theme-name">Dark Mode</span></label></div></div></div></div></div><form id="template_direction" method="post"><div class="theme-mode border-0"><div class="theme-head"><h6>Direction</h6><p>Select the direction for your app.</p></div><div class="row"><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="direction" id="ltr" class="check direction" value="ltr" checked=""><label for="ltr" class="checktoggles"><a href="../template/index.html"><img src="assets/img/theme/theme-img-01.jpg" alt=""></a><span class="theme-name">LTR</span></label></div></div></div></div><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="direction" id="rtl" class="check direction" value="rtl"><label for="rtl" class="checktoggles"><a href="../template-rtl/index.html" target="_blank"><img src="assets/img/theme/theme-img-03.jpg" alt=""></a><span class="theme-name">RTL</span></label></div></div></div></div></div><form id="layout_mode" method="post"><div class="theme-mode border-0 mb-0"><div class="theme-head"><h6>Layout Mode</h6><p>Select the primary layout style for your app.</p></div><div class="row"><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="layout" id="default_layout" class="check layout-mode" value="default"><label for="default_layout" class="checktoggles"><img src="assets/img/theme/theme-img-01.jpg" alt=""><span class="theme-name">Default</span></label></div></div></div></div><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="layout" id="box_layout" class="check layout-mode" value="box"><label for="box_layout" class="checktoggles"><img src="assets/img/theme/theme-img-07.jpg" alt=""><span class="theme-name">Box</span></label></div></div></div></div><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="layout" id="collapse_layout" class="check layout-mode" value="collapsed"><label for="collapse_layout" class="checktoggles"><img src="assets/img/theme/theme-img-05.jpg" alt=""><span class="theme-name">Collapsed</span></label></div></div></div></div><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="layout" id="horizontal_layout" class="check layout-mode" value="horizontal"><label for="horizontal_layout" class="checktoggles"><img src="assets/img/theme/theme-img-06.jpg" alt=""><span class="theme-name">Horizontal</span></label></div></div></div></div><div class="col-xl-6 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="layout" id="modern_layout" class="check layout-mode" value="modern"><label for="modern_layout" class="checktoggles"><img src="assets/img/theme/theme-img-04.jpg" alt=""><span class="theme-name">Modern</span></label></div></div></div></div></div></div></form><form id="nav_color" method="post"><div class="theme-mode"><div class="theme-head"><h6>Navigation Colors</h6><p>Setup the color for the Navigation</p></div><div class="row"><div class="col-xl-4 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="nav_color" id="light_color" class="check nav-color" value="light"><label for="light_color" class="checktoggles"><span class="theme-name">Light</span></label></div></div></div></div><div class="col-xl-4 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="nav_color" id="grey_color" class="check nav-color" value="grey"><label for="grey_color" class="checktoggles"><span class="theme-name">Grey</span></label></div></div></div></div><div class="col-xl-4 ere"><div class="layout-wrap"><div class="d-flex align-items-center"><div class="status-toggle d-flex align-items-center me-2"><input type="radio" name="nav_color" id="dark_color" class="check nav-color" value="dark"><label for="dark_color" class="checktoggles"><span class="theme-name">Dark</span></label></div></div></div></div></div></div></form></div></form></div><div class="sidebar-footer"><div class="row"><div class="col-xl-6"><div class="footer-preview-btn"><button type="button" class="btn btn-secondary w-100" onclick="resetData()">Reset</button></div></div><div class="col-xl-6"><div class="footer-reset-btn"><a href="#" class="btn btn-primary w-100">Buy Now</a> </div></div></div></div></div></form></div></div></div></div>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const passwordInput = document.querySelector(".pass-input");
                const togglePassword = document.querySelector(".toggle-password");

                togglePassword.addEventListener("click", function () {
                    // Vérifie le type actuel et bascule entre "text" et "password"
                    const currentType = passwordInput.getAttribute("type");
                    const newType = currentType === "password" ? "text" : "password";
                    passwordInput.setAttribute("type", newType);

                    // Change l'icône pour refléter l'état actuel
                    togglePassword.classList.toggle("fa-eye");
                    togglePassword.classList.toggle("fa-eye-slash");
                });
            });
        </script>
    </body>



</html>
