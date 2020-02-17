<template>
    <div id="mobile-navigation__wrapper" :class="{ active: toggled }">
        <div id="sidemenu">
            <!-- Logo -->
            <div id="sidemenu-logo__wrapper">
                <div id="sidemenu-logo">
                    N<sup>2</sup>W
                </div>
            </div>
            <!-- Links -->
            <div id="sidemenu-links">
                <slot></slot>
            </div>
        </div>
        <div id="sidemenu-overlay" @click="onClickBg"></div>
    </div>
</template>

<script>
    import { EventBus } from './../../event-bus.js';
    export default {
        props: [],
        data: () => ({
            tag: "[mobile-navigation]",
            toggled: false,
            group: false,
        }),
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                this.startListening();
            },
            startListening() {
                EventBus.$on("hamburger-menu-toggled", function(state) {
                    console.log(this.tag+" received 'hamburger-menu-toggled' event, state: ", state);
                    this.toggled = state;
                }.bind(this));
            },
            onClickBg() {
                console.log(this.tag+" clicked bg");
                this.toggled = false;
                EventBus.$emit("sidemenu-closed");
            }
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    #mobile-navigation__wrapper {
        &.active {
            #sidemenu {
                left: 0;
            }
            #sidemenu-overlay {
                display: block;
                opacity: 1;
            }
        }
        #sidemenu {
            top: 0;
            left: -250px;
            width: 250px;
            height: 100vh;
            z-index: 9999;
            position: absolute;
            transition: all .3s;
            background-color: #ffffff;
            #sidemenu-logo__wrapper {
                padding: 25px;
                box-sizing: border-box;
                #sidemenu-logo {
                    height: 40px;
                    color: #ffffff;
                    font-weight: 600;
                    padding: 10px 15px;
                    border-radius: 3px;
                    flex-direction: row;
                    align-items: center;
                    transition: all .3s;
                    display: inline-block;
                    text-decoration: none;
                    box-sizing: border-box;
                    background-color: hsl(0, 0%, 0%);
                    &:hover {
                        background-color: hsl(0, 0%, 25%);
                    }
                }
            }
            #sidemenu-links {
                box-sizing: border-box;
                padding: 0 25px 25px 25px;
                .sidemenu-link {
                    color: #000;
                    display: flex;
                    padding: 10px 0;
                    flex-direction: row;
                    text-decoration: none;
                    box-sizing: border-box;
                    .sidemenu-link__icon {

                    }
                    .sidemenu-link__text {

                    }
                }
            }
        }
        #sidemenu-overlay {
            top: 0;
            left: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            z-index: 8888;
            display: none;
            position: absolute;
            transition: all .3s;
            background-color: rgba(0, 0, 0, 0.55);
        }
    }
</style>