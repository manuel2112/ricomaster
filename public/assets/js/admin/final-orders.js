function getInitialData() {
  return {
            listDays: [],
        };
}
new Vue({
            el: '#app',
            data() {
                return getInitialData();
            },
            created() {
                this.getOrders();
            },
            methods: {
                getOrders() {
                    const self = this;
                    axios.get(`/api/order/final`)
                        .then(function(response) {
                            self.listDays = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
            }
        });