@extends('adminlte::page')

@section('title', 'Campaña')

@section('content_header')
@stop

@section('content')
    <div id="app">
        <div class="container py-4">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h1>Campaña</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCampaignModal"
                        v-if="createCampaign">Crear
                        campaña</button>
                </div>
            </div>
        </div>

        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Día</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <tr v-for="(item, index) in listCampaigns" :key="item.id">
                    <td>@{{ item.id }}</td>
                    <td>@{{ formatDate(item.day) }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" @click="getCampaign(item.id)">
                            <i :class="fnIsToday(item.day) ? 'fas fa-pencil-alt' : 'far fa-eye'"></i></button>
                        <a :href="`/admin/campaign-final-day/${item.day}`" class="btn btn-warning"><i
                                class="fa fa-dollar-sign"></i></a>
                    </td>
                </tr>

                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="createCampaignModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createCampaignModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCampaignModalLabel">Campaña @{{ campaign ? formatDate(campaign.campaign.day) : '' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reset()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Asociados</label><br />
                                <div class="form-check form-check-inline" v-for="item in associateds"
                                    :key="item.id">
                                    <input class="form-check-input" type="checkbox" :id="`inlineCheckbox${item.id}`"
                                        :value="item.id" v-model="selectedAssociateds"
                                        :disabled="campaign && !fnIsToday(campaign.campaign.day)">
                                    <label class="form-check-label"
                                        :for="`inlineCheckbox${item.id}`">@{{ item.name }}</label>
                                </div>
                                <small class="text-danger" v-if="error.associated">Seleccionar al menos un
                                    asociado</small>
                                </template>
                            </div>

                            <table class="table table-hover table-dark"
                                v-if="campaign && campaign.bill && campaign.bill.length > 0">
                                <thead>
                                    <tr>
                                        <th scope="col">Menú</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in campaign.bill" :key="item.id">
                                        <td>@{{ item.menu.name }}</td>
                                        <td>@{{ formatPrice(item.price) }}</td>
                                        <td>@{{ item.counter }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row" v-if="!campaign || (campaign && fnIsToday(campaign.campaign.day))">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control" v-model="menuId">
                                            <option value="0" disabled>Seleccionar menú</option>
                                            <option v-for="(menu, index) in minuta" :key="menu.cod"
                                                :value="menu.menu.id">
                                                @{{ menu.menu.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                        </div>
                                        <input type="number" class="form-control" v-model.trim="price">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">N°</span>
                                        </div>
                                        <input type="number" class="form-control" v-model.trim="counter">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end"
                                v-if="!campaign || (campaign && fnIsToday(campaign.campaign.day))">
                                <button type="button" class="btn btn-primary" :disabled="loading"
                                    @click="storeUpdateBill()"><i class="fas fa-spinner fa-spin" v-if="loading"></i>
                                    Seleccionar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="reset()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/campaign.js?v=' . time()) }}"></script>
@stop
