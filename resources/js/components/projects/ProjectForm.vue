<template>
    <div id="project-form">
        <div id="project-form__left">
            
            <div class="content-card elevation-1 mb">
                <div class="content-card__content">
                    
                    <!-- Title -->
                    <div class="form-field">
                        <v-text-field 
                            name="title" 
                            label="Titel"
                            placeholder="Geef dit project een naam"
                            v-model="form.title" 
                            :error="hasErrors('title')" 
                            :error-messages="getErrors('title')">
                        </v-text-field>
                    </div>

                    <!-- Slogan -->
                    <div class="form-field">
                        <v-text-field
                            name="slogan"
                            label="Slogan"
                            placeholder="Een pakkende slagzin die de missie samenvat!"
                            v-model="form.slogan"
                            :error="hasErrors('slogan')"
                            :error-messages="getErrors('slogan')">
                        </v-text-field>
                    </div>

                    <!-- Description -->
                    <div class="form-field">
                        <v-textarea
                            name="description" 
                            label="Beschrijving" 
                            placeholder="Wat ga je precies maken en waarom? Hou het kort en bonding en leg uit welk probleem je oplost."
                            v-model="form.description" 
                            :error="hasErrors('description')" 
                            :error-messages="getErrors('description')">
                        </v-textarea>
                    </div>

                    <!-- Header image -->
                    <div class="image-field" :class="{ 'has-errors': hasErrors('header_image') }">
                        <div class="image-field__label">Header achtergrond plaatje</div>
                        <div class="image-field__image-wrapper" v-if="hasProject && projectHasImage">
                            <img class="image-field__image" :src="project.header_image_url">
                        </div>
                        <div class="image-field__input">
                            <input type="file" name="header_image">
                        </div>
                        <div class="image-field__errors" v-if="hasErrors('header_image')">
                            <div class="image-field__error" v-for="(error, ei) in getErrors('header_image')" :key="ei">
                                {{ error }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="content-card elevation-1">
                <div class="content-card__content">

                    <!-- Team roles -->
                    <div class="form-field">
                        <team-roles-field
                            name="team_roles"
                            label="Team rollen"
                            v-model="form.team_roles"
                            :skills="skills">
                        </team-roles-field>
                    </div>

                </div>
            </div>

            <div class="content-card elevation-1 mb">
                <div class="content-card__content">

                    <!-- Resources -->
                    <div class="form-field">
                        <resources-field
                            name="resources"
                            label="Resources"
                            v-model="form.resources"
                            :create-api-endpoint="createResourceApiEndpoint"
                            :update-api-endpoint="updateResourceApiEndpoint"
                            :delete-api-endpoint="deleteResourceApiEndpoint">
                        </resources-field>
                    </div>

                </div>
            </div>

            <!-- Back button -->
            <div class="page-controls mt">
                <div class="page-controls__left">
                    <v-btn :href="backHref" outlined>
                        <i class="fas fa-arrow-left"></i>
                        Terug naar overzicht
                    </v-btn>
                </div>
            </div>

        </div>
        <!-- Right column -->
        <div id="project-form__right">

            <!-- Relationships card -->
            <div class="content-card elevation-1 mb">
                <div class="content-card__content">

                    <!-- Category -->
                    <div class="form-field">
                        <v-select
                            label="Project categorie"
                            :items="categoryOptions"
                            v-model="form.project_category_id"
                            :errors="hasErrors('project_category_id')"
                            :error-messages="getErrors('project_category_id')">
                        </v-select>
                        <input type="hidden" name="project_category_id" :value="form.project_category_id">
                    </div>

                    <!-- Work method -->
                    <div class="form-field">
                        <v-select
                            label="Werkmethode"
                            :items="workMethodOptions"
                            v-model="form.work_method_id"
                            :errors="hasErrors('work_method_id')"
                            :error-messages="getErrors('work_method_id')">
                        </v-select>
                        <input type="hidden" name="work_method_id" :value="form.work_method_id">
                    </div>  

                    <!-- Status -->
                    <div class="form-field mb-0">
                        <v-select
                            label="Project status"
                            :items="statusOptions"
                            v-model="form.project_status_id"
                            :errors="hasErrors('project_status_id')"
                            :error-messages="getErrors('project_status_id')">
                        </v-select>
                        <input type="hidden" name="project_status_id" :value="form.project_status_id">
                    </div>

                </div>
            </div>

            <!-- Dates card -->
            <div class="content-card elevation-1">
                <div class="content-card__content">

                    <!-- Starts at -->
                    <div class="form-field mb-10">
                        <datepicker
                            name="starts_at"
                            label="Start op"
                            v-model="form.starts_at"
                            :error="hasErrors('starts_at')"
                            :error-messages="getErrors('starts_at')">
                        </datepicker>
                    </div>

                    <!-- Ends at -->
                    <div class="form-field">
                        <datepicker
                            name="ends_at"
                            label="Eindigt op"
                            v-model="form.ends_at"
                            :error="hasErrors('ends_at')"
                            :error-messages="getErrors('ends_at')">
                        </datepicker>
                    </div>

                </div>
            </div>

            <!-- Submit button -->
            <div class="page-controls mt">
                <div class="page-controls__left">
                    <v-btn :href="backHref" outlined>
                        <i class="fas fa-arrow-left"></i>
                        Terug naar overzicht
                    </v-btn>
                </div>
                <div class="page-controls__right">
                    <v-btn type="submit" color="success">
                        <i class="fas fa-save"></i>
                        Opslaan
                    </v-btn>
                </div>
            </div>

        </div>        

    </div>
</template>

<script>
    export default {
        props: [
            "project",
            "projectStatuses",
            "projectCategories",
            "workMethods",
            "skills",
            "errors",
            "oldInput",
            "backHref",
            "createResourceApiEndpoint",
            "updateResourceApiEndpoint",
            "deleteResourceApiEndpoint",
        ],
        data: () => ({
            tag: "[project-form]",
            workMethodOptions: [],
            categoryOptions: [],
            statusOptions: [],
            form: {
                project_status_id: 0,
                project_category_id: 0,
                work_method_id: 0,
                title: "",
                slogan: "",
                description: "",
                starts_at: "",
                ends_at: "",
                resources: [],
                team_roles: [],
            }
        }),
        computed: {
            hasProject() {
                return this.project !== undefined && this.project !== null && this.project !== "";
            },
            projectHasImage() {
                return this.hasProject && this.project.header_image_url !== null && this.project.header_image_url !== '';
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" project: ", this.project);
                console.log(this.tag+" project statuses: ", this.projectStatuses);
                console.log(this.tag+" project categories: ", this.projectCategories);
                console.log(this.tag+" work methods: ", this.workMethods);
                console.log(this.tag+" skills: ", this.skills);
                console.log(this.tag+" errors: ", this.errors);
                console.log(this.tag+" old input: ", this.oldInput);
                console.log(this.tag+" create resource api endpoint: ", this.createResourceApiEndpoint);
                console.log(this.tag+" update resource api endpoint: ", this.updateResourceApiEndpoint);
                console.log(this.tag+" delete resource api endpoint: ", this.deleteResourceApiEndpoint);
                this.generateWorkMethodOptions();
                this.generateCategoryOptions();
                this.generateStatusOptions();
                this.initializeData();
            },
            initializeData() {
                this.form.project_status_id = this.statusOptions[0].value;
                if (this.project !== undefined && this.project !== null) {
                    this.form.project_status_id = this.project.project_status_id;
                    this.form.project_category_id = this.project.project_category_id;
                    this.form.work_method_id = this.project.work_method_id;
                    this.form.title = this.project.title;
                    this.form.slogan = this.project.slogan;
                    this.form.description = this.project.description;
                    this.form.starts_at = this.project.starts_at;
                    this.form.ends_at = this.project.ends_at;
                    if (this.project.resources !== undefined && this.project.resources !== null && this.project.resources.length > 0) {
                        this.form.resources = this.project.resources;
                    }
                    if (this.project.team_roles !== undefined && this.project.team_roles !== null && this.project.team_roles.length > 0) {
                        let teamRoles = [];
                        for (let i = 0; i < this.project.team_roles.length; i++) {
                            let skills = [];
                            for (let j = 0; j < this.project.team_roles[i].skills.length; j++) {
                                skills.push(this.project.team_roles[i].skills[j].name);
                            }
                            teamRoles.push({
                                name: this.project.team_roles[i].name,
                                description: this.project.team_roles[i].description,
                                skills: skills,
                            });
                        }
                        this.form.team_roles = teamRoles;
                    }
                }
                if (this.oldInput !== undefined && this.oldInput !== null) {
                    if (this.oldInput.project_status_id !== null) this.form.project_status_id = this.oldInput.project_status_id;
                    if (this.oldInput.project_category_id !== null) this.form.project_category_id = this.oldInput.project_category_id;
                    if (this.oldInput.work_method_id !== null) this.form.work_method_id = this.oldInput.work_method_id;
                    if (this.oldInput.title !== null) this.form.title = this.oldInput.title;
                    if (this.oldInput.slogan !== null) this.form.slogan = this.oldInput.slogan;
                    if (this.oldInput.description !== null) this.form.description = this.oldInput.description;
                    if (this.oldInput.starts_at !== null) this.form.starts_at = this.oldInput.starts_at;
                    if (this.oldInput.ends_at !== null) this.form.ends_at = this.oldInput.ends_at;
                    if (this.oldInput.resources !== null) this.form.resources = JSON.parse(this.oldInput.resources);
                    if (this.oldInput.team_roles !== null) this.form.team_roles = JSON.parse(this.oldInput.team_roles);
                }
            },
            generateStatusOptions() {
                if (this.projectStatuses !== undefined && this.projectStatuses !== null && this.projectStatuses.length > 0) {
                    for (let i = 0; i < this.projectStatuses.length; i++) {
                        this.statusOptions.push({
                            text: this.projectStatuses[i].label,
                            value: this.projectStatuses[i].id,
                        });
                    }
                } else {
                    this.statusOptions.push({ text: "Geen statusen gevonden", value: 0 });
                }
            },
            generateCategoryOptions() {
                if (this.projectCategories !== undefined && this.projectCategories !== null && this.projectCategories.length > 0) {
                    this.categoryOptions.push({ text: "Selecteer categorie", value: 0 });
                    for (let i = 0; i < this.projectCategories.length; i++) {
                        this.categoryOptions.push({
                            text: this.projectCategories[i].label,
                            value: this.projectCategories[i].id,
                        });
                    }
                } else {
                    this.categoryOptions.push({ text: "Geen categorieen gevonden", value: 0 });
                }
            },
            generateWorkMethodOptions() {
                if (this.workMethods !== undefined && this.workMethods !== null && this.workMethods.length > 0) {
                    this.workMethodOptions.push({ text: "Selecteer gewenste werkmethode", value: 0 });
                    for (let i = 0; i < this.workMethods.length; i++) {
                        this.workMethodOptions.push({
                            text: this.workMethods[i].label,
                            value: this.workMethods[i].id,
                        });
                    }
                } else {
                    this.workMethodOptions.push({ text: "Geen werkmethodes gevonden", value: 0 });
                }
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
    #project-form {
        display: flex;
        flex-direction: row;
        #project-form__left {
            flex: 2;
        }
        #project-form__right {
            flex: 1;
            margin: 0 0 0 30px;
            .page-controls {
                .page-controls__left {
                    display: none;
                }
            }
        }
    }
    @media (max-width: 760px) {
        #project-form {
            flex-wrap: wrap;
            #project-form__left, #project-form__right {
                flex: 0 0 100%;
            }
            #project-form__left {
                .page-controls {
                    display: none;
                }
            }
            #project-form__right {
                margin: 30px 0 0 0;
                .page-controls {
                    .page-controls__left {
                        display: block;
                    }
                }
            }
        }
    }
</style>