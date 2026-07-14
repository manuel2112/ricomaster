@extends('adminlte::page')

@section('title', 'Cliente Final WhatsApp')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Cliente Final WhatsApp</h1>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-primary">Volver</a>
    </div>
@stop

@section('content')
    <div id="app">

        <div class="row mb-3 d-flex justify-content-end">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary" v-if="optMenu == 'SI'" @click="openModal">ENVIAR
                    MENSAJE</button>
                <button type="button" class="btn btn-outline-success" :class="{ active: optMenu == 'SI' }"
                    @click="changeOpt('SI')">SI</button>
                <button type="button" class="btn btn-outline-danger" :class="{ active: optMenu == 'NO' }"
                    @click="changeOpt('NO')">NO</button>
                <button type="button" class="btn btn-outline-warning" :class="{ active: optMenu == 'TODOS' }"
                    @click="changeOpt('TODOS')">TODOS</button>
            </div>
        </div>

        <div v-if="finals.length > 0">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Nombre Cliente</th>
                        <th scope="col">N° WhatsApp</th>
                        <th scope="col">Local Último Retiro</th>
                        <th scope="col">Sum, Últimos 30 Días</th>
                        <th scope="col" v-if="optMenu == 'SI'">Acción Enviar Whatsapp</th>
                        <th scope="col">Acción Desea Whatsapp</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(final, index) in finals" :key="index">
                        <td>@{{ final.name }}</td>
                        <td>+@{{ final.whatsapp }}</td>
                        <td>@{{ final.associated ? final.associated.name : '---' }}</td>
                        <td>@{{ formatPrice(final.mount) }}</td>
                        <td v-if="optMenu == 'SI'">
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-primary">
                                    <input type="checkbox" :value="final.id" v-model="groupedFinals">ENVIAR
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-success"
                                    :class="{ active: final.send }">SI</button>
                                <button type="button" class="btn btn-outline-danger" :class="{ active: !final.send }"
                                    @click="stateWhatsapp(final)">NO</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createMessageModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createMessageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createMessageModalLabel">Mensaje de whatsapp</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" name="message" rows="8" v-model="message" placeholder="Tu mensaje aquí..."
                            required></textarea>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="sendMessage">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <x-base-scripts />
    <script src="{{ asset('assets/js/admin/final-whatsapp.js?v=' . time()) }}"></script>
@stop
