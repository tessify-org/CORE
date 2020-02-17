<template>
    <div id="forgot-password-form__wrapper">

        <div id="forgot-password-form" class="elevation-1">
            <div class="form-field">
                <v-text-field
                    name="email"
                    :label="emailText"
                    v-model="form.email"
                    :errors="hasErrors('email')"
                    :error-messages="getErrors('email')">
                </v-text-field>
            </div>
        </div>

        <div class="form-controls">
            <div class="form-controls__left">
                <v-btn :href="backHref">
                    <i class="fas fa-arrow-left"></i>
                    {{ backText }}
                </v-btn>
            </div>
            <div class="form-controls__right">
                <v-btn type="submit" color="primary" class="icon-right">
                    {{ submitText }}
                    <i class="fas fa-paper-plane"></i>
                </v-btn>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            "errors",
            "backHref",
            "backText",
            "submitText",
            "emailText",
        ],
        data: () => ({
            tag: "[forgot-password-form]",
            form: {
                email: ""
            }
        }),
        methods: {
            initialize() {
                console.log(this.tag+" errors: ", this.errors);
                console.log(this.tag+" back href: ", this.backHref);
                console.log(this.tag+" back text: ", this.backText);
                console.log(this.tag+" submit text: ", this.submitText);
                console.log(this.tag+" email text: ", this.emailText);
            },
            hasErrors(field) {
                if (this.errors !== undefined && this.errors !== null && this.errors.length > 0) {
                    if (this.errors[field] !==  undefined &&  this.errors[field] !== "") {
                        return true;
                    }
                }
                return false;
            },
            getErrors(field) {
                if (this.errors !== undefined && this.errors !== null && this.errors[field] !== undefined && this.errors[field] !== null) {
                    return this.errors[field];
                }
                return [];
            },
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    #forgot-password-form__wrapper {
        #forgot-password-form {
            width: 650px;
            padding: 25px;
            border-radius: 3px;
            box-sizing: border-box;
            margin: 0 auto 30px auto;
            background-color: #ffffff;
        }
        .form-controls {
            width: 650px;
            margin: 0 auto;
        }
    }
    @media (max-width: 650px) {
        #forgot-password-form__wrapper {
            #forgot-password-form {
                width: 100%;
            }
            .form-controls {
                width: 100%;
            }
        }
    }
    @media (max-width: 455px) {
        #forgot-password-form__wrapper {
            .form-controls {
                flex-direction: column-reverse;
                .form-controls__left {
                    .v-btn {
                        width: 100%;
                    }
                }
                .form-controls__right {
                    margin: 0 0 15px 0;
                    .v-btn {
                        width: 100%;
                    }
                }
            }
        }
    }
</style>