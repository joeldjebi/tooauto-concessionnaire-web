<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .otp-input {
            letter-spacing: 0.3em;
            font-size: 1.5em;
            text-align: center;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="account-page bg-white">
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="../assets/img/logo.png" alt="logo">
                        </div>
                        <div class="login-userheading">
                            <h3>Vérification du code OTP</h3>
                            <h4>Veuillez saisir le code reçu par SMS</h4>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('auth.otp.verify') }}" method="POST">
                            @csrf
                            <div class="form-login">
                                <label for="otp">Code OTP</label>
                                <input type="text" id="otp" name="otp" class="form-control otp-input" maxlength="6" placeholder="------" required autofocus>
                            </div>
                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Vérifier</button>
                            </div>
                            <div class="form-login">
                                <a href="{{ route('login') }}" class="btn btn-secondary">Retour à la connexion</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="login-img">
                    <img src="../assets/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
