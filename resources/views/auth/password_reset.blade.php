<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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
                            <h3>Réinitialisation du mot de passe</h3>
                            <h4>Veuillez saisir votre nouveau mot de passe</h4>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('password.reset.submit') }}" method="POST">
                            @csrf
                            <div class="form-login">
                                <label for="password">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" class="form-control" required minlength="8" placeholder="Nouveau mot de passe">
                            </div>
                            <div class="form-login">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8" placeholder="Confirmez le mot de passe">
                            </div>
                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Réinitialiser le mot de passe</button>
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
