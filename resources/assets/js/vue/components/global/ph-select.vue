<template>
    <div class="select-wrapper">
        <select :name="name" v-model="selected" @change="input">
            <option disabled value="">{{ title }}</option>
            <option v-for="(v,k) in options"
                    :value="k"
                    :selected="k === value">
                {{ v }}
            </option>
        </select>
        <div class="select-controls">
            <span>|</span>
            <i class="fa fa-caret-down"></i>
        </div>
    </div>
</template>

<script>
    //import Component from '../';
    export default {
        props: {
            name: {
                type: String,
                default: '',
            },
            title: {
                type: String,
                default: 'Select',
            },
            value: {
                default: '',
            },
            options: {
                type: Object,
                required: true,
            },
        },
        data () {
            return {
                selected: this.value,
            }
        },
        methods: {
            input() {
                this.$emit('input', this.selected);
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .select-wrapper {
        position: relative;

        select {
            width: 100%;
            appearance: none;
            background: $color-2;
            border: none;
            padding: 3px 30px 4px 10px;
        }

        .select-controls {
            pointer-events: none;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: black;

            span {
                color: white;
            }
        }
    }
</style>