<template>
    <div id="reset-password-form__wrapper">
        <div id="reset-password-form" class="elevation-1">
            <!-- Email -->
            <div class="form-field">
                <v-text-field
                    disabled
                    name="email"
                    hide-details
                    v-model="form.email"
                    :label="emailLabelText"
                    :errors="hasErrors('email')"
                    :error-messages="getErrors('email')">
                </v-text-field>
            </div>
            <!-- Recovery code -->
            <div class="form-field">
                <v-text-field
                    disabled
                    name="code"
                    v-model="form.code"
                    :label="codeLabelText"
                    :errors="hasErrors('code')"
                    :error-messages="getErrors('code')">
                </v-text-field>
            </div>
            <!-- New password -->
            <div class="form-field">
                <v-text-field
                    type="password"
                    name="password"
                    :label="passwordLabelText"
                    v-model="form.password"
                    :errors="hasErrors('password')"
                    :error-messages="getErrors('password')">
                </v-text-field>
            </div>
            <!-- New password confirmation -->
            <div class="form-field mb-0">
                <v-text-field
                    type="password"
                    name="password_confirmation"
                    v-model="form.passwordConfirmation"
                    :label="passwordConfirmationLabelText"
                    :errors="hasErrors('password_confirmation')"
                    :error-messages="getErrors('password_confirmation')">
                </v-text-field>
            </div>
        </div>
        <div class="form-controls">
            <div class="form-controls__left">
                <v-btn outlined :href="backHref">
                    <i class="fas fa-arrow-left"></i>
                    {{ backButtonText }}
                </v-btn>
            </div>
            <div class="form-controls__right">
                <v-btn depressed color="success" type="submit" :disabled="submitButtonDisabled">
                    <i class="fas fa-save"></i>
                    {{ submitButtonText }}
                </v-btn>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            "code",
            "email",
            "errors",
            "emailLabelText",
            "codeLabelText",
            "passwordLabelText",
            "passwordConfirmationLabelText",
            "backHref",
            "backButtonText",
            "submitButtonText",

        ],
        data: () => ({
            tag: "[reset-password-form]",
            form: {
                code: "",
                email: "",
                password: "",
                passwordConfirmation: "",
            }
        }),
        computed: {
            submitButtonDisabled() {
                return this.form.password === "" || this.form.passwordConfirmation === "";
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" code: ", this.code);
                console.log(this.tag+" email: ", this.email);
                console.log(this.tag+" errors: ", this.errors);
                console.log(this.tag+" email label text: ", this.emailLabelText);
                console.log(this.tag+" code label text: ", this.codeLabelText);
                console.log(this.tag+" password label text: ", this.passwordLabelText);
                console.log(this.tag+" password confirmation label text: ", this.passwordConfirmationLabelText);
                console.log(this.tag+" back href: ", this.backHref);
                console.log(this.tag+" back button text: ", this.backButtonText);
                console.log(this.tag+" submit button text: ", this.submitButtonText);
                this.initializeData();
            },
            initializeData() {
                if (this.code !== undefined && this.code !== null && this.code !== "") this.form.code = this.code;
                if (this.email !== undefined && this.email !== null && this.email !== "") this.form.email = this.email;
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
    #reset-password-form__wrapper {
        width: 600px;
        margin: 0 auto;
        #reset-password-form {
            padding: 25px;
            margin: 0 0 30px 0;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: #fff;
        }
    }
    @media (max-width: 600px) {
        #reset-password-form__wrapper {
            width: 100%;
        }
    }
    @media (max-width: 460px) {
        #reset-password-form__wrapper {
            .form-controls {
                flex-direction: column-reverse;
                .form-controls__left, .form-controls__right {
                    .v-btn {
                        width: 100%;
                    }
                }
                .form-controls__right {
                    margin: 0 0 15px 0;
                }
            }
        }
    }
</style>