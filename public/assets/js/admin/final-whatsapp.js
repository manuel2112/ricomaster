function getInitialData() {
  return {
            finals: [],
            groupedFinals: [],
            optMenu: 'SI',
            message: null
        };
}
new Vue({
            el: '#app',
            data() {
                return getInitialData();
            },
            created() {
                this.getFinals();
            },
            methods: {
                getFinals() {
                    Swal.showLoading();
                    const self = this;
                    axios.get(`/api/final/list`, parameters = {
                        params: {
                            optMenu: self.optMenu
                        }
                    })
                        .then(function(response) {
                            self.finals = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {
                            Swal.close();
                        });
                },
                changeOpt(opt){
                    this.optMenu = opt;
                    this.getFinals();
                },
                openModal(){
                    if(this.groupedFinals.length == 0){                        
                        Swal.fire({
                            icon: "warning",
                            title: "Whatsapp",
                            text: "Debe seleccionar al menos un cliente",
                            allowOutsideClick: false
                        });
                        return;
                    }
                    $('#createMessageModal').modal('show');
                },
                async sendMessage(){
                    const self = this;
                    if(!this.message){
                        Swal.fire({
                            icon: "warning",
                            title: "Whatsapp",
                            text: "Debe ingresar un mensaje",
                            allowOutsideClick: false
                        });
                        return;
                    }

                    const payload = {
                        clients: this.groupedFinals,
                        message: this.message
                    };
                    
                    this.loading = true;
                    await axios.post('/api/whatsapp/final', payload)
                        .then(function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Whatsapp",
                                text: "Mensaje enviado correctamente",
                                showCancelButton: true,
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                allowOutsideClick: false
                            }).then((result) => {                        
                                if (result.isConfirmed){
                                    self.reset();
                                    $('#createMessageModal').modal('hide');
                                }
                            });
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                stateWhatsapp(final) {
                    const self = this;
                    Swal.fire({
                        title: "¿Desea cambiar el estado?",
                        showCancelButton: true,
                        confirmButtonText: "SI",
                        cancelButtonText: "NO",
                    }).then((result) => {                        
                        if (result.isConfirmed){
                            axios.put(`/api/final`, final)
                            .then(function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Whatsapp",
                                    text: "Estado editado correctamente",
                                    allowOutsideClick: false
                                });                                
                                self.finals = response.data.data;
                            })
                            .catch(function(error) {
                                console.error(error);
                            })
                            .finally(function() {});
                        }
                    });
                },
                reset(){
                    location.reload();    
                }
            }
        });