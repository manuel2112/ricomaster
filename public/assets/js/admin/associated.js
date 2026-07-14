new Vue({
            el: '#app',
            data() {
                return {
                    associated: {
                        id: null,
                        cod: null,
                        rut: null,
                        name: null,
                        social_name: null,
                        address: null,
                        commune: null,
                        map: null,
                        whatsapp: null,
                        menu_normal_associated: null,
                        menu_special_associated: null,
                        menu_normal_final: null,
                        menu_special_final: null,
                    },
                    error: {
                        cod: false,
                        rut: false,
                        name: false,
                        social_name: false,
                        address: false,
                        commune: false,
                        map: false,
                        whatsapp: false,
                        menu_normal_associated: false,
                        menu_special_associated: false,
                        menu_normal_final: false,
                        menu_special_final: false,
                    },
                    listAssociated: [],
                    loading: false,
                    modal: {
                        title: 'Crear',
                        type: 1,
                        btn: 'Guardar',
                    },
                };
            },
            created() {
                this.getAssociated();
            },
            watch: {
                'associated.rut'(newVal) {
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

                    this.associated.rut = `${cuerpoFormatoMiles}-${dv}`;
                }
            },
            methods: {
                getAssociated() {
                    const self = this;
                    this.loading = true;
                    axios.get('/api/associated/list/0')
                        .then(function(response) {
                            self.listAssociated = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {
                            self.loading = false;
                        });
                },
                openModal(type, item) {
                    if (type == 2) {
                        this.modal.title = 'Editar';
                        this.modal.btn = 'Editar';
                        this.modal.type = 2;
                        this.associated.id = item.id;
                        this.associated.cod = item.cod;
                        this.associated.rut = item.rut;
                        this.associated.name = item.name;
                        this.associated.social_name = item.social_name;
                        this.associated.address = item.address;
                        this.associated.commune = item.commune;
                        this.associated.map = item.map;
                        this.associated.whatsapp = item.whatsapp;
                        this.associated.menu_normal_associated = item.menu_normal_associated;
                        this.associated.menu_special_associated = item.menu_special_associated;
                        this.associated.menu_normal_final = item.menu_normal_final;
                        this.associated.menu_special_final = item.menu_special_final;
                        $('#createAssociatedModal').modal('show');
                    }
                },
                storeUpdateAssociated() {
                    if (this.modal.type == 1) {
                        this.storeAssociated();
                    } else {
                        this.updateAssociated();
                    }
                },
                storeAssociated() {
                    if (this.validateForm()) return;

                    const self = this;
                    this.loading = true;
                    axios.post('/api/associated/store', {
                            associated: this.associated,
                        })
                        .then(function(response) {
                            self.listAssociated = response.data.data;
                            self.reset();
                            $('#createAssociatedModal').modal('hide');
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {
                            self.loading = false;
                        });
                },
                updateAssociated() {

                    if (this.validateForm()) return;

                    const self = this;
                    this.loading = true;
                    axios.put('/api/associated/update', this.associated)
                        .then(function(response) {
                            self.listAssociated = response.data.data;
                            self.reset();
                            $('#createAssociatedModal').modal('hide');
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {
                            self.loading = false;
                        });
                },
                validateForm() {
                    let isValid = true;
                    this.resetError();

                    if (!this.associated.cod) {
                        this.error.cod = true;
                        isValid = false;
                    }
                    if (!this.associated.rut) {
                        this.error.rut = true;
                        isValid = false;
                    }
                    if (!this.associated.name) {
                        this.error.name = true;
                        isValid = false;
                    }
                    if (!this.associated.social_name) {
                        this.error.social_name = true;
                        isValid = false;
                    }
                    if (!this.associated.address) {
                        this.error.address = true;
                        isValid = false;
                    }
                    if (!this.associated.commune) {
                        this.error.commune = true;
                        isValid = false;
                    }
                    if (!this.associated.map) {
                        this.error.map = true;
                        isValid = false;
                    }
                    if (!this.associated.whatsapp) {
                        this.error.whatsapp = true;
                        isValid = false;
                    }
                    if (!this.associated.menu_normal_associated) {
                        this.error.menu_normal_associated = true;
                        isValid = false;
                    }
                    if (!this.associated.menu_special_associated) {
                        this.error.menu_special_associated = true;
                        isValid = false;
                    }
                    if (!this.associated.menu_normal_final) {
                        this.error.menu_normal_final = true;
                        isValid = false;
                    }
                    if (!this.associated.menu_special_final) {
                        this.error.menu_special_final = true;
                        isValid = false;
                    }

                    return !isValid;
                },
                remove(id) {
                    Swal.fire({
                        title: 'Eliminar Asociado',
                        text: '¿Estás seguro de eliminar a este asociado?',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        confirmButtonColor: '#d33',
                        cancelButtonText: 'No',
                        cancelButtonColor: '#6c757d',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })

                            const self = this;
                            axios.delete(`/api/associated/delete/${id}`).then(function(response) {
                                    self.listAssociated = response.data.data;
                                })
                                .catch(function(error) {
                                    console.error(error);
                                })
                                .finally(function() {
                                    Swal.close();
                                });
                        }
                    });
                },
                limitLength() {
                    const maxLength = 9;
                    if (this.associated.whatsapp > maxLength) {
                        this.associated.whatsapp = this.associated.whatsapp.slice(0, maxLength);
                    }
                },
                resetError() {
                    this.error.cod = false;
                    this.error.rut = false;
                    this.error.name = false;
                    this.error.social_name = false;
                    this.error.address = false;
                    this.error.commune = false;
                    this.error.map = false;
                    this.error.whatsapp = false;
                    this.error.menu_normal_associated = false;
                    this.error.menu_special_associated = false;
                    this.error.menu_normal_final = false;
                    this.error.menu_special_final = false;
                },
                reset() {
                    this.associated.cod = null;
                    this.associated.rut = null;
                    this.associated.name = null;
                    this.associated.social_name = null;
                    this.associated.address = null;
                    this.associated.commune = null;
                    this.associated.map = null;
                    this.associated.whatsapp = null;
                    this.associated.menu_normal_associated = null;
                    this.associated.menu_special_associated = null;
                    this.associated.menu_normal_final = null;
                    this.associated.menu_special_final = null;

                    this.loading = false;
                    this.modal.title = 'Crear';
                    this.modal.type = 1;
                    this.modal.btn = 'Guardar';
                }
            }
        });