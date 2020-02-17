<template>
    <div class="user-pill" :class="{ 'elevation-1': withShadow, 'dark': dark }">
        <div class="user-pill__avatar-wrapper">
            <div class="user-pill__avatar" :style="{ backgroundImage: 'url('+user.avatar_url+')' }"></div>
        </div>
        <div class="user-pill__text-wrapper">
            <div class="user-name">{{ user.formatted_name }}</div>
            <div class="user-tags">
                <div class="tag" v-if="hasMinistry">
                    {{ ministry }}
                </div>
                <div class="tag text" v-if="hasJobTitle">
                    {{ jobTitle }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                default: null,
            },
            withShadow: {
                type: Boolean,
                default: false,
            },
            dark: {
                type: Boolean,
                default: false,
            }
        },
        data: () => ({
            tag: "[user-pill]",
        }),
        computed: {
            hasJobTitle() {
                return this.user !== null && 
                       this.user.current_assignment !== undefined && this.user.current_assignment !== null &&
                       this.user.current_assignment.job_title !== undefined;
            },
            hasMinistry() {
                return this.user !== null && 
                       this.user.current_assignment !== undefined && this.user.current_assignment !== null &&
                       this.user.current_assignment.ministry !== undefined;
            },
            jobTitle() {
                if (this.hasJobTitle) {
                    return this.user.current_assignment.job_title.name;
                }
                return "";
            },
            ministry() {
                if (this.hasMinistry) {
                    return this.user.current_assignment.ministry.abbreviation;
                }
                return "";
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" user: ", this.user);
                // console.log(this.tag+" "); 
            },

        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    .user-pill {
        display: flex;
        padding: 20px;
        border-radius: 3px;
        flex-direction: row;
        box-sizing: border-box;
        background-color: hsl(0, 0%, 100%);
        &.dark {
            background-color: hsl(0, 0%, 95%);
        }
        .user-pill__avatar-wrapper {
            flex: 0 0 50px;
            .user-pill__avatar {
                width: 50px;
                height: 50px;
                border-radius: 25px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center center;
            }
        }
        .user-pill__text-wrapper {
            flex: 1;
            display: flex;
            padding: 0 0 0 20px;
            box-sizing: border-box;
            flex-direction: column;
            justify-content: center;
            .user-name {
                margin: 0 0 5px 0;
            }
            .user-tags {
                display: flex;
                flex-wrap: wrap;
                flex-direction: row;
                .tag {
                    font-size: .7em;
                    color: #000;
                    padding: 2px 5px 3px 5px;
                    border-radius: 3px;
                    margin: 0 5px 5px 0;
                    line-height: 1em;
                    box-sizing: border-box;
                    background-color: hsl(0, 0%, 85%);
                }
            }
        }
    }
</style>