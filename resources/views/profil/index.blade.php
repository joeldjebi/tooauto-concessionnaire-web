@include('layouts.header')
@include('layouts.menu')
<div class="page-wrapper">
    <div class="content">
        @include('layouts.fileariane')
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

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Mise a jour du mot de passe</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('password.update') }}" method="post">
                            @csrf
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">Ancien mot de passe</label>
                                    <div class="pass-group">
                                        <input type="oldpassword" name="oldpassword" class="pass-input form-control mb-2">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <div class="pass-group">
                                        <input type="newpassword" name="newpassword" class="pass-input form-control mb-2">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">Confirmez votre mot de passe</label>
                                    <div class="pass-group">
                                        <input type="confirmpassword" name="confirmpassword" class="pass-input form-control mb-2">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-5">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-set">
                            <div class="profile-top">
                                <div class="profile-content">
                                    <div class="profile-contentname">
                                        <h2>{{ $user->nom }} {{ $user->prenoms }}</h2>
                                        <h4>Mettez a jour vos informations personnelles.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('profil.update') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="input-blocks">
                                        <label class="form-label">Nom</label>
                                        <input type="text" class="form-control" name="nom" value="{{ $user->nom }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="input-blocks">
                                        <label class="form-label">Prenoms</label>
                                        <input type="text" class="form-control mb-3" name="prenoms" value="{{ $user->prenoms }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="input-blocks">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control mb-3" value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Numero de téléphone </label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroup-sizing-default">+225</span>
                                              <input type="number" name="mobile" class="form-control" value="{{ $user->mobile }}">
                                        </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
