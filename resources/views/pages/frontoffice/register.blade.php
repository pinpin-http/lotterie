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
                                <h2 class="mb-0 h5">Create Account</h2>                               
                            </div>
                            <div class="card-body">
                                <!-- Définissez l'action du formulaire vers la route d'inscription -->
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf <!-- Protection CSRF obligatoire -->

                                    <!-- Form Group pour le nom -->
                                    <div class="form-group">
                                        <label for="name">Your name</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-user"></span></span>
                                            </div>
                                            <input class="form-control" id="name" name="name" placeholder="Your name" type="text" required>
                                        </div>
                                    </div>

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

                                    <!-- Form Group pour la confirmation du mot de passe -->
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-unlock-alt"></span></span>
                                            </div>
                                            <input class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" type="password" required>
                                        </div>
                                    </div>

                                    <!-- Checkbox d'accord avec les termes -->
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck6" required>
                                        <label class="form-check-label" for="defaultCheck6">
                                            I agree to the <a href="#">terms and conditions</a>
                                        </label>
                                    </div>

                                    <!-- Bouton de soumission -->
                                    <button type="submit" class="btn btn-block btn-primary">Register</button>
                                </form>

                                <!-- Options de connexion via les réseaux sociaux -->
                                <div class="mt-3 mb-4 text-center">
                                    <span class="font-weight-normal">or</span>
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

                                <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
                                    <span class="font-weight-normal">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="font-weight-bold">Login here</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
