<template>
    <div id="update-profile-form__wrapper">

        <!-- Form -->
        <div id="update-profile-form" class="elevation-1">

            <!-- Annotation, first- & last name -->
            <div class="form-fields">
                <div class="form-field">
                    <v-select
                        :label="annotationText"
                        v-model="form.annotation"
                        :items="annotationOptions"
                        :error="hasErrors('annotation')"
                        :error-messages="getErrors('annotation')">
                    </v-select>
                    <input type="hidden" name="annotation" :value="form.annotation">
                </div>
                <div class="form-field double">
                    <v-text-field 
                        :label="firstNameText"
                        v-model="form.first_name" 
                        name="first_name"
                        :error="hasErrors('first_name')"
                        :error-messages="getErrors('first_name')">
                    </v-text-field>
                </div>
                <div class="form-field double">
                    <v-text-field 
                        :label="lastNameText"
                        v-model="form.last_name" 
                        name="last_name"
                        :error="hasErrors('last_name')"
                        :error-messages="getErrors('last_name')">
                    </v-text-field>
                </div>
            </div>

            <!-- Email address -->
            <div class="form-field">
                <v-text-field 
                    :label="emailText"
                    v-model="form.email" 
                    name="email"
                    :error="hasErrors('email')"
                    :error-messages="getErrors('email')">
                </v-text-field>
            </div>

            <!-- Phone number -->
            <div class="form-field">
                <v-text-field 
                    :label="phoneText"
                    v-model="form.phone" 
                    name="phone"
                    :error="hasErrors('phone')"
                    :error-messages="getErrors('phone')">
                </v-text-field>
            </div>

            <!-- Avatar -->
            <div class="image-field">
                <div class="image-field__label">{{ avatarText }}</div>
                <div class="image-field__input">
                    <input type="file" ref="add_file" v-on:change="onAvatarUpload('add')">
                </div>
            </div>

        </div>

        <!-- Controls -->
        <div class="form-controls">
            <div class="form-controls__left">
                <v-btn :href="backHref" outlined>
                    <i class="fas fa-arrow-left"></i>
                    {{ backText }}
                </v-btn>
            </div>
            <div class="form-controls__right">
                <v-btn color="success" type="submit" depressed>
                    <i class="far fa-save"></i>
                    {{ saveText }}
                </v-btn>
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        props: [
            "user",
            "errors",
            "oldInput",
            "annotationText",
            "firstNameText",
            "lastNameText",
            "emailText",
            "phoneText",
            "avatarText",
            "backHref",
            "backText",
            "saveText",
        ],
        data: () => ({
            tag: "[update-profile-form]",
            annotationOptions: [],
            form: {
                annotation: "",
                first_name: "",
                last_name: "",
                email: "",
                phone: "",
                avatar: null,
            }
        }),
        computed: {
            currentAssignmentId() {
                return 0;
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" user: ", this.user);
                console.log(this.tag+" errors: ", this.errors);
                console.log(this.tag+" old input: ", this.oldInput);
                console.log(this.tag+" annotation text: ", this.annotationText);
                console.log(this.tag+" first name text: ", this.firstNameText);
                console.log(this.tag+" last name text: ", this.lastNameText);
                console.log(this.tag+" email text: ", this.emailText);
                console.log(this.tag+" phone text: ", this.phoneText);
                console.log(this.tag+" avatar text: ", this.avatarText);
                console.log(this.tag+" back href: ", this.backHref);
                console.log(this.tag+" back text: ", this.backText);
                console.log(this.tag+" save text: ", this.saveText);
                this.generateAnnotationOptions();
                this.initializeData();
            },
            initializeData() {
                if (this.user !== undefined && this.user !== null) {
                    this.form.annotation = this.user.annotation;
                    this.form.first_name = this.user.first_name;
                    this.form.last_name = this.user.last_name;
                    this.form.email = this.user.email;
                    this.form.phone = this.user.phone;
                }
                if (this.oldInput !== undefined && this.oldInput !== null) {
                    if (this.oldInput.annotation !== null) this.form.annotation = this.oldInput.annotation;
                    if (this.oldInput.first_name !== null) this.form.first_name = this.oldInput.first_name;
                    if (this.oldInput.last_name !== null) this.form.last_name = this.oldInput.last_name;
                    if (this.oldInput.email !== null) this.form.email = this.oldInput.email;
                    if (this.oldInput.phone !== null) this.form.phone = this.oldInput.phone;
                }
            },
            generateAnnotationOptions() {
                this.annotationOptions.push({ text: "Dhr.", value: "Dhr." });
                this.annotationOptions.push({ text: "Mevr.", value: "Mevr." });
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
            onAvatarUpload() {
                this.form.avatar = this.$refs.edit_file.files[0];
            },
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    #update-profile-form__wrapper {
        #update-profile-form {
            padding: 25px;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: #fff;
        }
    }
    @media (max-width: 490px) {
        #update-profile-form__wrapper {
            #update-profile-form {
                .form-fields {
                    flex-direction: column;
                }
            }
        }
    }
</style>