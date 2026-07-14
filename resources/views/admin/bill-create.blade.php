@extends('adminlte::page')

@section('title', 'Minuta')

@section('content_header')
    <h1>Programar Minuta</h1>
@stop

@section('content')
    <div id="app">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Menú\Día</th>
                    <th scope="col">Lunes @{{ formatedDate(week.monday) }}</th>
                    <th scope="col">Martes @{{ formatedDate(week.tuesday) }}</th>
                    <th scope="col">Miércoles @{{ formatedDate(week.wednesday) }}</th>
                    <th scope="col">Jueves @{{ formatedDate(week.thursday) }}</th>
                    <th scope="col">Viernes @{{ formatedDate(week.friday) }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in listTypes" :key="item.id">
                    <td>@{{ item.name }}</td>
                    <td :class="getBillByDay(item.id, week.monday) == '' ? 'bg-danger' : ''">
                        <p class="text-center"><span v-html="getBillByDay(item.id, week.monday)"></span></p>
                        <button type="button" class="btn btn-primary btn-block mt-2"
                            @click="openModal( item, 0)">Seleccionar</button>
                    </td>
                    <td :class="getBillByDay(item.id, week.tuesday) == '' ? 'bg-danger' : ''">
                        <p class="text-center"><span v-html="getBillByDay(item.id, week.tuesday)"></span></p>
                        <button type="button" class="btn btn-primary btn-block mt-2"
                            @click="openModal( item, 1)">Seleccionar</button>
                    </td>
                    <td :class="getBillByDay(item.id, week.wednesday) == '' ? 'bg-danger' : ''">
                        <p class="text-center"><span v-html="getBillByDay(item.id, week.wednesday)"></span></p>
                        <button type="button" class="btn btn-primary btn-block mt-2"
                            @click="openModal( item, 2)">Seleccionar</button>
                    </td>
                    <td :class="getBillByDay(item.id, week.thursday) == '' ? 'bg-danger' : ''">
                        <p class="text-center"><span v-html="getBillByDay(item.id, week.thursday)"></span></p>
                        <button type="button" class="btn btn-primary btn-block mt-2"
                            @click="openModal( item, 3)">Seleccionar</button>
                    </td>
                    <td :class="getBillByDay(item.id, week.friday) == '' ? 'bg-gradient-danger' : ''">
                        <p class="text-center"><span v-html="getBillByDay(item.id, week.friday)"></span></p>
                        <button type="button" class="btn btn-primary btn-block mt-2"
                            @click="openModal( item, 4)">Seleccionar</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-warning text-white" @click="billStore()"><i class="fas fa-spinner fa-spin"
                    v-if="loading"></i>
                @{{ isProgrammed ? 'Actualizar' : 'Programar' }}</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createBillModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createBillModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBillModalLabel">Seleccionar @{{ typeMenu.name }} para el día
                            @{{ day.formatted }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reset()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select class="form-control" v-model="menuId">
                                            <option v-for="(menu, index) in listMenusByType" :key="menu.cod"
                                                :value="menu.id">
                                                @{{ menu.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" v-model.trim="counter">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
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
    <script src="{{ asset('assets/js/admin/bill-create.js?v=' . time()) }}"></script>
@stop
