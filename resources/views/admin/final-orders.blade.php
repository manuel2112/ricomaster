@extends('adminlte::page')

@section('title', 'Cliente Final')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Cliente Final</h1>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-primary">Volver</a>
    </div>
@stop

@section('content')
    <div id="app">
        <div v-if="listDays.length > 0">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Día</th>
                        <th scope="col">Pedidos</th>
                        <th scope="col">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in listDays" :key="index">
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ item.created_day }}</td>
                        <td>@{{ item.total_orders }}</td>
                        <td>
                            <a :href="`/admin/orders-final-day/${item.day_order}`"
                                class="btn btn-outline-primary btn-sm">Ver
                                detalle</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/final-orders.js?v=' . time()) }}"></script>
@stop
