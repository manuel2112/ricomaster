@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Gestión de Pedidos</h1>
@stop

@section('content')
    <div id="app">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center flex-wrap d-grid gap-3">
                <a href="{{ route('admin.orders.associated') }}"
                    class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">Pedidos Clientes Asociados</a>
                <a href="{{ route('admin.orders.final') }}"
                    class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">Pedidos Clientes Finales</a>
                <a href="{{ route('admin.bill') }}" class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">Minuta</a>
                <a href="{{ route('admin.campaign') }}"
                    class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">Campaña</a>
                <a href="{{ route('admin.whatsapp.associated') }}"
                    class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">WhatsApp Clientes Asociados</a>
                <a href="{{ route('admin.whatsapp.final') }}"
                    class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">WhatsApp Clientes Finales</a>
                <a href="{{ route('admin.menu') }}" class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">Menú</a>
                <a href="{{ route('admin.associated') }}"
                    class="btn btn-outline-primary btn-lg btn-block w-25 py-5 m-3">Asociados</a>
            </div>
        </div>
    </div>
@stop
