  <nav id="navbar-main" aria-label="Primary navigation" class="navbar navbar-main navbar-expand-lg navbar-theme-primary headroom navbar-light navbar-transparent navbar-theme-primary">
        <div class="container position-relative">
            <a class="navbar-brand shadow-soft py-2 px-3 rounded border border-light mr-lg-4" href="/">
                <img class="navbar-brand-light" src="{{ asset('frontoffice/img/brand/pinpin_minimalist.png') }}" alt="Logo dark">
            </a>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="/" class="navbar-brand shadow-soft py-2 px-3 rounded border border-light">
                                <img src="{{ asset('frontoffice/img/brand/pinpin_minimalist.png') }}" alt="Logo">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <a href="#navbar_global" class="fas fa-times" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" title="close" aria-label="Toggle navigation"></a>
                        </div>
                    </div>
                </div>

                    <a href="/" class="nav-link" data-toggle="dropdown" >
                        <span class="nav-link-inner-text">À propos</span>

                    </a>
                    <a href="/ranking" class="nav-link" data-toggle="dropdown">
                        <span class="nav-link-inner-text">Classements</span>
                    </a>

                 <!-- Affichage conditionnel de certaines sections -->

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a class="nav-link" href="{{ route('admin.create_draw') }}">Dashboard Admin</a>
                        @elseif(Auth::user()->role === 'user')
                            <a class="nav-link" href="{{ route('user.ticketing') }}">Acheter un ticket</a>
                            <a class="nav-link" href="{{ route('user.participations') }}">Voir mes participations</a>

                        @endif
                    @endauth

            </div>
            <div class="d-flex align-items-center">

                <!-- Bouton qui affiche "Logout" si l'utilisateur est connecté, et "Login" sinon -->
                @auth
                    <!-- Si l'utilisateur est connecté, afficher le bouton "Logout" -->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary mb-2 mb-sm-0 ">
                            <span class="mr-1"><span class="fas fa-sign-out-alt"></span></span>
                            Déconnexion
                        </button>
                    </form>
                @else
                    <!-- Si l'utilisateur n'est pas connecté, afficher le bouton "Login" -->
                    <a href="{{ route('login') }}" class="btn btn-primary mb-2 mb-sm-0">
                        <span class="mr-1"><span class="fas fa-sign-in-alt"></span></span>
                        Connexion/Inscription
                    </a>
                @endauth


                <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
