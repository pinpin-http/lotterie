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
                                <h2 class="mb-0 h5">Create Account</h2>
                            </div>
                            <div class="card-body">
                                <!-- Définissez l'action du formulaire vers la route d'inscription -->
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf <!-- Protection CSRF obligatoire -->

                                    <!-- Form Group pour le nom -->
                                    <div class="form-group">
                                        <label for="name">Nom</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-user"></span></span>
                                            </div>
                                            <input class="form-control" id="name" name="name" placeholder="Your name" type="text" required>
                                        </div>
                                    </div>

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

                                    <!-- Form Group pour la confirmation du mot de passe -->
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmez le mot de passe</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-unlock-alt"></span></span>
                                            </div>
                                            <input class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" type="password" required>
                                        </div>
                                    </div>

                                <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
                                    <span class="font-weight-normal">
                                        Ah mais vous avez deja un compte?
                                        <a href="{{ route('login') }}" class="font-weight-bold">Ca se passe ici alors !</a>
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
                                <button type="submit" class="btn btn-block btn-primary">S'inscrire</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
