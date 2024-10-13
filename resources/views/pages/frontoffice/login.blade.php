@extends('layouts.frontoffice.app')

@section('content')
<body>
    <main>
        <!-- Section -->
        <section class="min-vh-100 d-flex bg-primary align-items-center">
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
                                        <label for="email">Your email</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-envelope"></span></span>
                                            </div>
                                            <input class="form-control" id="email" name="email" placeholder="example@company.com" type="email" required>
                                        </div>
                                    </div>

                                    <!-- Form Group pour le mot de passe -->
                                    <div class="form-group">
                                        <label for="password">Password</label>
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
                                                Remember me
                                            </label>
                                        </div>
                                        <div><a href="{{ route('password.request') }}" class="small text-right">Lost password?</a></div>
                                    </div>

                                    <!-- Bouton de soumission -->
                                    <button type="submit" class="btn btn-block btn-primary">Sign in</button>
                                </form>

                                <!-- Options de connexion via les réseaux sociaux -->
                                <div class="mt-3 mb-4 text-center">
                                    <span class="font-weight-normal">or login with</span>
                                </div>
                                <div class="btn-wrapper my-4 text-center">
                                    <button class="btn btn-primary btn-icon-only text-facebook mr-2" type="button" aria-label="facebook button" title="facebook button">
                                        <span aria-hidden="true" class="fab fa-facebook-f"></span>
                                    </button>
                                    <button class="btn btn-primary btn-icon-only text-twitter mr-2" type="button" aria-label="twitter button" title="twitter button">
                                        <span aria-hidden="true" class="fab fa-twitter"></span>
                                    </button>
                                    <button class="btn btn-primary btn-icon-only text-facebook" type="button" aria-label="github button" title="github button">
                                        <span aria-hidden="true" class="fab fa-github"></span>
                                    </button>
                                </div>

                                <!-- Lien vers la page d'inscription -->
                                <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
                                    <span class="font-weight-normal">
                                        Not registered?
                                        <a href="{{ route('register') }}" class="font-weight-bold">Create account</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
@endsection
