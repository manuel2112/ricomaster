function getInitialData() {
  return {
            campaign: [],
            bill: [],
            client: {
                order: false,
                name: null,
                whatsapp: null,
            },
            total: null,
            orderDetail: [],
            isActive: false,
        };
}
new Vue({
        el: '#app',
        data() {
            return getInitialData();
        },
        created() {
            // this.getAssociateds();
            this.getActualCampaign();
        },
        methods: {
            getActualCampaign() {
                const self = this;
                axios.get('/api/campaign/today')
                    .then(function(response) {
                        self.campaign = response.data.data;
                        self.bill = self.campaign.bill.map(menu => ({ menu: menu.id, count: null }));
                        self.isActive = self.campaign.isActive;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {});
            },
            fnCreateImage(path) {
                return asset + path;
            },
            calculateTotal(idx, value) {
                if(!this.bill[idx].associated_id){
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: `Debes seleccionar un local para el menú ${this.campaign.bill[idx].menu.name} antes de ingresar la cantidad.`,
                        });
                        this.bill[idx].count = null;
                }
                if(value > this.campaign.bill[idx].counter) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: `La cantidad ingresada para el menú ${this.campaign.bill[idx].menu.name} supera la cantidad disponible.`,
                        });
                        this.bill[idx].count = null;
                }
                let totalPrice = 0;
                this.bill.forEach((billItem, index) => {
                    if(billItem && billItem.count > 0) {
                        const menu = this.campaign.bill[index];
                        if(menu) {
                            const price = menu.price || 0;
                            totalPrice += price * billItem.count;
                        }
                    }
                });
                this.placeOrder();
                this.total = totalPrice;
            },
            getResumeOrder(){
                let resume = '';
                let total = 0;
                this.bill.forEach((billItem, index) => {
                    if(billItem && billItem.count > 0){
                        const menu = this.campaign.bill[index];
                        const menuName = menu ? menu.menu.name : 'Desconocido';
                        const associatedName = menu ? this.campaign.associateds.find(a => a.associated.id === billItem.associated_id)?.associated.name : 'Desconocido';
                        resume += `<tr><td>${associatedName}</td><td>${menuName}</td><td>${billItem.count}</td></tr>`;
                        total += menu.price * billItem.count;
                    }
                });
                 resume += `<tr><td colspan="2">A Pagar</td><td>${formatPrice(total)}</td></tr>`;
                 const table = `<table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Local</th>
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
            placeOrder() {
                let orderDetail = {};
                this.orderDetail = [];
                this.bill.forEach((item, index) => {
                    if(item.associated_id > 0 && item.count > 0 && item.menu > 0) {
                        orderDetail = {};
                        orderDetail.bill_id = item.menu;
                        orderDetail.associated_id = item.associated_id;
                        orderDetail.count = item.count;
                        orderDetail.campaign_id = this.campaign.campaign.id;
                        orderDetail.menu_id = this.campaign.bill[index].menu_id;
                        orderDetail.price = parseInt(this.campaign.bill[index].price) * parseInt(item.count);
                        this.orderDetail.push(orderDetail);
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
                axios.post('/api/order/final/campaign', {
                        orders: this.orderDetail,
                        client: this.client,
                        day_order: this.campaign.today,
                    })
                    .then(function(response) {
                        let resumeOrderHtml = self.getResumeOrder();
                        if(response.data.data){
                            Swal.fire({
                                icon: "success",
                                title: "Resumen de tu Pedido",
                                html: `Fecha pedido: <b>${self.campaign.today}</b><br>
                                       Cliente N°: <b>${response.data.data}</b><br>
                                       Nombre: <b>${self.client.name}</b><br>
                                       Whatsapp: <b>+56${self.client.whatsapp}</b><br>
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
            limitLength() {
                const maxLength = 9;
                if (this.client.whatsapp > maxLength) {
                    this.client.whatsapp = this.client.whatsapp.slice(0, maxLength);
                }
            },
            reset(){
                Object.assign(this.$data, getInitialData());
                this.getActualCampaign();
                this.placeOrder();
            },            
        }
    });