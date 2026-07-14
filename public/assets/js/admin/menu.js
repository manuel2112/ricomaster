new Vue({
            el: '#app',
            data() {
                return {
                    menu: {
                        id: null,
                        cod: null,
                        name: null,
                        image: null,
                        types: [],
                        newImage: false
                    },
                    error: {
                        cod: false,
                        name: false,
                        type: false,
                    },
                    loading: false,
                    listMenu: [],
                    listTypeMenu: [],
                    selectedTypeMenu: [],
                    modal: {
                        title: 'Crear',
                        type: 1,
                        btn: 'Guardar',
                    },
                    imagePreview: '',
                };
            },
            created() {
                this.getMenu();
                this.getTypeMenu();
            },
            methods: {
                getMenu() {
                    const self = this;
                    this.loading = true;
                    axios.get('/api/menu/list')
                        .then(function(response) {
                            self.listMenu = response.data.data;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {
                            self.loading = false;
                        });
                },
                getTypeMenu() {
                    const self = this;
                    this.loading = true;
                    axios.get('/api/type-menu/get')
                        .then(function(response) {
                            self.listTypeMenu = response.data.data;
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
                        this.menu.id = item.id;
                        this.menu.cod = item.cod;
                        this.menu.name = item.name;
                        this.menu.types = item.types.length == 0 ? [] : item.types.map(element => element
                            .type_menu_id);
                        this.menu.image = item.image;
                        $('#createMenuModal').modal('show');
                    }
                },
                showTypeMenu(types, menu_id) {
                    const typeMenu = types.map(element => element
                        .type_menu_id);

                    return typeMenu.includes(menu_id);
                },
                storeUpdateMenu() {
                    if (this.modal.type == 1) {
                        this.storeMenu();
                    } else {
                        this.updateMenu();
                    }
                },
                storeMenu() {
                    if (this.validateForm()) return;

                    const self = this;
                    this.loading = true;
                    axios.post('/api/menu/store', {
                            menu: this.menu,
                            typeMenu: this.selectedTypeMenu
                        })
                        .then(function(response) {
                            self.listMenu = response.data.data;
                            self.reset();
                            $('#createMenuModal').modal('hide');
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {
                            self.loading = false;
                        });
                },
                updateMenu() {

                    if (this.validateForm()) return;

                    const self = this;
                    this.loading = true;
                    axios.put('/api/menu/update', this.menu)
                        .then(function(response) {
                            self.listMenu = response.data.data;
                            self.reset();
                            $('#createMenuModal').modal('hide');
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
                    this.error.cod = false;
                    this.error.name = false;
                    this.error.type = false;

                    if (!this.menu.cod) {
                        this.error.cod = true;
                        isValid = false;
                    }
                    if (!this.menu.name) {
                        this.error.name = true;
                        isValid = false;
                    }
                    if (!this.menu.id && this.selectedTypeMenu.length == 0) {
                        this.error.type = true;
                        isValid = false;
                    }
                    if (this.menu.id && this.menu.types.length == 0) {
                        this.error.type = true;
                        isValid = false;
                    }

                    return !isValid;
                },
                remove(id) {
                    Swal.fire({
                        title: 'Eliminar Menú',
                        text: '¿Estás seguro de eliminar este menú?',
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
                            axios.delete(`/api/menu/delete/${id}`).then(function(response) {
                                    // self.listMenu = response.data.data;
                                    self.getMenu();
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
                handleImageChange(event) {
                    const self = this;
                    this.menu.newImage = true;
                    const target = event.target;
                    const file = (target.files || [])[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            self.imagePreview = event.target.result;
                            self.menu.image = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        this.imagePreview = null;
                    }
                },
                pathImage(image) {
                    return `${asset}app/public/${image}`;
                },
                reset() {
                    this.menu.id = null;
                    this.menu.cod = null;
                    this.menu.name = null;
                    this.menu.image = null;
                    this.menu.types = [];
                    this.selectedTypeMenu = [];
                    this.menu.newImage = false;
                    this.loading = false;
                    this.modal.title = 'Crear';
                    this.modal.type = 1;
                    this.modal.btn = 'Guardar';
                    this.imagePreview = null;
                    this.error.cod = false;
                    this.error.name = false;
                    this.$refs.fileupload.value = null;
                }
            }
        });