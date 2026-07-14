@extends('layouts.public')

@section('title', 'Contacto')

@section('content')

    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contacto</h2>
            {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-info">
                        <div class="contact-card">
                            <h3>Información de Contacto</h3>
                            <p>No dudes en ponerte en contacto con nosotros para cualquier consulta sobre nuestros platos,
                                pedidos o cualquier otra información.</p>

                            <div class="contact-details">
                                <div class="contact-item">
                                    <i class="bi bi-envelope"></i>
                                    <div>
                                        <h4>Email:</h4>
                                        <p>author@example.com</p>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <i class="bi bi-telephone"></i>
                                    <div>
                                        <h4>Teléfono:</h4>
                                        <p>+1 (555) 123-4567</p>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <div>
                                        <h4>Dirección:</h4>
                                        <p>Calle Libro 123, Avenida Literaria</p>
                                        <p>Ciudad de los Escritores, NY 10001</p>
                                    </div>
                                </div>
                            </div>

                            <div class="social-links">
                                <a href="#"><i class="bi bi-facebook"></i></a>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="contact-form-wrapper">
                        <form class="php-email-form" @submit.prevent="sendContact">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        v-model.trim="contact.name" placeholder="Tu nombre..." required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        v-model="contact.email" placeholder="tuemail@ejemplo.com" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="subject">Asunto</label>
                                <select class="form-select" aria-label="Default select example" name="subject"
                                    v-model="contact.subject" required>
                                    <option selected value="">Seleccionar...</option>
                                    <option value="Sugerencias">Sugerencias</option>
                                    <option value="Comentarios">Comentarios</option>
                                    <option value="Reclamos">Reclamos</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="message">Mensaje</label>
                                <textarea class="form-control" name="message" rows="4" placeholder="Tu mensaje aquí..."
                                    v-model.trim="contact.message" required></textarea>
                            </div>

                            <div class="my-3">
                                <div class="loading">Cargando</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Tu mensaje ha sido enviado. ¡Gracias!</div>
                            </div>

                            <div class="text-center">
                                <button type="submit">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Contact Section -->

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/page.contact.js?v=' . time()) }}"></script>
@endpush
