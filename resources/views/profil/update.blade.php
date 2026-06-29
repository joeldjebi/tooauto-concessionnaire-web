@include('layouts.header')
@include('layouts.menu')
<div class="page-wrapper">
    <div class="content">
        @include('layouts.fileariane')
        
        <!-- Messages d'alerte améliorés -->
        @if(session()->has("message"))
            <div class="alert alert-dismissible {{session()->get('type')}} alert-custom mb-4">
                <i class="fas fa-check-circle me-2"></i>
                {{ session()->get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Erreurs détectées :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-edit me-3 fs-4"></i>
                            <h5 class="card-title mb-0">Modifier votre profil</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- Colonne gauche -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="nom" class="form-label fw-semibold">
                                            <i class="fas fa-user me-2 text-primary"></i>Nom
                                        </label>
                                        <input type="text" name="nom" class="form-control form-control-lg" 
                                               value="{{ $user->nom }}" placeholder="Votre nom">
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="prenom" class="form-label fw-semibold">
                                            <i class="fas fa-user me-2 text-primary"></i>Prénom
                                        </label>
                                        <input type="text" name="prenoms" class="form-control form-control-lg" 
                                               value="{{ $user->prenoms }}" placeholder="Votre prénom">
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label fw-semibold">
                                            <i class="fas fa-envelope me-2 text-primary"></i>Email
                                        </label>
                                        <input type="email" class="form-control form-control-lg bg-light" 
                                               value="{{ $user->email }}" disabled>
                                        <small class="form-text text-muted">L'email ne peut pas être modifié</small>
                                    </div>
                                </div>
                                
                                <!-- Colonne droite -->
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="mobile" class="form-label fw-semibold">
                                            <i class="fas fa-phone me-2 text-primary"></i>Téléphone
                                        </label>
                                        <input type="text" name="mobile" class="form-control form-control-lg" 
                                               value="{{ $user->mobile }}" placeholder="Votre numéro de téléphone">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alert-custom {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control-lg {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:hover {
    border-color: #0d6efd;
}

.btn-lg {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
}

.form-label {
    color: #495057;
    margin-bottom: 8px;
}

.card-header {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
}
</style>

@include('layouts.footer')
