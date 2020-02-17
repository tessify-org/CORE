<template>
    <div id="hamburger-button__wrapper" :class="{ fixed: toggled }">
        <button class="hamburger hamburger--spin" style="outline:none;" type="button" :class="{ 'is-active': toggled }" @click="onClickHamburger">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
    </div>
</template>

<script>
    import { EventBus } from './../../event-bus.js';
    export default {
        props: [],
        data: () => ({
            tag: "[hamburger-button]",
            toggled: false,
        }),
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                this.startListening();
            },
            startListening() {
                EventBus.$on("sidemenu-closed", function() {
                    console.log(this.tag+" received 'sidemenu-closed' event");
                    this.toggled = false;
                }.bind(this));
            },
            onClickHamburger() {
                console.log(this.tag+" toggling hamburger menu")
                this.toggled = ! this.toggled;
                EventBus.$emit("hamburger-menu-toggled", this.toggled);
            },
            // onToggle(active) {
            //     console.log(this.tag+" hamburger menu toggled", active);
            //     EventBus.$emit("hamburger-menu-toggled", active);
            // },
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    #hamburger-button__wrapper {
        display: flex;
        z-index: 999999;
        position: relative;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        padding-top: 5px;
        &.fixed {
            // top: 15px;
            // right: 15px;
            position: relative;
        }
    }
</style>