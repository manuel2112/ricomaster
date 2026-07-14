@extends('adminlte::page')

@section('title', 'Detalle pedidos')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Detalle Pedidos</h1>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-primary">Volver</a>
    </div>
@stop

@section('content')
    <div id="app">
        <div v-if="orderDayAssociated.length > 0">
            <h3>Clientes asociados</h3>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Asociado</th>
                        <th scope="col">Menú</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in orderDayAssociated" :key="item.id">
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ item.associated.name }}</td>
                        <td>@{{ item.menu.name }}</td>
                        <td>@{{ item.count }}</td>
                        <td>@{{ formatMoney(item.count * item.price) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">Total</td>
                        <td>@{{ totalSailAssociated() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="orderDayFinal.length > 0">
            <h3 class="mt-5">Clientes finales</h3>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Retiro en:</th>
                        <th scope="col">Menú</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in orderDayFinal" :key="item.id">
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ item.client_final.name }} / +@{{ item.client_final.whatsapp }}</td>
                        <td>@{{ item.associated.name }}</td>
                        <td>@{{ item.menu.name }}</td>
                        <td>@{{ item.count }}</td>
                        <td>@{{ formatMoney(item.count * item.price) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">Total</td>
                        <td>@{{ totalSailFinal() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="mt-5">Día total</h3>
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">Total</td>
                    <td>@{{ totalSail() }}</td>
                </tr>
                </tr>
            </tbody>
        </table>
    </div>
@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/detail-order.js?v=' . time()) }}"></script>
@stop
