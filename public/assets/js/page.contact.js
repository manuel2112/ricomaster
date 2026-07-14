function getInitialData() {
  return {
            contact: {
                name: "",
                email: "",
                subject: "",
                message: ""
            },
        };
}
new Vue({
        el: '#app',
        data() {
            return getInitialData();
        },
        methods: {
            sendContact() {
                if( !this.contact.name || !this.contact.email || !this.contact.subject || !this.contact.message ){
                    Swal.fire({
                        icon: "error",
                        title: "Contacto",
                        text: "Todos los campos son obligatorios.",
                    });
                    return;
                }

                const self = this;
                this.loading = true;
                axios.post('/api/contact', {
                        name: this.contact.name,
                        email: this.contact.email,
                        subject: this.contact.subject,
                        message: this.contact.message
                    })
                    .then(function(response) {
                        if(response.data.message){
                            Swal.fire({
                                icon: "success",
                                title: "Contacto",
                                text: response.data.message,
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
            reset(){
                Object.assign(this.$data, getInitialData());
            },
        }
    });