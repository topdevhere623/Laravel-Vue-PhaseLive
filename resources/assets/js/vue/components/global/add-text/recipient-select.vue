<template>
    <div class="recipient">
        <input type="text"
               placeholder="Recipient"
               :class="{ results: showList }"
               v-model="searchTerm"
               @input="input"
               @keyup.down="onArrowDown"
               @keyup.up="onArrowUp"
               @keyup.enter="onEnter"
               v-if="!selectedUser"
        />
        <ul class="predictions" v-show="showList">
            <li
                v-for="(result, index) in searchResults"
                :key="index"
                :class="{ 'highlighted' : index === arrowCounter }"
                @click="selectRecipient(result)"
                @mouseover="arrowCounter = index"
            >
                <avatar :size="25" :src="result.avatar.files.thumb.url" :center="false" /> {{ result.name }}
            </li>

        </ul>
        <div class="selected-user" v-if="selectedUser" @click="clearReceiver">
            <avatar :size="25" :src="selectedUser.avatar.files.thumb.url" :center="false" /> {{ selectedUser.name }}
            <div class="remove-button">
                <i class="fa fa-times"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import Avatar from 'global/avatar';
    export default {
        data () {
            return {
                searchTerm: '',
                searchResults: [],
                selectedUser: null,
                showList: false,
                arrowCounter: -1,
            }
        },
        methods: {
            input() {
                if(this.searchTerm.length > 0) {
                    this.showList = true;
                    this.fetchResults();
                } else {
                    this.showList = false;
                }
            },
            fetchResults: _.debounce(function () {
                axios.get('/api/user/search?name=' + this.searchTerm).then((response) => {
                    this.searchResults = response.data;
                })
            }, 300),
            selectRecipient(recipient) {
                this.selectedUser = recipient;
                this.showList = false;
                this.searchTerm = '';
                this.$emit('selected', this.selectedUser);
            },
            onArrowDown() {
                if (this.arrowCounter + 1 < this.searchResults.length) {
                    this.arrowCounter += 1;
                }
            },
            onArrowUp() {
                if (this.arrowCounter > 0) {
                    this.arrowCounter -= 1;
                }
            },
            onEnter() {
                if(this.arrowCounter >= 0) {
                    this.selectRecipient(this.arrowCounter);
                }
            },
            clearReceiver(){
                this.selectedUser = null;
                this.$emit('unselected', this.selectedUser);
            }
        },
        components: {
            Avatar,
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .avatar {
        margin-right: 5px;
    }
    .recipient {
        position: relative;

        input {
            padding: 5px 10px;
            border: 1px solid white;
            border-bottom: 0;
            border-radius: 9%/50%;
            position: relative;
            z-index: 999;
            box-sizing: border-box;

            &.results {
                border: 1px solid $color-grey2;
                border-bottom: 0;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
            &:focus {
                outline: none;
            }
        }
    }
    ul.predictions {
        min-width: 100%;
        position: absolute;
        background: white;
        border: 1px solid $color-grey2;
        margin-top: -1px;
    }
    li {
        padding: 10px;
        display: flex;
        align-items: center;
        white-space: nowrap;
        cursor: pointer;

        &.highlighted {
            background: darken(white, 5);
        }
    }
    .selected-user {
        display: flex;
        align-items: center;
        padding: 5px 10px 5px 5px;
        cursor: pointer;

        &:hover {
            background: darken(white, 5);
            border-radius: 50px;
        }
    }
    .remove-button {
        margin-left: 10px;
    }
</style>
