<template>
    <div id="register-form" class="elevation-1">

        <!-- First & last name -->
        <div class="form-fields">
            <div class="form-field">
                <v-select
                    :label="annotationText"
                    v-model="form.annotation"
                    :items="annotationOptions"
                    :error="hasErrors('annotation')"
                    :error-messages="getErrors('annotation')">
                </v-select>
                <input type="hidden" name="annotation" v-model="form.annotation">
            </div>
            <div class="form-field double">
                <v-text-field 
                    name="first_name" 
                    :label="firstNameText" 
                    v-model="form.first_name" 
                    :error="hasErrors('first_name')" 
                    :error-messages="getErrors('first_name')">
                </v-text-field>
            </div>
            <div class="form-field double">
                <v-text-field 
                    name="last_name" 
                    :label="lastNameText" 
                    v-model="form.last_name" 
                    :error="hasErrors('last_name')" 
                    :error-messages="getErrors('last_name')">
                </v-text-field>
            </div>
        </div>
        
        <!-- Email -->
        <div class="form-field">
            <v-text-field 
                name="email" 
                :label="emailText" 
                v-model="form.email"
                :error="hasErrors('email')"
                :error-messages="getErrors('email')">
            </v-text-field>
        </div>
        
        <!-- Password & confirm password -->
        <div class="form-fields">
            <div class="form-field">
                <v-text-field 
                    type="password" 
                    name="password"
                    :label="passwordText" 
                    v-model="form.password"
                    :error="hasErrors('password')"
                    :error-messages="getErrors('password')">
                </v-text-field>
            </div>
            <div class="form-field">
                <v-text-field 
                    type="password" 
                    name="password_confirmation" 
                    :label="confirmPasswordText" 
                    v-model="form.confirmPassword"
                    :error="hasErrors('password_confirmation')"
                    :error-messages="getErrors('password_confirmation')">
                </v-text-field>
            </div>
        </div>
        
        <!-- Controls -->
        <div id="register-form__controls">
            <div id="register-form__controls-left">

                <!-- Link to login -->
                <a :href="loginHref">
                    {{ loginText }}
                </a>

            </div>
            <div id="register-form__controls-right">

                <!-- Submit button -->
                <v-btn type="submit" color="primary" depressed>
                    {{ submitText }}
                </v-btn>

            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        props: [
            "errors",
            "oldInput",
            "annotationText",
            "firstNameText",
            "lastNameText",
            "emailText",
            "passwordText",
            "confirmPasswordText",
            "submitText",
            "loginText",
            "loginHref",
        ],
        data: () => ({
            tag: "[register-form]",
            annotationOptions: [],
            form: {
                annotation: "Mr.",
                firstName: "",
                lastName: "",
                email: "",
                password: "",
                confirmPassword: "",
            }
        }),
        methods: {
            initialize() {
                
                console.log(this.tag+" initialize");
                console.log(this.tag+" errors: ", this.errors);
                console.log(this.tag+" old input: ", this.oldInput);

                console.log(this.tag+" annotation text: ", this.annotationText);
                console.log(this.tag+" first name text: ", this.firstNameText);
                console.log(this.tag+" last name text: ", this.lastNameText);
                console.log(this.tag+" email text: ", this.emailText);
                console.log(this.tag+" password text: ", this.passwordText);
                console.log(this.tag+" confirm password text: ", this.confirmPasswordText);
                console.log(this.tag+" login text: ", this.loginText);
                console.log(this.tag+" login href: ", this.loginHref);

                this.initializeData();
                this.generateAnnotationOptions();

            },
            initializeData() {
                if (this.oldInput !== undefined && this.oldInput !== null) {
                    if (this.oldInput.annotation !== null) this.form.annotation = this.oldInput.annotation;
                    if (this.oldInput.first_name !== null) this.form.first_name = this.oldInput.first_name;
                    if (this.oldInput.last_name !== null) this.form.last_name = this.oldInput.last_name;
                    if (this.oldInput.email !== null) this.form.email = this.oldInput.email;
                }
            },
            generateAnnotationOptions() {
                this.annotationOptions.push({ text: "Mr.", value: "Mr." });
                this.annotationOptions.push({ text: "Mrs.", value: "Mrs." });
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
    #register-form {
        width: 600px;
        padding: 25px;
        margin: 0 auto;
        border-radius: 3px;
        box-sizing: border-box;
        background-color: hsl(0, 0%, 100%);
        #register-form__controls {
            display: flex;
            margin: 15px 0 0 0;
            flex-direction: row;
            #register-form__controls-left, #register-form__controls-right {
                flex: 1;
                display: flex;
                flex-direction: row;
                align-items: center;
            }
            #register-form__controls-left {
                #login-link {
                    text-decoration: none;
                    color: hsl(0, 0%, 0%);
                }   
            }
            #register-form__controls-right {
                justify-content: flex-end;
                .v-btn {
                    margin: 0 0 0 15px;
                }
            }
        }
    }
    // Responsive
    @media (max-width: 650px) {
        #register-form {
            width: 100%;
        }
    }
    @media (max-width: 470px) {
        #register-form {
            .form-fields {
                flex-direction: column;
            }
        }
    }
    @media (max-width: 620px) {
        #register-form {
            #register-form__controls {
                flex-wrap: wrap;
                flex-direction: column-reverse;
                #register-form__controls-left, #register-form__controls-right {
                    flex: 0 0 100%;
                }
                #register-form__controls-left {
                    margin: 15px 0 0 0;
                }
                #register-form__controls-right {
                    justify-content: flex-start;
                    .v-btn {
                        margin: 0;
                    }
                }
            }
        }
    }
</style>
