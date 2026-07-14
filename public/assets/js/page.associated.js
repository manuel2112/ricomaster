function getInitialData() {
  return {
            login: null,
            associated: null,
            minuta: null,
            cantidad: [],
            priceItem: [],
            total: null,
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
        watch: {            
            login(newVal) {
                if (!newVal) return;

                const rutLimpio = newVal.replace(/[^0-9kK]/g, '');

                const cuerpo = rutLimpio.slice(0, -1);
                const dv = rutLimpio.slice(-1).toUpperCase();

                if (rutLimpio.length < 2) return rutLimpio;

                let cuerpoFormatoMiles = cuerpo
                    .toString()
                    .split('')
                    .reverse()
                    .join('')
                    .replace(/(?=\d*\.?)(\d{3})/g, '$1.');

                cuerpoFormatoMiles = cuerpoFormatoMiles
                    .split('')
                    .reverse()
                    .join('')
                    .replace(/^[\.]/, '');

                this.login = `${cuerpoFormatoMiles}-${dv}`;
            },
            cantidad(value) {
                this.calculateTotal(value);
            },
        },
        created() {
            this.getActualBill();
        },
        methods: {
            getAssociated() {
                if(!this.login) return;

                const self = this;
                this.loading = true;
                axios.post('/api/associated/search', { rut: this.login })
                    .then(function(response) {
                        if(response.data.success && response.data.data){
                            self.associated = response.data.data;
                        }else{
                            Swal.fire({
                            title: "Asociado",
                            text: "El asociado no fue encontrado.",
                            icon: "error"
                            });
                        }
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
            fnCreateImage(path) {
                return asset + path;
            },
            calculateTotal(value) {
                value.forEach((cantidad, index) => {
                    const menu = this.minuta.menus.find(menu => menu.id == index);
                    const price = menu.type_menu_id != 4 ? this.associated.menu_normal_associated : this.associated.menu_special_associated;
                    this.priceItem[index] = menu ? price * cantidad : null;
                });
                this.placeOrder();
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
                            orderDetail.price = menu.type_menu_id != 4 ? this.associated.menu_normal_associated : this.associated.menu_special_associated;
                            this.orderDetail.push(orderDetail);                            
                        }
                    }
                });
            },
            confirmOrder() {
                if( !this.total ){
                    Swal.fire({
                        icon: "error",
                        title: "Pedido",
                        text: "Debes realizar tu pedido.",
                    });
                    return;
                }

                const self = this;
                this.loading = true;
                axios.post('/api/order/associated', {
                        associated: this.associated,
                        order: this.orderDetail,
                        day_order: this.minuta.day_order,
                    })
                    .then(function(response) {
                        let resumeOrderHtml = self.getResumeOrder();
                        if(response.data.data){
                            Swal.fire({
                                icon: "success",
                                title: "Resumen de tu Pedido",
                                html: `Fecha pedido: <b>${self.minuta.strDay} ${self.minuta.day}</b><br>
                                       Nombre: <b>${self.associated.name}</b><br>
                                       RUT: <b>${self.associated.rut}</b><br>
                                       WhatsApp: <b>${self.associated.whatsapp}</b><br><br>
                                       Resumen platos solicitados:<br>
                                       ${resumeOrderHtml}
                                       <br>
                                       Estimado comercio, el Horario para enviar tu pedido es hasta las 10:15. del día solicitado`,
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
                                        ${resume}
                                    </tbody>
                                </table>`;
                return table;
            },
            reset(){
                Object.assign(this.$data, getInitialData());
                this.getActualBill();
            },
        }
    });