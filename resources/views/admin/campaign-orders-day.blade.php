@extends('adminlte::page')

@section('title', 'Campaña Final Detalle Día')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Campaña Final Detalle Día</h1>
        <a href="{{ route('admin.campaign') }}" class="btn btn-outline-primary">Volver</a>
    </div>
@stop

@section('content')
    <div id="app">
        <div v-if="ordersDay.length > 0">
            <h3>Detalle por cliente final para el día @{{ latinDate(day) }}</h3>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Local</th>
                        <th scope="col">Detalle</th>
                        <th scope="col">N° Pedido</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in ordersDay" :key="index">
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ item.client_final.name }}</td>
                        <td>@{{ item.associated.name }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                @click="openModal(item.order_number)">Ver
                                detalle</button>
                        </td>
                        <td>@{{ item.order_number }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="orders.length > 0">
            <h3 class="mt-5">Resúmen por punto de venta para el día @{{ latinDate(day) }}</h3>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Código cliente</th>
                        <th scope="col">Punto de venta</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Menú</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio unitario</th>
                        <th scope="col">Total a facturar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in orders" :key="index">
                        <td>@{{ item.client_final.id }}</td>
                        <td>@{{ item.associated.name }}</td>
                        <td>@{{ item.client_final.name }}</td>
                        <td>@{{ item.menu.name }}</td>
                        <td>@{{ item.count }}</td>
                        <td>@{{ formatPrice(item.price / item.count) }}</td>
                        <td>@{{ formatPrice(item.price) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <a :href="`/pdf/campaign/detail-day/${day}`" target="_blank" class="btn btn-primary">Imprimir</a>
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
                                    <td>Nº de Pedido</td>
                                    <td>@{{ order[0].order_number }}</td>
                                </tr>
                                <tr>
                                    <td>Fecha del Pedido</td>
                                    <td>@{{ latinDate(order[0].day_order) }}</td>
                                </tr>
                                <tr>
                                    <td>Nombre Cliente</td>
                                    <td>@{{ order[0].client_final.name }}</td>
                                </tr>
                                <tr>
                                    <td>Teléfono Cliente</td>
                                    <td>+56@{{ order[0].client_final.whatsapp }}</td>
                                </tr>
                                <tr>
                                    <td>Nombre local donde retira</td>
                                    <td>@{{ order[0].associated.name }}</td>
                                </tr>
                                <tr>
                                    <td>Dirección local donde retira</td>
                                    <td>@{{ order[0].associated.address }}</td>
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
                                    <td>@{{ item.menu.name }}</td>
                                    <td>@{{ item.count }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <a :href="`/pdf/final/detail/${order[0].order_number}/1`" target="_blank" class="btn btn-primary"
                            v-if="order.length > 0">Imprimir</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/campaign-orders-day.js?v=' . time()) }}"></script>
@stop
