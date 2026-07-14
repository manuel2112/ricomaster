function getInitialData() {
  return {
            minutas: [],
        };
}
new Vue({
        el: '#app',
        data() {
            return getInitialData();
        },
        created() {
            this.fnActualBill();
        },
        methods: {
            fnActualBill() {
                const self = this;
                axios.get('/api/bill/minuta')
                    .then(function(response) {
                        self.minutas = response.data.data.menu;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {});
            },
            fnCreateImage(path) {
                return asset + path;
            },
        }
    });