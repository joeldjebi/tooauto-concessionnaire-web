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

        <div class="row mb-1">
            <h5 class="card-title">Envoi groupé d'offres aux gestionnaires de flotte.</h5>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <form action="{{ route('store.offre') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                    <div class="input-blocks">
                                        <label class="form-label">Fichier (Charger l'offre)</label>
                                        <input type="file" class="form-control" name="offre">
                                        <input type="hidden" name="global" value="1">
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center mt-3">
                                    <button type="submit" class="btn btn-primary">Envoyer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="input-blocks">
                            <a href="{{ route('flotte.sent') }}" class="btn btn-info">Liste des offres envoyées</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <h5 class="card-title">Liste des gestionnaires de flotte</h5>
        </div>

        @if (!empty($gestionnaireDeFlottes) && count($gestionnaireDeFlottes) > 0)
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Prénoms</th>
                                            <th>E-mail</th>
                                            <th>Contact</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($gestionnaireDeFlottes->isNotEmpty())
                                            @foreach ($gestionnaireDeFlottes as $key => $item)
                                                <div class="modal fade" id="show{{ $item->id }}" tabindex="-1" role="dialog"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Envoyer un offre </h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('store.offre') }}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-sm-12">
                                                                            <div class="input-blocks">
                                                                                <label class="form-label">Fichier (Charger l'offre)</label>
                                                                                <input type="file" class="form-control" name="offre" value="{{ $user->nom }}">
                                                                                <input type="hidden" name="user_id" value="{{ $item->id }}">
                                                                                <input type="hidden" name="global" value="0">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 text-center mt-3">
                                                                            <button type="submit" class="btn btn-primary">Envoyer</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->nom }}</td>
                                                    <td>{{ $item->prenoms }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->mobile }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <!-- Boutons Edit et Delete alignés à gauche -->
                                                            <a class="me-3 btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#show{{ $item->id }}">
                                                                Envoyer une offre individuel
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <p>Aucune annonce enregistrer pour le moment !</p>
        @endif
    </div>

</div>
@include('layouts.footer')
