
                function formatPrice(price) {
                    return new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(price);
                }
                
                function formatDate(value) {
                    const date = dayjs(value);
                    return date.format('DD/MM/YYYY');
                }