@extends('layouts.public')

@section('title', 'Comercio Asociado')

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

    <section class="container" id="book-a-table" class="book-a-table section">
        <div id="select-associated" class="container">
            <div class="row" v-if="!associated">
                <div class="col-12">
                    <h1 class="text-center">Realiza tu pedido</h1>
                </div>
                <div class="col-12 text-center mt-4">

                    <div class="row mb-3">
                        <div class="col-md-4 offset-md-4">
                            <div class="form-group">
                                <label for="loginAssociated">Ingresa tu RUT - 77.177.859-K</label>
                                <input type="text" class="form-control" id="loginAssociated" placeholder="Tu RUT"
                                    v-model.trim="login">

                                <button class="btn btn-primary mt-3" @click="getAssociated()" v-if="isActive && !isHoliday">
                                    Ingresar
                                </button>
                            </div>
                        </div>
                    </div>

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
                        <h2>@{{ formatPrice(menu.type_menu_id != 4 ? associated.menu_normal_associated : associated.menu_special_associated) }}</h2>
                        <small class="text-danger" v-if="menu.counter <= 10">Cantidad disponible: @{{ menu.counter }}
                            unidades</small>
                        <input type="number" class="form-control w-25 mx-auto" placeholder="Cantidad..."
                            v-model="cantidad[menu.id]" min="0" v-if="menu.counter > 0">
                        <h4 class="mt-2" v-if="priceItem[menu.id] != null && priceItem[menu.id] > 0">Por pagar:
                            @{{ formatPrice(priceItem[menu.id]) }}</h4>
                        <hr />
                    </template>
                </div>
            </div>

            <div class="row" v-if="associated">
                <div v-if="total !=null && total> 0" class="col-12 text-center mt-4">
                    <div v-html="getResumeOrder()"></div>
                </div>
                <div class="col-12
                        text-center mt-4">
                    <button class="btn btn-primary" @click="confirmOrder()" :disabled="total == null || total <= 0">
                        Confirma tu pedido
                    </button>
                    <h4 class="mt-2" v-if="total != null && total > 0">Total a pagar: @{{ formatPrice(total) }}</h4>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/page.associated.js?v=' . time()) }}"></script>
@endpush
