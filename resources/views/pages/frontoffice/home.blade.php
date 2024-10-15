@extends('layouts.frontoffice.app')

@section('content')
     
        <!-- Hero -->
        <div class="section section-header pb-7">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8 text-center">
                        <h1 class="display-2 mb-4 " id="text-neo">NéoLoto</h1>
                        <p class="lead mb-5">Une Nouvelle Façon de Jouer : Une expérience immersive et élégante</p>
                        <a class="btn btn-primary" href="/login"><span class="fas fa-dollar-sign mr-2"></span>Commencer maintenant &nbsp;<span class="fas fa-dollar-sign mr-2"></span> </a></div>
                </div>
                
            </div>        
        </div>
        
        <!-- End of Hero section -->
        <section class="section section-lg pt-0">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card bg-primary shadow-soft border-light p-4">
                            <div class="row">
                                <div class="col-12 col-lg-4 px-md-0 mb-4 mb-lg-0">
                                    <div class="card-body text-center bg-primary py-5">
                                        <div class="icon icon-shape shadow-inset border-light rounded-circle mb-3">
                                            <span class="far fa-eye"></span>
                                        </div>
                                        <!-- Heading -->
                                        <h2 class="h4 mr-2">
                                            Une Loterie réinventée pour les Passionnés
                                        </h2>
                                        <!-- Text -->
                                        <p class="mb-0">Explorez une nouvelle dimension du jeu, pensée pour les adeptes de la loterie qui recherchent une expérience moderne, épurée et accessible en ligne</p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 px-md-0 mb-4 mb-lg-0">
                                    <div class="card-body text-center bg-primary py-5">
                                        <div class="icon icon-shape shadow-inset border-light rounded-circle mb-3">
                                            <span class="fas fa-user-lock"></span>
                                        </div>
                                        <!-- Heading -->
                                        <h2 class="h4 mr-2">
                                            Jouez en toute sérénité
                                        </h2>
                                        <!-- Text -->
                                        <p class="mb-0">La sécurité est notre priorité. Nous avons conçu notre plateforme pour que chaque joueur puisse se concentrer pleinement sur le plaisir du jeu, en toute tranquillité.</p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 px-md-0">
                                    <div class="card-body text-center bg-primary py-5">
                                        <div class="icon icon-shape shadow-inset border-light rounded-circle mb-3">
                                            <span class="fas fa-money-bill-wave"></span>
                                        </div>
                                        <!-- Heading -->
                                        <h2 class="h4 mr-2">
                                            Des Opportunités de Gain à Chaque Tirage
                                        </h2>
                                        
                                        <!-- Text -->
                                        <p class="mb-0">Sur notre plateforme, chaque tirage est une nouvelle chance de remporter des récompenses. Nous avons repensé l’expérience de gain pour offrir des options claires et accessibles à tous les joueurs.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section -->
        <section class="section section-lg pt-0 ">
            <div class="container  shadow-soft border-light p-4 bg-primary" >
                <div class="row align-items-center justify-content-around">
                    <!-- Colonne de l'image -->
                    <div class="col-md-6 col-xl-6 mb-5">
                        <div class="card bg-primary shadow-soft border-light organic-radius p-3">
                            <img class="organic-radius img-fluid" src="./frontoffice/img/bingo.png" alt="modern desk">
                        </div>
                    </div>
                    
                    <!-- Colonne du texte -->
                    <div class="col-md-6 col-xl-6 mb-5 text-center text-md-left">
                        <h2 class="h1 mb-4">Votre Chance, Notre Passion.</h2>
                        <p class="lead">Nous croyons en l'excitation d'un jeu bien pensé, où la chance et le design se rencontrent. Notre plateforme réinvente la loterie pour offrir une expérience de jeu immersive, fluide, et élégante, à la hauteur de vos attentes.</p>
                        <p class="lead">Chaque tirage est une nouvelle opportunité de rêver et de gagner, dans un environnement simple, raffiné et conçu pour votre confort.</p>
                        <img src="./frontoffice/img/signature.png" alt="signature" class="mt-4" width="150">
                    </div>
                </div>
            </div>
        </section>

        <!-- End of section -->
       
        <!-- Section -->
        <section class="section section-lg pt-0">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <h2 class="h1">Développeur</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Profile Card -->
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Profile Card -->
                        <div class="card bg-primary shadow-soft border-light text-center py-4 mb-5">
                            <div class="profile-image shadow-inset  border border-light bg-primary rounded-circle p-3 mx-auto">
                                <img src="./frontoffice/img/brand/pinpin_minimalist.png" class="card-img-top shadow-soft p-2 border border-light rounded-circle" alt="pinpin">
                            </div>
                            <div class="card-body">
                                <h3 class="h5 mb-2">Pinpin</h3>
                                <span class="h6 font-weight-normal text-gray mb-3">Développeur/Designer/Pentester</span>
                                <ul class="list-unstyled d-flex justify-content-center my-3">
                               <li>
                                    <a href="mailto:bouazzaoui.soheib.pro@gmail.com" target="_blank" aria-label="email link" class="icon icon-xs icon-email mr-3">
                                        <span class="fas fa-envelope"></span> <!-- Icône pour l'email -->
                                    </a>
                                </li>
                                <li>
                                    <a href="https://github.com/pinpin-http" target="_blank" aria-label="github social link" class="icon icon-xs icon-github mr-3">
                                        <span class="fab fa-github"></span> <!-- Icône pour GitHub -->
                                    </a>
                                </li>

                                </ul>
                            </div>
                        </div>
                        <!-- End of Profile Card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End of section -->
    </main>
@endsection