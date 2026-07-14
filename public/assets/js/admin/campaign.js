function getInitialData() {
  return {
            associateds: [],
            selectedAssociateds: [],
            error: {
                associated: false,
            },
            minuta: null,
            menuId: 0,
            counter: 0,
            price: 0,
            loading: false,
            listCampaigns: [],
            campaign: null,
            today: null,
        };
}
new Vue({
        el: '#app',
        data() {
            return getInitialData();
        },
        created() {
            this.getCampaigns();
            this.getAssociateds();
            this.getActualBill();
        },
        computed: {
            createCampaign(){
                return !(this.listCampaigns.some(campaign => campaign.day == this.today));
            }
        },
        methods: {
            getCampaigns() {
                const self = this;
                axios.get('/api/campaign/list')
                    .then(function(response) {
                        self.listCampaigns = response.data.data.campaigns;
                        self.today = response.data.data.today;
                        self.counter = response.data.data.parameters.campaign_counter_default;
                        self.price = response.data.data.parameters.campaign_price_default;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {
                    });
            },
            getCampaign(id) {
                const self = this;
                axios.get(`/api/campaign/${id}`)
                    .then(function(response) {
                        self.campaign = response.data.data;
                        self.selectedAssociateds = response.data.data.associateds.map(associated => associated.associated_id);
                        $('#createCampaignModal').modal('show');
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {});
            },
            getAssociateds() {
                const self = this;
                axios.get('/api/associated/list/1')
                    .then(function(response) {
                        self.associateds = response.data.data;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {
                    });
            },
            getActualBill() {
                const self = this;
                axios.get('/api/bill/minuta/today')
                    .then(function(response) {
                        self.minuta = response.data.data;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {});
            },
            async storeUpdateBill(day) {
                
                if (this.selectedAssociateds.length == 0) {
                    Swal.fire(
                        'Error',
                        'Debe seleccionar al menos un asociado',
                        'error'
                    );
                    return;
                }
                if (this.menuId == 0) {
                    Swal.fire(
                        'Error',
                        'Debe seleccionar un menú',
                        'error'
                    );
                    return;
                }
                if (!this.counter ||this.counter < 0) {
                    Swal.fire(
                        'Error',
                        'Debe ingresar una cantidad mayor igual a cero',
                        'error'
                    );
                    return;
                }

                const payload = {
                    associateds: this.selectedAssociateds,
                    menu_id: this.menuId,
                    counter: this.counter,
                    price: this.price,
                };

                const self = this;
                this.loading = true;
                await axios.post('/api/bill/campaign', payload)
                    .then(function(response) {
                        self.campaign = response.data.data;
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
                    .finally(function() {
                        self.loading = false;
                    });
            },
            fnIsToday(day){
                return day.toString() == this.today.toString();
            },
            reset(){
                this.campaign = null;
                this.selectedAssociateds = [];
                this.getCampaigns();
                // Object.assign(this.$data, getInitialData());
            },
        }
    });