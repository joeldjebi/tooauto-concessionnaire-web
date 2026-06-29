			<!-- Sidebar -->
	            @php
                    $currentUser = auth()->user();
	                $firstAdminId = \App\Models\Userconcessionnaire::where('role', 1)->orderBy('id')->value('id');
	                $canManageAdmins = !empty($currentUser) && (int) $currentUser->role === 1 && (int) $currentUser->id === (int) $firstAdminId;
	            @endphp
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
                    <div id="sidebar-menu" class="sidebar-menu">
                        <ul>
                            <li class="submenu-open">
                                <h6 class="submenu-hdr">Main</h6>
                                <ul>
                                    <li class="{{ $menu == "dashboard" ? 'active' : ''}}">
                                        <a href="{{ route('dashboard') }}" ><i data-feather="grid"></i><span>Tableau de bord</span></a>
                                    </li>
                                </ul>
                            </li>

                            @if($canManageAdmins)
                                <li class="submenu-open">
                                    <h6 class="submenu-hdr">Les utilisateurs</h6>
                                    <ul>
                                        <li class="{{ $menu == "admins" ? 'active' : ''}}">
                                            <a href="{{ route('admins.index') }}#liste-admins">
                                                <i data-feather="users"></i>
                                                <span>Liste des admins</span>
                                            </a>
                                        </li>
                                        <li class="{{ $menu == "admin-create" ? 'active' : ''}}">
                                            <a href="{{ route('admins.index') }}#creer-admin">
                                                <i data-feather="user-plus"></i>
                                                <span>Créer un admin</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li class="submenu-open">
                                <h6 class="submenu-hdr">Vehicules</h6>
                                <ul>
                                    <li class="{{ $menu == "vehicule" ? 'active' : ''}}">
                                        <a href="{{ route('vehicule.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                            <span>Liste des Vehicules</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu-open">
                                <h6 class="submenu-hdr">Annonces</h6>
                                <ul>
                                    <li class="{{ $menu == "annonce" ? 'active' : ''}}">
                                        <a href="{{ route('annonce.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                            <span>Liste des annonces</span>
                                        </a>
                                    </li>
                                    <li class="{{ $menu == "flotte" ? 'active' : ''}}">
                                        <a href="{{ route('flotte') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                            <span>Les gestionnaires de flotte</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu-open">
                                <h6 class="submenu-hdr">Rendez-vous</h6>
                                <ul>
                                    <li class="{{ $menu == "rdv-concessionnaire" ? 'active' : ''}}">
                                        <a href="{{ route('rdv.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                            <span>Flottes</span>
                                        </a>
                                    </li>
                                    <li class="{{ $menu == "usager-historique-rdv" ? 'active' : ''}}">
                                        <a href="{{ route('rdv.usager') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                            <span>Usagers</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <h6 class="submenu-hdr">Paramètres</h6>
                                <a href="javascript:void(0);" class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-columns">
                                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path>
                                    </svg>
                                    <span>Paramètres</span><span class="menu-arrow"></span>
                                </a>
                                <ul style="display: none;">
                                    <li class="{{ $menu == "concessionnaire-edit" ? 'active' : ''}}">
                                        <a href="{{ route('concessionnaire.edit') }}">Concessionnaire </a>
                                    </li>
                                    <li class="{{ $menu == "profil" ? 'active' : ''}}">
                                        <a href="{{ route('profil.index') }}">Mon compte </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
