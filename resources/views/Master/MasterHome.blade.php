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
    @yield('mystyle')
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sweetalert2.js') }}"></script>
    <!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/flickity.min.css') }}">

<!-- JavaScript -->
<script src="{{ asset('js/flickity.pkgd.min.js') }}"></script>

    <title>@yield('title')</title>
</head>

<body style="background-color: rgb(246, 249, 250);">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 px-3 shadow-sm rounded-3">
              <div class="container">
                <a class="navbar-brand text-dark fs-2 logo" href="/">LireSagesse</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">

                        <li class="nav-item active anm">
                            <a class="nav-link lk text-dark" href="/">Acceuil <span class="visually-hidden">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown anm">
                         <a class="nav-link lk dropdown-toggle text-dark" href="{{ route('all.livre') }}" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Livres</a>
                         <div class="dropdown-menu bg-white" aria-labelledby="dropdownId">
                            <a class="dropdown-item text-dark" href="{{ route('all.livre') }}">Livres</a>
                             <a class="dropdown-item text-dark" href="{{ route('all.categorie') }}">Catégories</a>
                             <a class="dropdown-item text-dark" href="{{ route('all.auteur') }}">Auteurs</a>
                             <a class="dropdown-item text-dark" href="#">Blog</a>
                         </div>
                     </li>
                     <li class="nav-item anm">
                        <a class="nav-link lk text-dark" href="/contact">Contact</a>
                    </li>
                    @if (Auth::check() && !Auth::user()->isAdmin)
                     <li class="nav-item dropdown anm">
                        <a class="nav-link lk dropdown-toggle text-dark" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile
                            @if($countMessages->count()>0)
                        <span class="badge bg-danger rounded-pill">{{ $countMessages->count() }}</span>
                        @endif
                        </a>
                        <div class="dropdown-menu bg-white" aria-labelledby="dropdownId">

                            <form action="{{ route('logout') }}" method="POST">
                              @method('post')
                              @csrf
                              <a class="dropdown-item text-dark text-capitalize fs-6 text-secondary" href="{{ route('user.profile') }}"><img class=" rounded-circle border border-2 border-dark" width="25px" src="{{ asset('images/users').'/'.Auth::user()->image }}" alt=""> {{ Auth::user()->nom }}</a>
                              <input class="dropdown-item text-dark text-secondary fs-6" value="Se Déconnecter" type="submit">
                            </form>

                        </div>
                    </li>
                    @elseif (Auth::check() && Auth::user()->isAdmin)
                    <li class="nav-item dropdown anm">
                      <a class="nav-link lk dropdown-toggle text-dark" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile
                        </a>
                      <div class="dropdown-menu bg-white" aria-labelledby="dropdownId">

                          <form action="{{ route('logout') }}" method="POST">
                            @method('post')
                            @csrf
                            <a class="dropdown-item text-dark text-capitalize fs-6 text-secondary" href="{{ route('admin') }}">Dashboard</a>
                            <input class="dropdown-item text-dark text-secondary fs-6" value="Se Déconnecter" type="submit">
                          </form>

                      </div>
                  </li>
                    @else
                    <li class="nav-item anm">
                        <a class="nav-link lk text-dark" href="{{ route('login') }}">Se Connecter</a>
                    </li>
                    @endif

                    <li class="nav-item anm">
                        @if (Cart::content()->count()>=1)
                        <a class="nav-link lk text-dark" href="{{ route('panier.show') }}""><i class="fas fa-shopping-cart"></i><span class=" countpa">&nbsp;
                            {{ Cart::content()->count() }}</span></a>
                            @else
                            <a class="nav-link lk text-dark" href="{{ route('panier.show') }}""><i class="fas fa-shopping-cart"></i></a>
                        @endif

                    </li>
                        <li class="nav-item">
                         <a class="nav-link btn-warning text-center text-white rounded-3 mx-2" href="{{ route('list.promo.home') }}">Promotions</a>
                     </li>

                    </ul>
                </div>
          </div>
        </nav>
    </div>
    @yield('content')
    <!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted mt-5 shadow-lg">
    <!-- Section: Social media -->
    <section
      class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"
    >
      <!-- Left -->
      <div class="me-5 d-none d-lg-block">
        <span>Suivez-nous sur :</span>
      </div>
      <!-- Left -->

      <!-- Right -->
      <div class="rsociaux">
        <a href="" class="me-4 text-reset">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-google"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-github"></i>
        </a>
      </div>
      <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold mb-4">
              <i class="fas fa-gem me-3"></i>Notre histoire
            </h6>
            <p>
                Notre mission est de revaloriser les livres d’occasion en proposant à chacun un service simple et transparent..
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Top Catégorie
            </h6>
            @php
            $x = 0;
            @endphp

              @foreach ($categorieshome as $categorie)
              @php
            $x += 1;
            @endphp

            <p>
                <a href="{{ route('categorie.show', [$categorie->id, $categorie->slug_cat]) }}" class="text-reset">{{ $categorie->titre_cat }}</a>
            </p>
            @if($x >= 4)
            @break
            @endif
            @endforeach

          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
                Liens importants
            </h6>
            <p>
              <a href="#!" class="text-reset">À propos</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Blog</a>
            </p>

          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Contact
            </h6>
            <p><i class="fas fa-home me-3"></i> Paris, 75000, FR</p>
            <p>
              <i class="fas fa-envelope me-3"></i>
              info@LireSagesse.shop
            </p>
            <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4 bg-dark text-white" style="background-color: rgba(0, 0, 0, 0.05);">
      © 2022 Copyright :
      <a class="text-reset fw-bold text-decoration-none" href="#">LireSagesse.shop</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/fonts.js') }}"></script>
</body>
</html>
