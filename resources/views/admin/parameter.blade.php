@extends('adminlte::page')

@section('title', 'Parametros')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Parametros</h1>
    </div>
@stop

@section('content')
    <div id="app">
        <div class="form-group row">
            <label for="inputBillOpen" class="col-sm-2 col-form-label text-right">Menú apertura</label>
            <div class="col-sm-10">
                <input type="time" class="form-control" id="inputBillOpen" placeholder="Menú apertura"
                    v-model="parameters.bill_hour_start">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputBillClose" class="col-sm-2 col-form-label text-right">Menú cierre</label>
            <div class="col-sm-10">
                <input type="time" class="form-control" id="inputBillClose" placeholder="Menú cierre"
                    v-model="parameters.bill_hour_end">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputMenuQuantityDefault" class="col-sm-2 col-form-label text-right">Menú cantidad default</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputMenuQuantityDefault" placeholder="Menú cantidad default"
                    v-model="parameters.bill_counter_default">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputCampaignStartTime" class="col-sm-2 col-form-label text-right">Campaña hora comienzo</label>
            <div class="col-sm-10">
                <input type="time" class="form-control" id="inputCampaignStartTime" placeholder="Campaña hora comienzo"
                    v-model="parameters.campaign_hour_start">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputCampaignEndTime" class="col-sm-2 col-form-label text-right">Campaña hora fin</label>
            <div class="col-sm-10">
                <input type="time" class="form-control" id="inputCampaignEndTime" placeholder="Campaña hora fin"
                    v-model="parameters.campaign_hour_end">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputCampaignPriceDefault" class="col-sm-2 col-form-label text-right">Campaña precio default</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputCampaignPriceDefault"
                    placeholder="Campaña precio default" v-model="parameters.campaign_price_default">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputCampaignQuantityDefault" class="col-sm-2 col-form-label text-right">Campaña cantidad
                default</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputCampaignQuantityDefault"
                    placeholder="Campaña cantidad default" v-model="parameters.campaign_counter_default">
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-primary" @click="saveParameters">Guardar</button>
        </div>
    </div>
@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/parameter.js?v=' . time()) }}"></script>
@stop
