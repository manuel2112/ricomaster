@extends('layouts.public')

@section('title', 'Quienes Somos')

@section('content')

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                    <div class="about-image">
                        <img src="assets/img/restaurant/chef-3.webp" alt="Executive Chef" class="img-fluid rounded">
                        <div class="experience-badge">
                            <span class="years">25+</span>
                            <span class="text">Años de experiencia culinaria</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="about-content">
                        <div class="section-header">
                            <h2>Quienes Somos</h2>
                        </div>

                        <div class="story-text">
                            <p>Somos una empresa dedicada a la Elaboraci6n y comercializaci6n de comidas preparadas,
                                principalmente almuerzos. Nuestro obfetivo es proporcionar un almuerzo variado y de calidad
                                nutricional, adaptandonos a los gustos y necesidades de nuestros clientes. Trabajamos con
                                una red de comercios asociados para garantizar una entrega directa y eficiente a nuestros
                                clientes finales.</p>

                            <p>Tenemos mas de 15 anos de experiencia en el rubro de alimentos, con nuestros locales de venta
                                directa a publico "Que Rico". Nos enorgullecemos de ofrecer una trayectoria s6Iida y
                                confiable en la elaboraci6n y comercializaci6n de comidas preparadas contando con las
                                resoluciones sanitarias necesarias para garantizar la calidad y seguridad de nuestros
                                productos.</p>

                            <p>Actualmente tenemos convenios con diversas empresas de la zona, a las que les ofrecemos
                                nuestro servicio de almuerzos frescos, listos para consumir. Nuestros platos son ideates
                                para satisfacer las necesidades de empresas que buscan opciones gastron6micas convenientes y
                                de calidad para sus colaboradores.</p>

                            <p>Nuestra Razon Social es Alimentos Ricomaster Spa. y estamos ubicados en Souther 721, Vina del
                                Mar Fonos: 32 2677354 +569 76117238 Mail: contacto@ricomaster.cl</p>
                        </div>

                        <div class="cta-buttons">
                            <a href="#menu" class="btn btn-primary">Ver Minuta</a>
                            <a href="#book-a-table" class="btn btn-outline">Realizar Pedido</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="restaurant-gallery" data-aos="fade-up" data-aos-delay="400">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <img src="assets/img/restaurant/showcase-2.webp" alt="Restaurant Interior"
                                class="img-fluid rounded">
                            <div class="gallery-caption">
                                <h4>Elegant Dining</h4>
                                <p>Sophisticated ambiance for every occasion</p>
                            </div>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <img src="assets/img/restaurant/main-4.webp" alt="Signature Dish" class="img-fluid rounded">
                            <div class="gallery-caption">
                                <h4>Signature Dishes</h4>
                                <p>Artfully crafted seasonal specialties</p>
                            </div>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <img src="assets/img/restaurant/misc-7.webp" alt="Wine Selection" class="img-fluid rounded">
                            <div class="gallery-caption">
                                <h4>Curated Wine</h4>
                                <p>Exceptional pairings from around the world</p>
                            </div>
                        </div>
                    </div><!-- End Gallery Item -->
                </div>
            </div>

        </div>

    </section><!-- /About Section -->

@endsection
