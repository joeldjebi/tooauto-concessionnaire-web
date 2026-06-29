
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
		<meta name="author" content="Dreamguys - Bootstrap Admin Template">
		<meta name="robots" content="noindex, nofollow">
		<title>Tableau de bord</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">

		<!-- animation CSS -->
        <link rel="stylesheet" href="../assets/css/animate.css">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">

		<!-- Datatable CSS -->
		<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">

        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

		<!-- Feather CSS -->
		<link rel="stylesheet" href="../assets/plugins/icons/feather/feather.css">

		<!-- Wizard CSS -->
		<link rel="stylesheet" href="../assets/plugins/twitter-bootstrap-wizard/form-wizard.css">

		<!-- Main CSS -->
        <link rel="stylesheet" href="../assets/css/style.css">
		<link rel="stylesheet" href="../assets/css/main.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


		<link rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
		<link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.0/css/buttons.dataTables.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
		<style>
			div#global-loader {
				display: none;
			}
		</style>

	</head>
	<body>
		<div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div>
		<!-- Main Wrapper -->
		<div class="main-wrapper">

			<!-- Header -->
			<div class="header">

				<!-- Logo -->
				 <div class="header-left active">
					<a href="index.html" class="logo logo-normal">
						<img src="../assets/img/logo.png"  alt="">
					</a>
					<a href="index.html" class="logo logo-white">
						<img src="../assets/img/logo-white.png"  alt="">
					</a>
					<a href="index.html" class="logo-small">
						<img src="../assets/img/logo-small.png"  alt="">
					</a>
					<a id="toggle_btn" href="javascript:void(0);">
						<i data-feather="chevrons-left" class="feather-16"></i>
					</a>
				</div>
				<!-- /Logo -->

				<a id="mobile_btn" class="mobile_btn" href="#sidebar">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>

				<!-- Header Menu -->
				<ul class="nav user-menu">

					<!-- Search -->
					<li class="nav-item nav-searchinputs">
						<div class="top-nav-search">
						</div>
					</li>
					{{-- @if ($daysRemaining > 0)
                        {{ $daysRemaining }} jour(s)
                    @else
                        <span class="text-danger">Abonnement expiré</span>
                    @endif --}}
					<!-- /Search -->
					<li class="nav-item dropdown has-arrow main-drop">
						<a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
							<span class="user-info">
								@if (!empty($etablissement))
									<span class="user-letter">
										<img src="/etablissement/logo/{{ $etablissement->logo }}" alt="" class="img-fluid">
									</span>
								@endif
								@if (!empty($user))
								<span class="user-detail">
									<span class="user-name">{{ $user->prenoms }} {{ $user->nom }}</span>
									<span class="user-role">{{ $user->role == '01' ? "Super Admin" : 'Utilisateur' }}</span>
								</span>
								@endif
							</span>
						</a>
						<div class="dropdown-menu menu-drop-user">
							<div class="profilename">
								<div class="profileset">
									@if (!empty($etablissement))
										<span class="user-img">
											<img src="/etablissement/logo/{{ $etablissement->logo }}" alt="">
											<span class="status online"></span>
										</span>
									@endif
									<div class="profilesets">
										@if (!empty($user))
											<h6>{{ $user->prenoms }} {{ $user->nom }}</h6>
											<h5>{{ $user->role == '01' ? "Super Admin" : 'Utilisateur' }}</h5>
										@endif
									</div>
								</div>
								<hr class="m-0">

								<hr class="m-0">
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
								<a class="dropdown-item logout pb-0" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									<img src="../assets/img/icons/log-out.svg" class="me-2" alt="img">Déconexion</a>
							</div>
						</div>
					</li>
				</ul>
				<!-- /Header Menu -->

				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
						<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v mt-2"></i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="{{ route('profil.index') }}"><i class="me-2"  data-feather="user"></i>Mon Profil</a>
						<form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
						<a class="dropdown-item logout pb-0" href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();"><img src="../assets/img/icons/log-out.svg" class="me-2" alt="img">Déconnexion</a>
					</div>
				</div>
				<!-- /Mobile Menu -->
			</div>
			<!-- Header -->
