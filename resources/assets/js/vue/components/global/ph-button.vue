<template>
    <div style="position: relative;display:inline;">
        <component
            class="button"
            ref="component"
            :is="tag"
            :href="href ? href : null"
            :to="to ? to : null"
            :class="[color, size, other, type, { active: active }]"
            :disabled="loading || disabled"
        >
            <spinner style="margin: 0 auto;" v-if="loading"
                 :animation-duration="1000"
                 :size="15"
                 :color="variables.colors.colorBlue"
            />
            <slot v-else></slot>
        </component>
        <div class="tooltip" v-if="$slots['tooltip']">
            <slot name="tooltip"></slot>
        </div>
    </div>
</template>

<script>
    import { SpringSpinner } from 'epic-spinners';
    //import Component from '../';
    export default {
        props: {
            type: String,
            href: String,
            to: String,
            size: String,
            color: String,
            other: String,
            active: Boolean,
            loading: Boolean,
            disabled: Boolean,
        },
        data () {
            return {
                variables: window.variables,
                style: {
                    width: undefined,
                    height: undefined,
                }
            }
        },
        computed: {
            tag: function() {
                if(this.href) return 'a';
                if(this.to) return 'router-link';

                else return 'button';
            }
        },
        mounted: function() {
            let rect = this.$refs.component.getBoundingClientRect();
            this.style.width = rect.right - rect.left;
            this.style.height = rect.bottom - rect.top;
        },
        components: {
            'spinner': SpringSpinner,
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .button {
        cursor: pointer;
        display: inline-block;
        background: none;
        border-radius: 999px;
        outline: none;
        font-size: 10px;
        padding: 7px 12px;
        letter-spacing: 1px;
        border: 1px solid $color-primary;
        color: $color-primary;
        text-align: center;

        &:disabled:hover + .tooltip {
            display: block;
        }

        // Color Variations
        &.inverted {
            color: white;
            border-color: white;
        }
        &.white-border {
            background: transparent;
            border-color: white;
            color: white;
        }
        &.white {
            background: white;
            border-color: white;
            color: $color-blue2;
        }
        &.blue {
            background: $color-blue;
            border-color: $color-blue;
            color: white;
        }
        &.blue2 {
            color: black;
            border-color: $color-2;
        }
        &.mint {
            color: #FFF;
            border-color: $color-2;
        }

        // Size Variations
        &.medium {
            padding: 7px 20px;
            border-width: 2px;
            font-size: 120%;

            @media(max-width: 415px){
                padding: 4px 8px;
                border-width: 2px;
                font-size: 100%;
            }

        }
        &.large {
            padding: 12px 30px;
            border-width: 2px;
            font-size: 150%;

            @media(max-width: 414px){
                font-size: 100%;
            }
        }
        &.giant {
            padding: 15px 40px;
            border-width: 2px;
            font-size: 180%;
        }

        // Other Variations
        &.thick {
            border-width: 2px;
        }

        // Type Variations
        &.search-filter {
            width: 100%;
            height: 100%;
            font-size: 12px;
            padding-left: 0;
            padding-right: 0;

            &.active {
                background: $color-2;
            }
        }
        &:disabled {
            cursor: not-allowed;
            opacity: .8;
        }
    }
    a.button {
        text-decoration: none;
    }
    .tooltip {
        position: absolute;
        top: -120%;
        font-size: 10px;
        background: #fff;
        padding: 5px;
        border-radius: 5px;
        display: none;
        top: -65px;
        width: auto;
        min-width: 110px;
        border: 1px solid red;
        line-height: 12px;
    }
</style>
