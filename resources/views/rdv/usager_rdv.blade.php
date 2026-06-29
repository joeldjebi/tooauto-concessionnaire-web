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

        <div class="row mb-2">
            <h5 class="card-title">Liste des demandes de rendez-vous</h5>
        </div>

        @if (!empty($rdv_concessionnaires) && count($rdv_concessionnaires) > 0)
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Jour</th>
                                            <th>Heure</th>
                                            <th>Statut</th>
                                            <th>Usager</th>
                                            <th>Contact du usager</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($rdv_concessionnaires->isNotEmpty())
                                            @foreach ($rdv_concessionnaires as $key => $item)

                                                @php
                                                    // Conversion en entier pour s'assurer de la comparaison correcte
                                                    $statutValue = (int) $item->statut;
                                                    
                                                    switch ($statutValue) {
                                                        case 0:
                                                            $statut = 'En attente';
                                                            $statutClass = 'badge-warning';
                                                            break;
                                                        case 1:
                                                            $statut = 'Accepté';
                                                            $statutClass = 'badge-success';
                                                            break;
                                                        case 2:
                                                            $statut = 'Annulé';
                                                            $statutClass = 'badge-danger';
                                                            break;
                                                        case 3:
                                                            $statut = 'Indisponible';
                                                            $statutClass = 'badge-secondary';
                                                            break;
                                                        default:
                                                            $statut = 'Inconnu';
                                                            $statutClass = 'badge-dark';
                                                    }
                                                @endphp

                                                <div class="modal fade" id="show{{ $item->id }}" tabindex="-1" role="dialog"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Détails du rendez-vous</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('store.concessionnaire-rdv') }}" method="POST">
                                                                    @csrf
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="mobile">Statut de la demande de rendez-vous</label>
                                                                            <select class="form-control" name="statut" id="statutSelect{{ $item->id }}">
                                                                                <option value="0" {{ $item->statut == 0 ? 'selected' : '' }}>En attent</option>
                                                                                <option value="1" {{ $item->statut == 1 ? 'selected' : '' }}>Accepté</option>
                                                                                <option value="2" {{ $item->statut == 2 ? 'selected' : '' }}>Annulé</option>
                                                                                <option value="3" {{ $item->statut == 3 ? 'selected' : '' }}>Indisponible</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="heure{{ $item->id }}" class="form-label">Date et heure (si accepté)</label>
                                                                        <input type="datetime-local" class="form-control" name="heure" id="heure{{ $item->id }}" value="{{ $item->heure ?? '' }}">
                                                                    </div>
                                                                    <div class="updateRdv" id="updateRdv{{ $item->id }}" style="display: none;">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="jour{{ $item->id }}" class="form-label">Jour du RDV</label>
                                                                                <select class="form-control" name="jour" id="jour{{ $item->id }}">
                                                                                    <option value="Lundi">Lundi</option>
                                                                                    <option value="Mardi">Mardi</option>
                                                                                    <option value="Mercredi">Mercredi</option>
                                                                                    <option value="Jeudi">Jeudi</option>
                                                                                    <option value="Vendredi">Vendredi</option>
                                                                                    <option value="Samedi">Samedi</option>
                                                                                    <option value="Dimanche">Dimanche</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="rdv_id" value="{{ $item->id }}">
                                                                    <div class="form-group">
                                                                        <label for="description">Commentaire pour l'usager (Facultatif)</label>
                                                                        <textarea name="reponse_concessionnaire" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <button class="btn btn-primary">Enregistrer</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->jour }}</td>
                                                    <td>
                                                        @if($item->heure)
                                                            {{ \Carbon\Carbon::parse($item->heure)->format('d/m/Y à H:i') }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td style="color: {{ $statutClass }};">{{ $statut }}</td>
                                                    <td style="color: #000;">{{ $item->user ? ($item->user->nom ?? '') . ' ' . ($item->user->prenom ?? '') : 'N/A' }}</td>
                                                    <td>{{ $item->user ? ($item->user->mobile ?? '') : 'N/A' }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <!-- Boutons Edit et Delete alignés à gauche -->
                                                            <a href="" class="mt-2" data-bs-toggle="modal" data-bs-target="#show{{ $item->id }}">
                                                                <img src="../assets/img/icons/edit.svg" alt="img">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fonction pour gérer l'affichage des champs selon le statut
        function toggleRdvFields(selectElement) {
            const statut = selectElement.value;
            const itemId = selectElement.id.replace('statutSelect', '');
            const updateRdvDiv = document.getElementById('updateRdv' + itemId);
            
            if (statut == '1') { // Accepté - afficher les champs de date/heure
                if (updateRdvDiv) {
                    updateRdvDiv.style.display = 'block';
                }
            } else {
                if (updateRdvDiv) {
                    updateRdvDiv.style.display = 'none';
                }
            }
        }

        // Attacher l'événement à tous les selects de statut
        document.querySelectorAll('select[name="statut"]').forEach(function(select) {
            // Initialiser l'affichage
            toggleRdvFields(select);
            
            // Attacher l'événement de changement
            select.addEventListener('change', function() {
                toggleRdvFields(this);
            });
        });
    });
</script>
@include('layouts.footer')
