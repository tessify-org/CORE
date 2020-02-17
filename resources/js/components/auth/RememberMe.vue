<template>
    <div id="remember-me-input">

        <!-- Form element -->
        <v-checkbox label="Remember me" v-model="rememberMe"></v-checkbox>

        <!-- Hidden input to pass the data since adding a name property to v-checkbox won't do that -->
        <input type="hidden" :name="inputName" :value="rememberMe" />

    </div>
</template>

<script>
    export default {
        props: [
            "name"
        ],
        data: () => ({
            tag: "[remember-me-input]",
            rememberMe: true
        }),
        computed: {
            inputName() {
                return this.name !== undefined && this.name !== null ? this.name : "remember_me";
            }
        },
        watch: {
            rememberMe() {
                this.$emit("input", this.rememberMe);
            }
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
            }
        },
        mounted() {
            this.initialize();
        }
    }
</script>