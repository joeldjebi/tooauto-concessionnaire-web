@include('layouts.header')
@include('layouts.menu')

<div class="page-wrapper">
    <div class="content">
        @include('layouts.fileariane')

        @if(session()->has('message'))
            <div style="padding: 10px" class="alert {{ session()->get('type') }}">{{ session()->get('message') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-4 col-sm-12" id="creer-admin">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Nouvel administrateur</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admins.store') }}" method="post">
                            @csrf

                            <div class="input-blocks">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control mb-3" value="{{ old('nom') }}" required>
                            </div>

                            <div class="input-blocks">
                                <label class="form-label">Prenoms</label>
                                <input type="text" name="prenoms" class="form-control mb-3" value="{{ old('prenoms') }}" required>
                            </div>

                            <div class="input-blocks">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control mb-3" value="{{ old('email') }}" required>
                            </div>

                            <div class="input-blocks">
                                <label class="form-label">Numero de telephone</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">+225</span>
                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" required>
                                </div>
                            </div>

                            <div class="input-blocks">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control mb-3" required>
                            </div>

                            <div class="input-blocks">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" class="form-control mb-3" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Créer l'administrateur</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12" id="liste-admins">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Liste des administrateurs</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Role</th>
                                        <th>Date de creation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $admin->nom }} {{ $admin->prenoms }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->indicatif }} {{ $admin->mobile }}</td>
                                            <td>
                                                @if($loop->first)
                                                    <span class="badges bg-lightgreen">Admin principal</span>
                                                @else
                                                    <span class="badges bg-lightyellow">Admin</span>
                                                @endif
                                            </td>
                                            <td>{{ optional($admin->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
