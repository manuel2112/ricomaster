@extends('layouts.public')

@section('title', 'Campaña')

@section('content')

    <div class="container mt-4" v-if="campaign.bill?.length == 0 || !isActive">
        <div class="row">
            <div class="col">
                <div class="alert alert-danger text-center">
                    <strong>Estimado cliente:</strong> Campaña inactiva
                </div>
            </div>
        </div>
    </div>

    <!-- Book A Table Section -->
    <section class="container" id="book-a-table" class="book-a-table section">
        <div id="select-local">
            <div class="row" v-if="campaign.bill?.length > 0 && isActive">
                <div class="col-12 text-center">
                    <h2>Campaña del día @{{ formatDate(campaign.today) }}</h2>
                </div>
                <div class="col-12 text-center mt-4">
                    <template v-for="(menu, idxMenu) in campaign.bill" :key="idxMenu">
                        <h2>@{{ menu.menu.name }}</h2>
                        <img :src="fnCreateImage(menu.menu.image)" alt="Menu Image"
                            style="width: 320px; object-fit: cover; border-radius: 5px;" v-if="menu.menu.image" />
                        <h2>@{{ formatPrice(menu.price) }}</h2>
                        <div>
                            <template v-for="(associated, idxAssociated) in campaign.associateds" :key="idxAssociated">
                                <input type="radio" class="btn-check" :name="'options-outlined-' + idxMenu"
                                    :id="'option-' + idxAssociated + '-' + idxMenu" v-model="bill[idxMenu].associated_id"
                                    :value="associated.associated.id" autocomplete="off">
                                <label class="btn btn-outline-primary"
                                    :for="'option-' + idxAssociated + '-' + idxMenu">@{{ associated.associated.name }}</label>
                            </template>
                        </div>
                        <small class="text-danger">
                            <template v-if="menu.counter == 0">
                                No disponible
                            </template>
                            <template v-else>
                                Cantidad disponible: @{{ menu.counter }} unidades
                            </template>
                        </small>
                        <input type="number" class="form-control w-25 mt-2 mx-auto" placeholder="Cantidad..."
                            v-model="bill[idxMenu].count" @input="calculateTotal(idxMenu, bill[idxMenu].count)"
                            min="0" v-if="menu.counter > 0">
                        <h4 class="mt-2" v-if="bill[idxMenu].associated_id != null && bill[idxMenu].count > 0">Por pagar:
                            @{{ formatPrice(menu.price * bill[idxMenu].count) }}</h4>
                        <hr />
                    </template>

                    <div class="row mb-3" v-if="bill.some(item => item.count > 0)">
                        <h4>Ingresa tus datos</h4>
                        <div class="col-md-4 offset-md-4">
                            <div class="form-group">
                                <label for="nameClient">Nombre</label>
                                <input type="text" class="form-control" id="nameClient" placeholder="Tu nombre completo"
                                    v-model.trim="client.name">
                            </div>
                            <div class="form-group mt-3">
                                <label for="whatsappClient">Whatsapp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+56</span>
                                    </div>
                                    <input type="number" class="form-control" id="whatsappClient" placeholder="9 dígitos"
                                        v-model.trim="client.whatsapp" @input="limitLength()">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="total !=null && total> 0" class="col-12 text-center mt-4">
                        <div v-html="getResumeOrder()"></div>
                    </div>
                    <button class="btn btn-primary" @click=" client.order ? confirmOrder() : placeOrder()"
                        :disabled="total == null || total <= 0">
                        @{{ client.order ? 'Confirma tu pedido' : 'Realizar pedido' }}
                    </button>
                    {{-- <h4 class="mt-2" v-if="total != null && total > 0">Total a pagar: @{{ formatPrice(total) }}</h4> --}}
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/page.campaign.js?v=' . time()) }}"></script>
@endpush
