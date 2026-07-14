function getInitialData() {
  return {
            day: null,
            orders: [],
            order: [],
            ordersDay: [],
            orderDetails: []
        };
}
new Vue({
            el: '#app',
            data() {
                return getInitialData();
            },
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
                    this.day = lastSegment;
                    this.getOrders();
                    this.getOrdersDetails();
                },
                getOrders() {
                    const self = this;
                    axios.get(`/api/order/details/final/${this.day}/1`)
                        .then(function(response) {
                            self.ordersDay = response.data.data.ordersDay;
                            self.orders = response.data.data.orders;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                getOrdersDetails() {
                    const self = this;
                    axios.get(`/api/order/details/final/day/${this.day}/1`)
                        .then(function(response) {
                            self.orderDetails = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                getOrderByNumber(orderNumber) {
                    const self = this;
                    axios.get(`/api/order/details/final/order/${orderNumber}`)
                        .then(function(response) {
                            self.order = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                latinDate(date) {
                    const day = date.substring(8, 10);
                    const month = date.substring(5, 7);
                    const year = date.substring(0, 4);
                    return `${day}/${month}/${year}`;
                },
                openModal(order) {
                    this.getOrderByNumber(order);
                    $('#createOrderModal').modal('show');
                },
                countMenu(order, typeMenu, clientFinalId) {
                    const obj = this.orderDetails.find(detail => detail.type_menu_id == typeMenu && detail.order_id == order.id && detail.client_final_id == clientFinalId);
                    return obj ? obj.count : 0;
                }
            }
        });