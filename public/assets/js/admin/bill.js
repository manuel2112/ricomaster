new Vue({
            el: '#app',
            data() {
                return {
                    nextBill: null,
                    weeksBill: [],
                    week: {
                        monday: null,
                        thursday: null,
                        wednesday: null,
                        tuesday: null,
                        friday: null,
                    },
                    listTypes: [],
                    listBillSelect: [],
                    programmed: true,
                    isProgrammed: true,
                    existWeekProgrammed: null,
                };
            },
            created() {
                this.instantiate();
            },
            methods: {
                instantiate() {
                    const self = this;
                    axios.get('/api/bill/next')
                        .then(function(response) {
                            const today = dayjs(response.data.data.week.monday);
                            self.nextBill = response.data.data.week;
                            self.nextBill.date = today.format('DD/MM/YYYY');
                            self.existWeekProgrammed = response.data.data.existWeek;
                            self.getList();
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                getList() {
                    const self = this;
                    axios.get('/api/bill/list')
                        .then(function(response) {
                            self.weeksBill = response.data.data;
                            self.existWeek();
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                existWeek(){
                    const exist = this.weeksBill.some(week => week.week == this.nextBill.week_number);
                    this.isProgrammed = exist;
                },
                formatDate(date) {
                    return dayjs(date).format('DD/MM/YYYY');
                },
                endDateWeek(date) {
                    const nextWeek = dayjs(date).add(4, 'day');
                    return nextWeek.format('DD/MM/YYYY');
                },
                showBill(item) {
                    if (item.programmed) {
                        window.location.href = `/admin/minuta/crear`;
                        return;
                    }
                    const self = this;
                    axios.get(`/api/bill/get/${item.id}`)
                        .then(function(response) {
                            self.listTypes = response.data.data.types;
                            self.week.monday = response.data.data.week.monday;
                            self.week.thursday = response.data.data.week.thursday;
                            self.week.wednesday = response.data.data.week.wednesday;
                            self.week.tuesday = response.data.data.week.tuesday;
                            self.week.friday = response.data.data.week.friday;
                            self.week.weekId = response.data.data.week.week_id;
                            self.listBillSelect = response.data.data.select;
                            $('#showBillModal').modal('show');
                        })
                        .catch(function(error) {
                            console.error(error);
                        })
                        .finally(function() {});
                },
                formatedDate(value) {
                    const date = dayjs(value);
                    return date.format('DD/MM/YYYY');
                },
                getBillByDay(item, week) {
                    for (let i = 0; i < this.listBillSelect.length; i++) {
                        const bill = this.listBillSelect[i];
                        if (bill.type_menu_id == item && bill.day == week) {
                            return bill.menu.name;
                        }
                    }
                    return '';
                },
                fnClassBackground(item) {
                    if (item.actual)
                        return 'bg-success';
                    else if (item.programmed) {
                        this.programmed = false;
                        return 'bg-warning';
                    } else
                        return '';
                },
            }
        });