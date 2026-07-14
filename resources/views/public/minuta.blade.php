@extends('layouts.public')

@section('title', 'Minuta Semanal')

@section('content')

    <!-- Minuta Section -->
    <section id="minuta" class="minuta section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="accordion" id="accordionExample" v-if="minutas.length > 0">

                <div class="accordion-item" v-for="(minuta, idx) in minutas" :key="minuta.day">
                    <h2 class="accordion-header" :id="'heading' + idx">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            :data-bs-target="'#collapse' + idx" :aria-expanded="minuta.active"
                            :aria-controls="'collapse' + idx">
                            @{{ minuta.strDay }} @{{ minuta.day }}
                        </button>
                    </h2>
                    <div :id="'collapse' + idx" class="accordion-collapse collapse" :class="minuta.active ? 'show' : ''"
                        :aria-labelledby="'heading' + idx" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-center">
                            <template v-for="(menu, idxMenu) in minuta.menus" :key="idxMenu">
                                <h4>@{{ menu.type_menu.name }}</h4>
                                {{-- <img :src="fnCreateImage(menu.menu.image)" alt="Menu Image"
                                    style="width: 320px; min-height: 100%; object-fit: cover; border-radius: 5px;"
                                    v-if="menu.menu.image" /> --}}
                                <h2>@{{ menu.menu.name }}</h2>
                                <hr />
                            </template>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /About Section -->

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/page.minuta.js?v=' . time()) }}"></script>
@endpush
