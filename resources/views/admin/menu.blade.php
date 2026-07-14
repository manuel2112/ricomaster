@extends('adminlte::page')

@section('title', 'Menú')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <h1>Menú</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMenuModal">Crear
                    menú</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div id="app">

        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Menú</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in listMenu" :key="item.id">
                    <td>@{{ item.cod }}</td>
                    <td>
                        @{{ item.name }} <br />
                        <h5>
                            <small class="badge badge-info mr-1" v-if="showTypeMenu(item.types, 1)">Menú 1</small>
                            <small class="badge badge-info mr-1" v-if="showTypeMenu(item.types, 2)">Menú 2</small>
                            <small class="badge badge-info mr-1" v-if="showTypeMenu(item.types, 3)">Naturista</small>
                            <small class="badge badge-info mr-1" v-if="showTypeMenu(item.types, 4)">Menú Especial</small>
                        </h5>
                    </td>
                    <td>
                        <img :src="pathImage(item.image)" alt="Preview" class="img-thumbnail" width="100px"
                            v-if="item.image">
                        <img src="{{ asset('assets/img/other/no-image.png') }}" alt="Preview" class="img-thumbnail"
                            width="100px" v-else>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-warning btn-sm" @click="openModal(2, item)"><i
                                    class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" @click="remove(item.id)" v-if="item.id != 1"><i
                                    class="fas fa-trash"></i></button>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="createMenuModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createMenuModalLabel">@{{ modal.title }} Menú</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reset()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="codMenu">Código <small class="text-danger" v-if="error.cod">Campo
                                        obligatorio</small></label>
                                <input type="text" class="form-control col-2" :class="error.cod ? 'is-invalid' : ''"
                                    id="codMenu" v-model.trim="menu.cod">
                            </div>
                            <div class="form-group">
                                <label for="nameMenu">Menú <small class="text-danger" v-if="error.name">Campo
                                        obligatorio</small></label>
                                <input type="text" class="form-control" :class="error.cod ? 'is-invalid' : ''"
                                    id="nameMenu" v-model.trim="menu.name">
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-inline" v-for="item in listTypeMenu"
                                    :key="item.id">
                                    <input class="form-check-input" type="checkbox" :id="`inlineCheckbox${item.id}`"
                                        :value="item.id" v-model="menu.types" v-if="menu.id">
                                    <input class="form-check-input" type="checkbox" :id="`inlineCheckbox${item.id}`"
                                        :value="item.id" v-model="selectedTypeMenu" v-else>
                                    <label class="form-check-label"
                                        :for="`inlineCheckbox${item.id}`">@{{ item.name }}</label>
                                </div>
                                <small class="text-danger" v-if="error.type">Seleccionar al menos un tipo de menú</small>
                            </div>
                            <div class="form-group">
                                <label for="imgMenu">Imagen</label>
                                <input type="file" id="profile_image_url" name="profile_image_url"
                                    @change="handleImageChange" class="absolute w-full h-full opacity-0 top-0"
                                    ref="fileupload" accept="image/*" />
                                <template v-if="modal.title == 'Crear'">
                                    store
                                    <img :src="imagePreview" alt="Preview" class="img-thumbnail" width="150px"
                                        v-if="imagePreview">
                                </template>
                                <template v-else>
                                    <img :src="imagePreview" alt="Preview" class="img-thumbnail" width="150px"
                                        v-if="imagePreview">
                                    <img :src="pathImage(menu.image)" alt="Preview" class="img-thumbnail"
                                        width="150px" v-if="menu.image && !menu.newImage">
                                    <img src="{{ asset('assets/img/other/no-image.png') }}" alt="Preview"
                                        class="img-thumbnail" width="150px" v-if="!menu.image && !menu.newImage">
                                </template>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" :disabled="loading"
                                    @click="storeUpdateMenu()"><i class="fas fa-spinner fa-spin" v-if="loading"></i>
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
    <script src="{{ asset('assets/js/admin/menu.js?v=' . time()) }}"></script>
@stop
