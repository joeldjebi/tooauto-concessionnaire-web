{{-- @php
    $tableTypePrestation = json_decode($concessionnaire->type_de_prestations, true);
@endphp --}}


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

        <div class="card">
            <div class="card-body add-product pb-0">
                <form action="{{ route('concessionnaire.update', ['id' => $concessionnaire->id ]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Nom de l'établissement</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $concessionnaire->name) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="mobile">Numero Mobile</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroup-sizing-default">+225</span>
                                      <input type="number" class="form-control" name="contact" value="{{ old('contact', $concessionnaire->contact) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="mobile">Ce numéro mobile est Whatsapp ?</label>
                                <input type="radio" name="is_whatsapp" {{ $concessionnaire->is_whatsapp == '0' ? 'checked' : '' }} value="0"> Non
                                <input type="radio" name="is_whatsapp" {{ $concessionnaire->is_whatsapp == '1' ? 'checked' : '' }} value="1"> Oui
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="mobile">Numero fixe</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroup-sizing-default">+225</span>
                                      <input type="number" class="form-control" name="mobile_fix" value="{{ old('mobile_fix', $concessionnaire->mobile_fix) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email', $concessionnaire->email) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="siege_social">Siège social</label>
                                <input type="text" name="siege_social" class="form-control" required value="{{ old('siege_social', $concessionnaire->siege_social ?? $concessionnaire->adresse) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="adresse">Situation géographique</label>
                                <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $concessionnaire->adresse) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="adresse">Adresse Map
                                    <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="L'adresse Map est utilisée pour localiser un lieu sur Google Maps à l'aide de la latitude et de la longitude."></i>
                                </label>
                                <input type="text" name="adresse_map" readonly class="form-control" value="{{ old('adresse_map', $concessionnaire->adresse_map) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" readonly value="{{ old('longitude', $concessionnaire->longitude) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" readonly value="{{ old('latitude', $concessionnaire->latitude) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" onclick="getLocation()" class="btn btn-primary mt-4" style="margin-top: 27px">Obtenir Coordonnées</button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pays_id">Pays </label>
                                <select class="form-control" name="pays_id" id="">
                                    <option value="">Sélectionner un pays</option>
                                    @foreach ($pays as $item)
                                        <option value="{{ $item->id }}" {{ old('pays_id', $concessionnaire->pays_id) == $item->id ? 'selected' : '' }}>{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ville_id">Ville </label>
                                <select class="form-control" name="ville_id" id="">
                                    <option value="">Sélectionner une ville</option>
                                    @foreach ($villes as $item)
                                        <option value="{{ $item->id }}" {{ old('ville_id', $concessionnaire->ville_id) == $item->id ? 'selected' : '' }}>{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="commune_id">Commune</label>
                                <select class="form-control" name="commune_id" id="">
                                    <option value="">Sélectionner une commune</option>
                                    @foreach ($communes as $item)
                                        <option value="{{ $item->id }}" {{ old('commune_id', $concessionnaire->commune_id) == $item->id ? 'selected' : '' }}>{{ $item->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo">Logo (Format : jpeg,png,jpg, 3M maximum)</label>
                                <input type="file" name="logo" class="form-control">
                                @if (!empty($logoUrl))
                                    <img width="200" height="200" src="{{ $logoUrl }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cover">Image de façade (Format : jpeg,png,jpg, 3M maximum)</label>
                                <input type="file" name="cover" class="form-control">
                                @if (!empty($coverUrl))
                                    <img width="200" height="200" src="{{ $coverUrl }}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control">{{ old('description', $concessionnaire->description) }}</textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mb-3">Mettre a jour l'établissement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Active les tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@include('layouts.footer')
