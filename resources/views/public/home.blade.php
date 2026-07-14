@extends('layouts.public')

@section('title', 'Portada')

@section('content')

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="hero-content">
                <div class="row align-items-center">

                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                        <div class="content">
                            <h1 class="hero-title mb-4">Que Rico Master</h1>
                            <p class="hero-subtitle mb-4">Disfruta de nuestras deliciosas comidas con servicio de pedidos
                                rápido y confiable. Ordena en línea y recibe tu comida fresca directamente en tu local
                                preferido.
                                ¡Sabor auténtico, entrega garantizada!</p>

                            <div class="hero-actions d-flex flex-wrap gap-3 mb-4">
                                <a href="{{ route('public.menu') }}" class="btn btn-outline">Haz tu pedido</a>
                            </div>

                            <div class="hero-info d-flex flex-wrap align-items-center gap-4">
                                <div class="info-item d-flex align-items-center">
                                    <i class="bi bi-clock me-2"></i>
                                    <div>
                                        <div class="fw-medium">24 hrs. al día</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                        <div class="hero-images">
                            <div class="main-image">
                                <img src="assets/img/restaurant/showcase-2.webp" alt="Signature Mediterranean Dish"
                                    class="img-fluid">
                            </div>
                            <div class="floating-images">
                                <div class="floating-image floating-image-1">
                                    <img src="assets/img/restaurant/main-4.webp" alt="Grilled Seafood" class="img-fluid">
                                </div>
                                <div class="floating-image floating-image-2">
                                    <img src="assets/img/restaurant/main-2.webp" alt="Mediterranean Dessert"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </section>
    <!-- /Hero Section -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <div class="row g-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                    @foreach ($random as $item)
                        <div class="col-lg-4 col-md-6 gallery-item isotope-item filter-food">
                            <div class="gallery-wrap">
                                <img src="storage/{{ $item['menu']['image'] }}" class="img-fluid"
                                    alt="{{ $item['menu']['name'] }}" loading="lazy">
                                <div class="gallery-info">
                                    <h4>{{ $item['menu']['name'] }}</h4>
                                    <div class="gallery-links">
                                        <a href="{{ route('public.menu') }}" title="{{ $item['menu']['name'] }}"><i
                                                class="bi bi-zoom-in"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->
                    @endforeach

                </div><!-- End Gallery Container -->
            </div><!-- End Isotope Layout -->

        </div>

    </section>
    <!-- /Gallery Section -->



@endsection
