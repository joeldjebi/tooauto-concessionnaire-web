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
            <h5 class="card-title">Liste des offres envoyées</h5>
        </div>

        @if (!empty($offres) && count($offres) > 0)
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Gestionnaire de flotte</th>
                                            <th>Telephone</th>
                                            <th>Fichier</th>
                                            <th>E-mail</th>
                                            <th>Date d'envoi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($offres->isNotEmpty())
                                            @foreach ($offres as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->user->nom }} {{ $item->user->prenoms }}</td>
                                                    <td>{{ $item->user->mobile }}</td>
                                                    <td><a href="{{ asset($item->fichier) }}" target="_blank">{{ $item->fichier }}</a></td>
                                                    <td>{{ $item->user->email }}</td>
                                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <form action="{{ route('destroy.offre', $item->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">Supprimer</button>
                                                        </form>
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
