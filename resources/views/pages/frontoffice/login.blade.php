@extends('layouts.frontoffice.app')

@section('content')
<body>
    <main>
        <!-- Section -->
        <section class="min-vh-100 d-flex  align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6 justify-content-center">
                        <div class="card bg-primary shadow-soft border-light p-4">
                            <div class="card-header text-center pb-0">
                                <h2 class="h4">Sign in to our platform</h2>  
                            </div>
                            <div class="card-body">
                                <!-- Action du formulaire pointant vers la route de connexion -->
                                <form method="POST" action="{{ route('login') }}" class="mt-4">
                                    @csrf <!-- Protection CSRF obligatoire -->

                                    <!-- Form Group pour l'email -->
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-envelope"></span></span>
                                            </div>
                                            <input class="form-control" id="email" name="email" placeholder="example@company.com" type="email" required>
                                        </div>
                                    </div>

                                    <!-- Form Group pour le mot de passe -->
                                    <div class="form-group">
                                        <label for="password">Mot de passe</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-unlock-alt"></span></span>
                                            </div>
                                            <input class="form-control" id="password" name="password" placeholder="Password" type="password" required>
                                        </div>
                                    </div>

                                    <!-- Checkbox "Remember me" -->
                                    <div class="d-block d-sm-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Se souvenir de moi 
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Bouton de soumission -->
                                    <button type="submit" class="btn btn-block btn-primary">Sign in</button>
                                </form>

                             

                                <!-- Lien vers la page d'inscription -->
                                <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
                                    <span class="font-weight-normal">
                                        Pas encore des nôtres?
                                        <a href="{{ route('register') }}" class="font-weight-bold">Créez un compte maintenant !</a>
                                    </span>
                                </div>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
@endsection
