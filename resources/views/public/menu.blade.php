@extends('layouts.public')

@section('title', 'Haz tu pedido')

@section('content')

    <div class="container mt-4" v-if="!isActive">
        <div class="row">
            <div class="col">
                <div class="alert alert-danger text-center">
                    <strong>Estimado cliente:</strong> Los pedidos para el día siguiente, pueden realizarse desde las 15:00
                    hrs.
                </div>
            </div>
        </div>
    </div>

    <!-- Book A Table Section -->
    <section class="container" id="book-a-table" class="book-a-table section">
        <div id="select-local">
            <div class="row" v-if="!associated">
                <div class="col-12">
                    <h1 class="text-center">Elige el local donde deseas retirar y pagar tu pedido
                    </h1>
                </div>
                <div class="col-12 text-center mt-4">
                    <template v-for="(associated, idx) in associateds" :key="idx">

                        <h3>@{{ associated.name }}</h3>
                        <h4>@{{ associated.address }}, @{{ associated.commune }}</h4>
                        <a :href="associated.map" target="_blank" class="btn btn-outline-warning">Ver Mapa</a>
                        <button class="btn btn-primary" @click="selectAssociated(associated)"
                            v-if="isActive && !isHoliday">Seleccionar</button>

                        <hr />

                    </template>
                </div>
            </div>

            <div class="row" v-if="associated">
                <div class="col-12 text-center">
                    <h1> @{{ associated.name }}</h1>
                    <h2>Menú para el día @{{ minuta.strDay }} @{{ minuta.day }}</h2>
                </div>
                <div class="col-12 text-center mt-4">
                    <template v-for="(menu, idxMenu) in minuta.menus" :key="idxMenu">
                        <h4>@{{ menu.type_menu.name }}</h4>
                        <h2>@{{ menu.menu.name }}</h2>
                        <img :src="fnCreateImage(menu.menu.image)" alt="Menu Image"
                            style="width: 320px; object-fit: cover; border-radius: 5px;" v-if="menu.menu.image" />
                        <h2>@{{ formatPrice(menu.type_menu_id != 4 ? associated.menu_normal_final : associated.menu_special_final) }}</h2>
                        <small class="text-danger" v-if="menu.counter <= 10">
                            <template v-if="menu.counter == 0">
                                No disponible
                            </template>
                            <template v-else>
                                Cantidad disponible: @{{ menu.counter }} unidades
                            </template>
                        </small>
                        <input type="number" class="form-control w-25 mx-auto" placeholder="Cantidad..."
                            v-model="cantidad[menu.id]" min="0" v-if="menu.counter > 0">
                        <h4 class="mt-2" v-if="priceItem[menu.id] != null && priceItem[menu.id] > 0">Por pagar:
                            @{{ formatPrice(priceItem[menu.id]) }}</h4>
                        <hr />
                    </template>

                    <div class="row mb-3" v-if="client.order">
                        <h4>Ingresa tus datos</h4>
                        <div class="col-md-4 offset-md-4">
                            <div class="form-group">
                                <label for="nameClient">Nombre</label>
                                <input type="text" class="form-control" id="nameClient" placeholder="Tu nombre completo"
                                    v-model.trim="client.name">
                            </div>
                            <div class="form-group mt-3">
                                <label for="whatsappClient">Whatsapp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+56</span>
                                    </div>
                                    <input type="number" class="form-control" id="whatsappClient" placeholder="9 dígitos"
                                        v-model.trim="client.whatsapp" @input="limitLength()">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="total !=null && total> 0" class="col-12 text-center mt-4">
                        <div v-html="getResumeOrder()"></div>
                    </div>
                    <button class="btn btn-primary" @click=" client.order ? confirmOrder() : placeOrder()"
                        :disabled="total == null || total <= 0">
                        @{{ client.order ? 'Confirma tu pedido' : 'Realizar pedido' }}
                    </button>
                    <h4 class="mt-2" v-if="total != null && total > 0">Total a pagar: @{{ formatPrice(total) }}</h4>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/page.menu.js?v=' . time()) }}"></script>
@endpush
