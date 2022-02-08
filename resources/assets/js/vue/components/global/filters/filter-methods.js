export default {
    methods: {
        toggleFilter(item) {
            if(!_.includes(this.filters, item)) { // Add filter
                this.filters.push(item);
            } else {
                for(let i = 0; i < this.filters.length; i++) {
                    if(this.filters[i] === item) { // Remove filter
                        this.filters.splice(i, 1);
                    }
                }
            }
            this.$emit('input', this.filters);
        },
        setSingleFilter(item) {
            if(this.filters.includes(item)) {
                this.filters = [];
            } else {
                this.filters = [item];
            }
            this.$emit('input', this.filters);
        },
        isActive(item) {
            return _.includes(this.filters, item)
        },
    }
}