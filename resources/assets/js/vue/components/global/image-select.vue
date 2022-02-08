<template>
    <div class="upload-image" :style="'background-image: url('+ previewUrl +'); width: ' + displaySize + 'px; height: ' + displaySize + 'px;'">
        <input type="file" @change="previewImage" accept="image/*" v-validate="'size:5012'" name="image">
        <span class="upload-plus" v-if="!previewUrl">
            <i class="fa fa-plus-circle" data-fa-transform="grow-40"></i>
        </span>
        <div class="upload-image-inner" v-if="!previewUrl">
            Upload Image
            <div class="image-dimensions">
                Minimum size {{ minWidth }}px {{ minHeight }}px
            </div>
            <div>
                <span class="error-msg">{{ errors.first('image') }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                //type: File,
            },
            displaySize: {
                type: Number,
                default: 245,
            },
            minWidth: {
                type: Number,
                default: 300,
            },
            minHeight: {
                type: Number,
                default: 300,
            },
            currentSelected: {
                required: false
            }
        },
        data () {
            return {
                previewUrl: '',
            }
        },
        watch: {
          currentSelected: {
            immediate: true,
            handler: function(v) {
              if (v) {
                this.previewUrl = v;
              }
            },
          }
        },
        methods: {
            previewImage(event) {
              this.$validator.validate().then(result => {
                if (result) {
                  let files = event.target.files;
                  if (files && files[0]) {
                    this.$emit('input', files);
                    let image = files[0];
                    let reader = new FileReader();
                    reader.readAsDataURL(image);
                    reader.onload = () => {
                      this.previewUrl = reader.result;
                    };
                  }
                }
              })
            }
        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .upload-image {
        border: 1px solid $color-grey2;
        background: white;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;

        background-position: center center;
        background-size: cover;

        input {
            width: 100%;
            height: 100%;
            z-index: 99;
            padding: 0;
            opacity: 0;
            position: absolute;
            cursor: pointer;
        }
    }
    .upload-plus {
        color: $color-2;
    }
    .upload-image-inner {
        height: 30%;
        text-align: center;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .image-dimensions {
        margin-top: 1em;
        font-size: 10px;
        color: black;
    }
    .error-msg {
        color: red;
        font-size: 12px;
        text-align: center;
        margin-top: 11px;
    }
</style>