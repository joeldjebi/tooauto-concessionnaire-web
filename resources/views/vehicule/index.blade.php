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
            <div class="col-md-9">
             <h5 class="card-title">Les vehicules</h5>
            </div>
            <div class="col-md-2 text-end">
                <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addVehicule">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                        Nouveau véhicule
                    </font></font>
                </a>
            </div>
        </div>

        @if (!empty($vehiculeConcessionnaires) && count($vehiculeConcessionnaires) > 0)
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Photo</th>
                                            <th>Nom du vehicule</th>
                                            <th>Temps de garantie</th>
                                            <th>Marque</th>
                                            <th>Modèle</th>
                                            <th>Prix</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($vehiculeConcessionnaires->isNotEmpty())
                                            @foreach ($vehiculeConcessionnaires as $key => $item)
                                            {{-- @php
                                                @dd($item->photos)
                                            @endphp --}}
                                                <div class="modal fade" id="editArticle-{{ $item->id }}" tabindex="-1" role="dialog"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier un véhicule</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('vehicule.update', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="mobile">Nom du véhicule</label>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="name" value="{{ $item->name }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="mobile">Marque du véhicule</label>
                                                                                <select class="form-control" name="marque_id" id="">
                                                                                    @foreach ($marques as $marque)
                                                                                        <option value="{{ $marque->id }}" {{ $item->marque_id == $marque->id ? 'selected' : '' }}>{{ $marque->libelle }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="mobile">Modèle du véhicule</label>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="modele" value="{{ $item->modele }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
																		<div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="mobile">Temps de garantie</label>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="garantie" value="{{ $item->garantie }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="mobile">Prix du véhicule</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text" id="inputGroup-sizing-default">F CFA</span>
                                                                                    <input type="number" class="form-control" name="prix" value="{{ $item->prix }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>                                                                    </div>
                                                                        <div class="form-group">
                                                                            <label for="description">Description</label>
                                                                            <textarea name="description" class="form-control" required>{{ $item->description }}</textarea>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="">Photos actuelles du véhicule</label>
                                                                                @if (!empty($item->photos) && is_array($item->photos))
                                                                                    <div class="row mb-3">
                                                                                        @foreach($item->photos as $index => $photo)
                                                                                            @php($photoUrl = $item->photo_urls[$index] ?? asset($photo))
                                                                                            <div class="col-md-3 mb-2" id="photo-container-{{ $item->id }}-{{ $index }}">
                                                                                                <div class="position-relative">
                                                                                                    <img src="{{ $photoUrl }}" class="img-thumbnail" alt="Photo véhicule" style="width: 100%; height: 150px; object-fit: cover;">
                                                                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                                                                                            onclick="removePhoto({{ $item->id }}, {{ $index }}, '{{ $photo }}')" 
                                                                                                            style="margin: 5px;">
                                                                                                        <i class="fas fa-times"></i>
                                                                                                    </button>
                                                                                                    <input type="hidden" name="existing_photos[]" value="{{ $photo }}" id="existing-photo-{{ $item->id }}-{{ $index }}">
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                @else
                                                                                    <p class="text-muted">Aucune photo actuellement</p>
                                                                                @endif
                                                                            </div>
                                                                            
                                                                            <div class="form-group">
                                                                                <label for="">Ajouter de nouvelles photos</label>
                                                                                <input type="file" class="form-control" name="photos[]" multiple accept="image/*">
                                                                                <small class="form-text text-muted">Sélectionnez de nouvelles photos à ajouter</small>
                                                                            </div>
                                                                        </div>
																	<div class="col-md-12">
																		<div class="form-group">
																			<label for="">Fichier</label>
																			<input class="form-control" name="fichier" type="file">
																			@if (!empty($item->fichier))
																			<a target="_blank" href="{{ $item->fichier_url }}">
																				Fichier
																			</a>
																			@endif
																		</div>
																	</div>
                                                                    </div>
                                                                    <div class="modal-footer text-center">
                                                                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Fermé</button>
                                                                        <button class="btn btn-submit">Envoyé</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="show{{ $item->id }}" tabindex="-1" role="dialog"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Détails de l'article</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="productdetails">
                                                                    <ul class="product-bar">
                                                                        <li>
                                                                            <h4>Image</h4>
                                                                            @if (!empty($item->photos) && is_array($item->photos))
                                                                                <div>
                                                                                    @foreach($item->photos as $index => $photo)
                                                                                        <img src="{{ $item->photo_urls[$index] ?? asset($photo) }}" class="d-block w-100" alt="Photo véhicule">
                                                                                    @endforeach
                                                                                </div>
                                                                            @endif
                                                                        </li>
                                                                        <li>
                                                                            <h4>Nom du véhicule</h4>
                                                                            <h6>{{ $item->name }}</h6>
                                                                        </li>
																		<li>
                                                                            <h4>Temps de garantie</h4>
                                                                            <h6>{{ $item->garantie }}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h4>Prix du véhicule</h4>
                                                                            <h6>{{ number_format($item->prix, 0, ',', ' ') }} F CFA</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h4>Description</h4>
                                                                            <h6>{!! html_entity_decode($item->description) !!},</h6>
                                                                        </li>
																		<li>
                                                                            <h4>Fichier</h4>
																			<h6>
																				@if (!empty($item->fichier))
																				<a target="_blank" href="{{ $item->fichier_url }}">
																					Fichier
																				</a>
																				@endif
																			</h6>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        @if (!empty($item->photos) && is_array($item->photos))
                                                            <img width="50" height="50" src="{{ $item->photo_urls[0] ?? asset($item->photos[0]) }}" alt="{{ $item->name }}">
                                                        @else
                                                            <span>Aucune image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->garantie }}</td>
                                                    <td>{{ $item->marque->libelle }}</td>
                                                    <td>{{ $item->modele }}</td>
                                                    <td>{{ number_format($item->prix, 0, ',', ' ') }} F CFA</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <!-- Boutons Edit et Delete alignés à gauche -->
                                                            <a title="Modifier" href="" class="mt-2" data-bs-toggle="modal" data-bs-target="#editArticle-{{ $item->id }}">
                                                                <img src="../assets/img/icons/edit.svg" alt="img">
                                                            </a>
                                                            <a title="Voir les détaisls" class="me-3" data-bs-toggle="modal"
                                                                data-bs-target="#show{{ $item->id }}">
                                                                <img src="../assets/img/icons/eye.svg" alt="img">
                                                            </a>
                                                            <form id="deleteForm{{ $item->id }}" action="{{ route('vehicule.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button title="Supprimer" type="button" class="btn btn-link" onclick="confirmDelete({{ $item->id }})">
                                                                    <img src="../assets/img/icons/delete.svg" alt="img">
                                                                </button>
                                                            </form>
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
            <p>Aucun articles enregistrer pour le moment !</p>
        @endif
    </div>

    <div class="modal fade" id="addVehicule" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un véhicule</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vehicule.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mobile">Nom du véhicule</label>
                                    <div class="input-group">
                                          <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                            </div>
							<div class="col-12">
                                <div class="form-group">
                                    <label for="mobile">Temps de garantie</label>
                                    <div class="input-group">
                                          <input type="text" class="form-control" name="garantie">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mobile">Marque du véhicule</label>
                                    <select class="form-control" name="marque_id" id="">
                                        @foreach ($marques as $item)
                                            <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mobile">Modèle du véhicule </label>
                                    <div class="input-group">
                                          <input type="text" class="form-control" name="modele">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mobile">Prix du véhicule (Facultatif)</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroup-sizing-default">F CFA</span>
                                          <input type="number" class="form-control" name="prix">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Photos du véhicule</label>
                                    <input type="file" class="form-control" name="photos[]" multiple>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Fichier (PDF, Word, etc.)</label>
                                    <input type="file" class="form-control" name="fichier">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description du véhicule</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Fermé</button>
                            <button class="btn btn-submit">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removePhoto(vehicleId, photoIndex, photoPath) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')) {
        // Masquer le conteneur de la photo
        document.getElementById('photo-container-' + vehicleId + '-' + photoIndex).style.display = 'none';
        
        // Marquer la photo comme supprimée en ajoutant un champ hidden
        var deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'deleted_photos[]';
        deleteInput.value = photoPath;
        document.querySelector('form[action*="' + vehicleId + '"]').appendChild(deleteInput);
        
        // Supprimer le champ existing_photos correspondant
        var existingPhotoInput = document.getElementById('existing-photo-' + vehicleId + '-' + photoIndex);
        if (existingPhotoInput) {
            existingPhotoInput.remove();
        }
    }
}

function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')) {
        document.getElementById('deleteForm' + id).submit();
    }
}
</script>

@include('layouts.footer')
