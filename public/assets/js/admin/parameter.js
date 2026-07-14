function getInitialData() {
  return {
            parameters: []
        };
}
new Vue({
            el: '#app',
            data() {
                return getInitialData();
            },
            created() {
                this.getParameters();
            },
            methods: {
                getParameters() {
                    const self = this;
                    axios.get(`/api/parameters`)
                        .then(function(response) {
                            self.parameters = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                saveParameters() {
                    const self = this;

                    const payload = {
                        bill_counter_default: this.parameters.bill_counter_default,
                        campaign_price_default: this.parameters.campaign_price_default,
                        campaign_counter_default: this.parameters.campaign_counter_default,
                        bill_hour_start: this.parameters.bill_hour_start,
                        bill_hour_end: this.parameters.bill_hour_end,
                        campaign_hour_start: this.parameters.campaign_hour_start,
                        campaign_hour_end: this.parameters.campaign_hour_end,
                    };
                    
                    axios.post(`/api/parameters`, payload)
                        .then(function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Parámetros",
                                text: "Parámetros actualizados correctamente",
                                allowOutsideClick: false
                            });
                            self.parameters = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                }
            }
        });