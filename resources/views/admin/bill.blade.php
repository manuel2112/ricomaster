@extends('adminlte::page')

@section('title', 'Minuta')

@section('content_header')
    <h1>Minuta</h1>
@stop

@section('content')
    <div id="app">
        <a href="{{ route('admin.bill.create', 1) }}" class="btn btn-primary" v-if="programmed && !isProgrammed">Programar
            minuta
            de la
            semana del @{{ nextBill?.date }}</a><br />
        <a href="{{ route('admin.bill.create', 0) }}" class="btn btn-primary mt-1" v-if="existWeekProgrammed">Programar minuta
            de la
            semana del @{{ existWeekProgrammed?.first_day }}</a>

        <table class="table table-hover table-dark mt-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Semana</th>
                    <th scope="col">Fechas</th>
                    <th scope="col">Ver</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in weeksBill" :key="item.id" :class="fnClassBackground(item)">
                    <td>@{{ index + 1 }}</td>
                    <td>@{{ item.week }}</td>
                    <td>@{{ formatDate(item.first_day) }} - @{{ endDateWeek(item.first_day) }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" @click="showBill(item)">
                            <i :class="item.programmed ? 'fas fa-pen' : 'fas fa-eye'"></i></button>
                        <a :href="`/admin/minuta/editar/${item.id}`" class="btn btn-primary"
                            v-if="item.actual || item.programmed">
                            <i class="fas fa-edit"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="showBillModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="showBillModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showBillModalLabel">Minuta del @{{ formatedDate(week.monday) }} al
                            @{{ formatedDate(week.friday) }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Menú\Día</th>
                                    <th scope="col">Lunes<br /> @{{ formatedDate(week.monday) }}</th>
                                    <th scope="col">Martes<br /> @{{ formatedDate(week.tuesday) }}</th>
                                    <th scope="col">Miércoles<br /> @{{ formatedDate(week.wednesday) }}</th>
                                    <th scope="col">Jueves<br /> @{{ formatedDate(week.thursday) }}</th>
                                    <th scope="col">Viernes<br /> @{{ formatedDate(week.friday) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in listTypes" :key="item.id">
                                    <td>@{{ item.name }}</td>
                                    <td>@{{ getBillByDay(item.id, week.monday) }}</td>
                                    <td>@{{ getBillByDay(item.id, week.tuesday) }}</td>
                                    <td>@{{ getBillByDay(item.id, week.wednesday) }}</td>
                                    <td>@{{ getBillByDay(item.id, week.thursday) }}</td>
                                    <td>@{{ getBillByDay(item.id, week.friday) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/bill.js?v=' . time()) }}"></script>
@stop
