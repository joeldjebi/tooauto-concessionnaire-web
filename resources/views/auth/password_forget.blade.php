<!DOCTYPE html>
<html lang="en">
    <head>

		<!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
		<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
		<meta name="author" content="Dreams Technologies">
		<meta name="robots" content="index, follow">
		<title>Dreams POS - Inventory Management & Admin Dashboard Template</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="../assets/img/apple-touch-icon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

        <!-- Tabler Icon CSS -->
	    <link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler-icons.css">

	    <!-- Main CSS -->
        <link rel="stylesheet" href="../assets/css/style.css">

    </head>
    <body class="account-page bg-white">
		<!-- Main Wrapper -->
		<div class="main-wrapper">
			<div class="account-content">
				<div class="login-wrapper">
					<div class="login-content">
						<div class="login-userset">
							<div class="login-logo">
								<img src="../assets/img/logo.png" alt="img">
							</div>
							<div class="login-userheading">
								<h3>Mot de passe oublié</h3>
								<h4>Entrez votre numéro de téléphone pour recevoir un code OTP</h4>
							</div>
							<form action="{{ route('post-password.forget') }}" method="POST">
								@csrf
								<div class="form-login">
									<label>Numéro de téléphone</label>
									<div class="form-addons">
										<div class="input-group">
											<input type="number" class="form-control" name="phone" placeholder="Entrez votre numéro de téléphone" required>
										</div>
									</div>
								</div>
								<div class="form-login">
									<button type="submit" class="btn btn-login">Envoyer le code OTP</button>
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
		<!-- /Main Wrapper -->
	</body>
</html>