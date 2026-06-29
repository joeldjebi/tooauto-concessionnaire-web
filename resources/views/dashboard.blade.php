

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
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget w-100">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $vehiculeCount }}</span></h5>
                        <h6>MES VÉHICULES</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash1 w-100">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $countRdvEnattente }}</span></h5>
                        <h6>MES RENDEZ-VOUS EN ATTENTES</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash2 w-100">
                    <div class="dash-widgetimg">
                        <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span class="counters">{{ $countAnnonce }}</span></h5>
                        <h6>LES ANNONCES</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <h5 class="card-title">Liste des annonces</h5>
        </div>
        @if (!empty($annonceconcessionnaires) && count($annonceconcessionnaires) > 0)
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type de vehicule</th>
                                            <th>Marque</th>
                                            <th>Modèle</th>
                                            <th>Type de demande</th>
                                            <th>Client</th>
                                            <th>Numero du client</th>
                                            <th>Date de l'annonce</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($annonceconcessionnaires->isNotEmpty())
                                            @foreach ($annonceconcessionnaires as $key => $item)
                                                <div class="modal fade" id="show{{ $item->id }}" tabindex="-1" role="dialog"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Détails de l'annonce</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="productdetails">
                                                                    <ul class="product-bar">
                                                                        <li>
                                                                            <h4>Type de véhicule</h4>
                                                                            <h6>{{ $item->type_de_vehicule ? $item->type_de_vehicule->libelle : '' }}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h4>Marque du véhicule</h4>
                                                                            <h6>{{ $item->marque ? $item->marque->libelle : '' }}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h4>Modèle du véhicule</h4>
                                                                            <h6>{{ $item->modele ? $item->modele : '' }}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h4>Type de demande</h4>
                                                                            <h6>{{ $item->type_de_demande ? $item->type_de_demande->libelle : '' }}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h4>Nom et prénoms du client</h4>
                                                                            <h6>{{ $item->gestionnaire_de_flotte ? $item->gestionnaire_de_flotte->nom : '' }} {{ $item->gestionnaire_de_flotte ? $item->gestionnaire_de_flotte->prenoms : '' }}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h4>Contact du client</h4>
                                                                            <h6>{{ $item->gestionnaire_de_flotte ? $item->gestionnaire_de_flotte->mobile : '' }}</h6>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->type_de_vehicule ? $item->type_de_vehicule->libelle : '' }}</td>
                                                    <td>{{ $item->marque ? $item->marque->libelle : '' }}</td>
                                                    <td>{{ $item->modele ? $item->modele : '' }}</td>
                                                    <td>{{ $item->type_de_demande ? $item->type_de_demande->libelle : '' }}</td>
                                                    <td>{{ $item->gestionnaire_de_flotte ? $item->gestionnaire_de_flotte->nom : '' }} {{ $item->gestionnaire_de_flotte ? $item->gestionnaire_de_flotte->prenoms : '' }}</td>
                                                    <td>{{ $item->gestionnaire_de_flotte ? $item->gestionnaire_de_flotte->mobile : '' }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <!-- Boutons Edit et Delete alignés à gauche -->
                                                            <a class="me-3" data-bs-toggle="modal"
                                                                data-bs-target="#show{{ $item->id }}">
                                                                <img src="../assets/img/icons/eye.svg" alt="img">
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
