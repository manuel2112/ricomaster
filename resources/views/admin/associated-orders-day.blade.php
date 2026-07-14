@extends('adminlte::page')

@section('title', 'Cliente Asociado Detalle Día')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Cliente Asociado Detalle Día</h1>
        <a href="{{ route('admin.orders.associated') }}" class="btn btn-outline-primary">Volver</a>
    </div>
@stop

@section('content')
    <div id="app">

        <div v-if="ordersDay.length > 0">
            <h3>Detalle por cliente asociado para el día @{{ latinDate(day) }}</h3>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Rut cliente asociado</th>
                        <th scope="col">Nombre del Local </th>
                        <th scope="col">Detalle</th>
                        <th scope="col">Monto del Pedido</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in ordersDay" :key="index">
                        <td>@{{ item.associated.rut }}</td>
                        <td>@{{ item.associated.name }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                @click="openModal(item.order_number)">Ver
                                detalle</button>
                        </td>
                        <td>@{{ formatPrice(item.total_count) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="orderDetails.length > 0">
            <h3 class="mt-5">Resúmen por punto de venta para el día @{{ latinDate(day) }}</h3>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Punto de venta</th>
                        <th scope="col">Rut cliente</th>
                        <th scope="col">Cant. menú 1</th>
                        <th scope="col">Cant. menú 2</th>
                        <th scope="col">Cant. menú naturista</th>
                        <th scope="col">Precio menú normal</th>
                        <th scope="col">Cant. menú especial</th>
                        <th scope="col">Precio menú especial</th>
                        <th scope="col">Total a facturar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in orders" :key="index">
                        <td>@{{ item.associated.name }}</td>
                        <td>@{{ item.associated.rut }}</td>
                        <td>@{{ item.count_menu_01 }}</td>
                        <td>@{{ item.count_menu_02 }}</td>
                        <td>@{{ item.count_menu_naturist }}</td>
                        <td>@{{ formatPrice(item.associated.menu_normal_associated) }}</td>
                        <td>@{{ item.count_menu_special }}</td>
                        <td>@{{ formatPrice(item.associated.menu_special_associated) }}</td>
                        <td>@{{ formatPrice(item.total_price) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <a :href="`/pdf/associated/detail-day/${day}`" target="_blank" class="btn btn-primary">Imprimir</a>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createOrderModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createOrderModalLabel">Detalle pedido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-dark" v-if="order.length > 0">
                            <tbody>
                                <tr>
                                    <td>Fecha del Pedido</td>
                                    <td>@{{ latinDate(order[0].day_order) }}</td>
                                </tr>
                                <tr>
                                    <td>Nombre del Local</td>
                                    <td>@{{ order[0].associated.name }}</td>
                                </tr>
                                <tr>
                                    <td>Teléfono contacto del local </td>
                                    <td>+56@{{ order[0].associated.whatsapp }}</td>
                                </tr>
                                <tr>
                                    <td>Rut Comercio Asociado</td>
                                    <td>@{{ order[0].associated.rut }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">Opciones</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in order" :key="index">
                                    <td>@{{ item.type_menu.name }} - @{{ item.menu.name }}</td>
                                    <td>@{{ item.count }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <a :href="`/pdf/associated/detail/${order[0].order_number}`" target="_blank" class="btn btn-primary"
                            v-if="order.length > 0">Imprimir</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/associated-orders-day.js?v=' . time()) }}"></script>
@stop
