<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" /-->
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sweetalert2.js') }}"></script>
    <title>@yield('title')</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><a class="logo text-decoration-none text-dark" href="/"><i
                    class="fas fa-book me-2"></i>LireSagesse</a></div>
            <div class="list-group list-group-flush my-3">
                <a href="{{ route('admin') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        <li class="nav-item dropdown anm" style="list-style-type: none;">
                            <a class="nav-link lk dropdown-toggle text-dark list-group-item list-group-item-action bg-transparent second-text fw-bold" href="{{ route('all.livre') }}" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-shopping-cart me-2"></i>Commandes
                                @if($countvu->count()>0)
                                <span class="badge bg-danger rounded-pill">{{ $countvu->count() }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu bg-white " aria-labelledby="dropdownId">
                               <a class="dropdown-item text-secondary fs-6 fw-bold" href="{{ route('listc') }}">Nouvelles Commandes</a>
                                <a class="dropdown-item text-secondary fs-6 fw-bold" href="{{ route('listconf') }}">Commandes Confirmées</a>
                                <a class="dropdown-item text-secondary fs-6 fw-bold" href="{{ route('list.livree') }}">Commandes Livrées</a>
                                <a class="dropdown-item text-secondary fs-6 fw-bold" href="{{ route('listannuler') }}">Commandes Annulées</a>

                            </div>
                        </li>
                <a href="{{ route('categorie.liste') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-table me-2"></i>Catégories</a>
                <a href="{{ route('auteur.liste') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                                class="fas fa-user me-2"></i>Auteurs</a>
                <a href="{{ route('livre.liste') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-gift me-2"></i>Produits</a>
                        <a href="{{ route('livreurs.list') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-car me-2"></i>Livreur</a>

                        <div class="dropdown">
                            <a class="nav-link lk dropdown-toggle text-dark list-group-item list-group-item-action bg-transparent second-text fw-bold" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-comment-dots me-2"></i>Messages
                                @if(Auth::check())
                                @if($countMessages->count()>0)
                                <span class="badge bg-danger rounded-pill">{{ $countMessages->count() }}</span>
                                @endif
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li> <a href="{{ route('listm') }}" class=" dropdown-item fw-bold">Boîte de réception</a></li>
                              <li><a class="dropdown-item fw-bold" href="{{ route('msg.admin') }}">Message Envoyés</a></li>
                            </ul>
                          </div>

                        <a href="{{ route('usersAdmin.list') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-user me-2"></i>Users</a>
                        <a href="{{ route('parameter') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-cog me-2"></i>Paramètres</a>
                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Se Déconnecter</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">

                    <button style="border:none; background-color:transparent" id="menu-toggle"><i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i></button>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="rounded-pill border border-2 border-dark" width="30px" height="30px" src="{{ asset('images/users').'/'.Auth::user()->image }}" alt=""> {{ Auth::user()->nom }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('parameter') }}">Settings</a></li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @method('post')
                                        @csrf
                                        <input class="dropdown-item text-dark text-secondary fs-6" value="Se Déconnecter" type="submit">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')


    <!--script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script-->
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/fonts.js') }}"></script>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");

        };
    </script>
</body>

</html>
