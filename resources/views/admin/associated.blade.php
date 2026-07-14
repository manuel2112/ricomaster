@extends('adminlte::page')

@section('title', 'Asociados')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <h1>Asociados</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAssociatedModal">Crear
                    asociado</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div id="app">

        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Cod.</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">RUT</th>
                    <th scope="col">Razón</th>
                    <th scope="col">Dir.</th>
                    <th scope="col">Comuna</th>
                    <th scope="col">Mapa</th>
                    <th scope="col">Wa</th>
                    <th scope="col">V. Aso.</th>
                    <th scope="col">V. Final.</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in listAssociated" :key="item.id">
                    <td>@{{ item.cod }}</td>
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.rut }}</td>
                    <td>@{{ item.social_name }}</td>
                    <td>@{{ item.address }}</td>
                    <td>@{{ item.commune }}</td>
                    <td><a :href="item.map" target="_blank" class="btn btn-outline-warning">Ver mapa</a></td>
                    <td>+56@{{ item.whatsapp }}</td>
                    <td>@{{ formatPrice(item.menu_normal_associated) }} / @{{ formatPrice(item.menu_special_associated) }}</td>
                    <td>@{{ formatPrice(item.menu_normal_final) }} / @{{ formatPrice(item.menu_special_final) }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-warning btn-sm" @click="openModal(2, item)"><i
                                    class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" @click="remove(item.id)"><i
                                    class="fas fa-trash"></i></button>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="createAssociatedModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createAssociatedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAssociatedModalLabel">@{{ modal.title }} Asociado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reset()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codAssociated">Código <small class="text-danger" v-if="error.cod">Campo
                                                obligatorio</small></label>
                                        <input type="text" class="form-control" :class="error.cod ? 'is-invalid' : ''"
                                            id="codAssociated" v-model.trim="associated.cod">
                                    </div>

                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="rutAssociated">RUT <small class="text-danger" v-if="error.rut">Campo
                                                obligatorio</small></label>
                                        <input type="text" class="form-control" :class="error.rut ? 'is-invalid' : ''"
                                            id="rutAssociated" v-model.trim="associated.rut" maxlength="12">
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nameAssociated">Nombre <small class="text-danger"
                                                v-if="error.name">Campo
                                                obligatorio</small></label>
                                        <input type="text" class="form-control" :class="error.name ? 'is-invalid' : ''"
                                            id="nameAssociated" v-model.trim="associated.name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="socialNameAssociated">Razón social <small class="text-danger"
                                                v-if="error.social_name">Campo
                                                obligatorio</small></label>
                                        <input type="text" class="form-control"
                                            :class="error.social_name ? 'is-invalid' : ''" id="socialNameAssociated"
                                            v-model.trim="associated.social_name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addressAssociated">Dirección <small class="text-danger"
                                        v-if="error.address">Campo
                                        obligatorio</small></label>
                                <input type="text" class="form-control" :class="error.address ? 'is-invalid' : ''"
                                    id="addressAssociated" v-model.trim="associated.address">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="communeAssociated">Comuna <small class="text-danger"
                                                v-if="error.commune">Campo
                                                obligatorio</small></label>
                                        <input type="text" class="form-control"
                                            :class="error.commune ? 'is-invalid' : ''" id="communeAssociated"
                                            v-model.trim="associated.commune">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="whatsappAssociated">Whatsapp <small class="text-danger"
                                                v-if="error.whatsapp">Campo
                                                obligatorio - 9 dígitos</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+56</span>
                                            </div>
                                            <input type="number" class="form-control"
                                                :class="error.whatsapp ? 'is-invalid' : ''" id="whatsappAssociated"
                                                placeholder="9 dígitos" v-model.trim="associated.whatsapp"
                                                @input="limitLength()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="mapAssociated">Mapa <small class="text-danger" v-if="error.map">Campo
                                        obligatorio</small></label>
                                <input type="text" class="form-control" :class="error.map ? 'is-invalid' : ''"
                                    id="mapAssociated" v-model.trim="associated.map">
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="menuNormalAssociated">Menú normal asociado <small class="text-danger"
                                                v-if="error.menu_normal_associated">Campo
                                                obligatorio</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control"
                                                :class="error.menu_normal_associated ? 'is-invalid' : ''"
                                                id="menuNormalAssociated"
                                                v-model.trim="associated.menu_normal_associated">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="menuSpecialAssociated">Menú especial asociado <small
                                                class="text-danger" v-if="error.menu_special_associated">Campo
                                                obligatorio</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control"
                                                :class="error.menu_special_associated ? 'is-invalid' : ''"
                                                id="menuSpecialAssociated"
                                                v-model.trim="associated.menu_special_associated">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="menuNormalFinal">Menú normal final <small class="text-danger"
                                                v-if="error.menu_normal_final">Campo
                                                obligatorio</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control"
                                                :class="error.menu_normal_final ? 'is-invalid' : ''" id="menuNormalFinal"
                                                v-model.trim="associated.menu_normal_final">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="menuSpecialFinal">Menú especial final <small class="text-danger"
                                                v-if="error.menu_special_final">Campo
                                                obligatorio</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control"
                                                :class="error.menu_special_final ? 'is-invalid' : ''"
                                                id="menuSpecialFinal" v-model.trim="associated.menu_special_final">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" :disabled="loading"
                                    @click="storeUpdateAssociated()"><i class="fas fa-spinner fa-spin"
                                        v-if="loading"></i>
                                    @{{ modal.btn }}</button>
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
    <script src="{{ asset('assets/js/admin/associated.js?v=' . time()) }}"></script>
@stop
