new Vue({
            el: '#app',
            data() {
                return {
                    id: null,
                    menu: {
                        id: null,
                        counter: null,
                    },
                    week: {
                        monday: null,
                        thursday: null,
                        wednesday: null,
                        tuesday: null,
                        friday: null,
                    },
                    day: {
                        original: null,
                        formatted: null,
                    },
                    typeMenu: {},
                    weekId: null,
                    listTypes: [],
                    listMenus: [],
                    listMenusByType: [],
                    listBillSelect: [],
                    selectedMenu: "",
                    loading: false,
                    menuId: 1,
                    isProgrammed: false,
                    counter: 250
                };
            },
            created() {
                this.getId();
            },
            methods: {
                getId() {
                    const urlString = window.location.href;
                    const url = new URL(urlString);
                    const pathname = url.pathname;
                    const segments = pathname.split('/').filter(segment => segment.length > 0);
                    const countryCode = segments[0];
                    const lastSegment = segments[segments.length - 1];
                    this.id = lastSegment;
                    this.instantiate();
                },
                instantiate() {
                    const self = this;
                    axios.get(`/api/bill/edit/${this.id}`)
                        .then(function(response) {
                            self.isProgrammed = response.data.data.week.week_programmed;
                            self.listTypes = response.data.data.types;
                            self.listMenus = response.data.data.menu;
                            self.week.monday = response.data.data.week.monday;
                            self.week.thursday = response.data.data.week.thursday;
                            self.week.wednesday = response.data.data.week.wednesday;
                            self.week.tuesday = response.data.data.week.tuesday;
                            self.week.friday = response.data.data.week.friday;
                            self.week.weekId = response.data.data.week.week_id;
                            self.listBillSelect = response.data.data.select;
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                getBillByDay(item, week) {
                    for (let i = 0; i < this.listBillSelect.length; i++) {
                        const bill = this.listBillSelect[i];
                        if (bill.type_menu_id == item && bill.day == week) {
                            return `${bill.counter} <br /> ${bill.menu.name}`;
                        }
                    }
                    return '';
                },
                getBillByMenu(item, week) {
                    for (let i = 0; i < this.listBillSelect.length; i++) {
                        const bill = this.listBillSelect[i];
                        if (bill.type_menu_id == item && bill.day == week) {
                            return bill;
                        }
                    }
                    return '';
                },
                async storeUpdateBill(day) {

                    if (!this.counter ||this.counter < 0) {
                        Swal.fire(
                            'Error',
                            'Debe ingresar una cantidad mayor igual a cero',
                            'error'
                        );
                        return;
                    }

                    const payload = {
                        week_id: this.week.weekId,
                        type_menu_id: this.typeMenu.id,
                        day: this.day.original,
                        menu_id: this.menu.id,
                        counter: this.menu.counter,
                    };

                    const self = this;
                    this.loading = true;
                    await axios.post('/api/bill', payload)
                        .then(function(response) {
                            self.listBillSelect = response.data.data;
                            self.reset();
                            $('#createBillModal').modal('hide');
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {
                            self.loading = false;
                        });
                },
                openModal(type, menu, idx) {
                    this.typeMenu.id = type.id;
                    this.typeMenu.name = type.name;
                    this.listMenusByType = this.listMenus.filter(menu => {
                        return menu.types.some(t => t.type_menu_id == type.id);
                    }).sort((a, b) => a.name.localeCompare(b.name));
                    this.day.original = this.selectedDay(idx);
                    this.day.formatted = this.formatedDate(this.day.original);
                    this.menu = {
                        id: menu.menu_id,
                        counter: menu.counter,
                    };
                    $('#createBillModal').modal('show');
                },
                formatedDate(value) {
                    const date = dayjs(value);
                    return date.format('DD/MM/YYYY');
                },
                selectedDay(value) {
                    let day = null;
                    switch (value) {
                        case 0:
                            day = this.week.monday;
                            break;
                        case 1:
                            day = this.week.tuesday;
                            break;
                        case 2:
                            day = this.week.wednesday;
                            break;
                        case 3:
                            day = this.week.thursday;
                            break;
                        case 4:
                            day = this.week.friday;
                            break;
                    }

                    return day;
                },
                reset() {
                    this.menu = {
                        cod: '',
                        name: '',
                        image: '',
                        newImage: null,
                    };
                    this.error = {
                        cod: false,
                        name: false,
                    };
                    this.loading = false;
                    this.menuId = 1;
                    this.counter = 250;
                }
            }
        });