new Vue({
            el: '#app',
            data() {
                return {
                    dayParams: null,
                    orderDayAssociated: [],
                    orderDayFinal: [],
                };
            },
            beforeCreate() {},
            created() {
                this.getDay();
            },
            methods: {
                getDay() {
                    const urlString = window.location.href;
                    const url = new URL(urlString);
                    const pathname = url.pathname;
                    const segments = pathname.split('/').filter(segment => segment.length > 0);
                    const countryCode = segments[0]; // "en-US"
                    const lastSegment = segments[segments.length - 1]; // "pathname"
                    this.dayParams = lastSegment;
                    this.instantiate();
                },
                instantiate() {
                    const self = this;
                    axios.get(`/api/order/details/${this.dayParams}`)
                        .then(function(response) {
                            self.orderDayAssociated = response.data.data.ordersAssociated;
                            self.orderDayFinal = response.data.data.ordersFinal;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                totalSailAssociated() {
                    let total = 0;
                    this.orderDayAssociated.forEach(item => {
                        total += item.count * item.price;
                    });
                    return this.formatMoney(total);
                },
                totalSailFinal() {
                    let total = 0;
                    this.orderDayFinal.forEach(item => {
                        total += item.count * item.price;
                    });
                    return this.formatMoney(total);
                },
                totalSail() {
                    let total = 0;
                    this.orderDayAssociated.forEach(item => {
                        total += item.count * item.price;
                    });
                    this.orderDayFinal.forEach(item => {
                        total += item.count * item.price;
                    });
                    return this.formatMoney(total);
                },
                formatMoney(value) {
                    let formatterBasico = new Intl.NumberFormat('es-CL', {
                        style: 'currency',
                        currency: 'CLP',
                        minimumFractionDigits: 0
                    });
                    return formatterBasico.format(value);
                }
            }
        });