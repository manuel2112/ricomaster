function getInitialData() {
  return {
            associateds: [],
            loading: false,
            associated: null,
            minuta: null,
            cantidad: [],
            priceItem: [],
            total: null,
            client: {
                order: false,
                name: null,
                whatsapp: null,
            },
            orderDetail: [],
            isActive: true,
            isHoliday: true,
        };
}
new Vue({
        el: '#app',
        data() {
            return getInitialData();
        },
        created() {
            this.getAssociateds();
            this.getActualBill();
        },
        watch: {
            cantidad(value) {
                this.calculateTotal(value);
            },
        },
        methods: {
            getAssociateds() {
                const self = this;
                this.loading = true;
                axios.get('/api/associated/list/1')
                    .then(function(response) {
                        self.associateds = response.data.data;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {
                        self.loading = false;
                    });
            },
            getActualBill() {
                const self = this;
                axios.get('/api/bill/minuta')
                    .then(function(response) {
                        self.isActive = response.data.data.isActive;
                        self.minuta = response.data.data.menu.filter(bill => bill.active)[0];
                        self.isHoliday = self.minuta ? self.minuta.is_holiday : true;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {});
            },
            selectAssociated(associated){
                this.associated = associated;
            },
            fnCreateImage(path) {
                return asset + path;
            },
            calculateTotal(value) {
                value.forEach((cantidad, index) => {
                    const menu = this.minuta.menus.find(menu => menu.id == index);
                    if(parseInt(cantidad) > parseInt(menu.counter)){
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: `La cantidad solicitada (${cantidad}) supera el límite disponible (${menu.counter}) para el menú ${menu.menu.name}.`,
                        });
                        this.cantidad[menu.id] = null;
                        return;
                    }
                    const price = menu.type_menu_id != 4 ? this.associated.menu_normal_final : this.associated.menu_special_final;
                    this.priceItem[index] = menu ? price * cantidad : null;
                });
                // this.placeOrder();
                this.total = this.priceItem.reduce((acc, price) => acc + (price || 0), 0);
            },
            placeOrder() {
                let orderDetail = {};
                this.orderDetail = [];
                this.cantidad.forEach((cantidad, index) => {
                    if(cantidad > 0) {
                        const menu = this.minuta.menus.find(menu => menu.id == index);
                        if(menu) {
                            orderDetail = {};
                            orderDetail.bill_id = menu.id;
                            orderDetail.menu_id = menu.menu_id;
                            orderDetail.type_menu_id = menu.type_menu_id;
                            orderDetail.count = cantidad;
                            orderDetail.price = menu.type_menu_id != 4 ? this.associated.menu_normal_final : this.associated.menu_special_final;
                            this.orderDetail.push(orderDetail);           
                        }
                    }
                });
                this.client.order = true;
            },
            confirmOrder() {
                if( !this.client.name || !this.client.whatsapp || this.client.whatsapp.length != 9 ){
                    Swal.fire({
                        icon: "error",
                        title: "Pedido",
                        text: "Tu Nombre y Whastapp son obligatorios.",
                    });
                    return;
                }

                const self = this;
                this.loading = true;
                axios.post('/api/order/final', {
                        associated: this.associated,
                        order: this.orderDetail,
                        client: this.client,
                        day_order: this.minuta.day_order,
                    })
                    .then(function(response) {
                        let resumeOrderHtml = self.getResumeOrder();
                        if(response.data.data){
                            Swal.fire({
                                icon: "success",
                                title: "Resumen de tu Pedido",
                                html: `Fecha pedido: <b>${self.minuta.strDay} ${self.minuta.day}</b><br>
                                       Cliente N°: <b>${response.data.data}</b><br>
                                       Nombre: <b>${self.client.name}</b><br>
                                       Whatsapp: <b>+56${self.client.whatsapp}</b><br>
                                       Local donde retira: <b>${self.associated.name}</b><br>
                                       Dirección del local donde retira: <b>${self.associated.address}, ${self.associated.commune}</b><br><br>
                                       Resumen platos solicitados:<br>
                                        ${resumeOrderHtml}
                                       <br>
                                       Estimado (a}, ${self.client.name} haz realizado correctamente tu pedido, para ser retirado a partir de las 13.00 hrs. del dia de hoy. Cualquier problema nos comunicaremos contigo al teléfono indicado.`,
                                allowOutsideClick: false
                            });
                            self.reset();
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {
                        self.loading = false;
                    });
            },
            getResumeOrder(){
                let resume = '';
                let total = 0;
                this.orderDetail.forEach(order => {
                    if(order && order.count > 0){
                        const menu = this.minuta.menus.find(m => m.menu_id == order.menu_id);
                        const menuName = menu ? menu.menu.name : 'Desconocido';
                        resume += `<tr><td>${menuName}</td><td>${order.count}</td></tr>`;
                        total += order.price * order.count;
                    }
                });
                 resume += `<tr><td>A Pagar</td><td>${formatPrice(total)}</td></tr>`;
                 const table = `<table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Opción</th>
                                            <th scope="col">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${ resume }
                                    </tbody>
                                </table>`;
                return table;
            },
            limitLength() {
                const maxLength = 9;
                if (this.client.whatsapp > maxLength) {
                    this.client.whatsapp = this.client.whatsapp.slice(0, maxLength);
                }
            },
            reset(){
                Object.assign(this.$data, getInitialData());
                this.getAssociateds();
                this.getActualBill();
            },
        }
    });