<template>
    <div class="team-roles-field">

        <!-- Label -->
        <div class="team-roles-field__label">{{ labelText }}</div>

        <!-- Roles -->
        <div class="team-roles-field__roles" v-if="mutableTeamRoles.length > 0">
            <div class="role" v-for="(role, ri) in mutableTeamRoles" :key="ri">
                <div class="role-name">{{ role.name }}</div>
                <div class="role-skills">
                    {{ role.skills.length === 1 ? "1 vereiste skill" : role.skills.length+" vereiste skills" }}
                </div>
                <div class="role-actions">
                    <div class="role-action view" @click="onClickView(ri)">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="role-action edit" @click="onClickEdit(ri)">
                        <i class="fas fa-pen-square"></i>
                    </div>
                    <div class="role-action delete" @click="onClickDelete(ri)">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- No roles -->
        <div class="team-roles-field__no-roles" v-if="mutableTeamRoles.length === 0">
            Er zijn nog geen team rollen gedefineert.
        </div>

        <!-- Actions -->
        <div class="team-roles-field__actions">
            <v-btn depressed color="primary" small @click="onClickAdd">
                <i class="fas fa-plus"></i>
                Team rol toevoegen
            </v-btn>
        </div>

        <!-- View dialog -->
        <v-dialog v-model="dialogs.view.show" width="650" v-if="dialogs.view.index !== null">
            <div class="dialog">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.view.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Team rol</h3>
                    <!-- Details -->
                    <div class="details bordered compact">
                        <div class="detail">
                            <div class="key">Naam</div>
                            <div class="val">{{ getRoleName(dialogs.view.index) }}</div>
                        </div>
                        <div class="detail">
                            <div class="key">Beschrijving</div>
                            <div class="val">{{ getRoleDescription(dialogs.view.index) }}</div>
                        </div>
                        <div class="detail">
                            <div class="key">Vereiste skills</div>
                            <div class="val">
                                <div class="skills-list">
                                    <div class="skill" v-for="(skill, si) in getRoleSkills(dialogs.view.index)" :key="si">
                                        {{ skill }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <v-btn text @click="dialogs.view.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn text dark color="warning" @click="onClickEdit(dialogs.view.index)">
                            <i class="fas fa-pen-square"></i>
                            Wijzigen
                        </v-btn>
                        <v-btn text dark color="red" @click="onClickDelete(dialogs.view.index)">
                            <i class="fas fa-trash-alt"></i>
                            Verwijderen
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Add dialog -->
        <v-dialog v-model="dialogs.add.show" width="500">
            <div class="dialog">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.add.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Team rol toevoegen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.add.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.add.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Name -->
                    <div class="form-field">
                        <v-text-field
                            label="Titel"
                            v-model="dialogs.add.form.name">
                        </v-text-field>
                    </div>
                    <!-- Description -->
                    <div class="form-field">
                        <v-textarea
                            label="Rolomschrijving"
                            v-model="dialogs.add.form.description">
                        </v-textarea>
                    </div>
                    <!-- Skills -->
                    <div class="form-field">
                        <v-combobox
                            label="Vereiste skills"
                            v-model="dialogs.add.form.skills"
                            :items="skillOptions"
                            multiple>
                        </v-combobox>
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <v-btn text @click="dialogs.add.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn 
                            color="success" 
                            @click="onClickConfirmAdd" 
                            :disabled="confirmAddDisabled">
                            <i class="far fa-save"></i>
                            Opslaan
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Update dialog -->
        <v-dialog v-model="dialogs.edit.show" width="500">
            <div class="dialog" v-if="dialogs.edit.index !== null">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.edit.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Team rol aanpassen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.edit.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.edit.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Name -->
                    <div class="form-field">
                        <v-text-field
                            label="Titel"
                            v-model="dialogs.edit.form.name">
                        </v-text-field>
                    </div>
                    <!-- Description -->
                    <div class="form-field">
                        <v-textarea
                            label="Rolomschrijving"
                            v-model="dialogs.edit.form.description">
                        </v-textarea>
                    </div>
                    <!-- Skills -->
                    <div class="form-field">
                        <v-combobox
                            label="Vereiste skills"
                            v-model="dialogs.edit.form.skills"
                            :items="skillOptions"
                            multiple>
                        </v-combobox>
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <v-btn text @click="dialogs.edit.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn
                            color="success" 
                            @click="onClickConfirmEdit" 
                            :disabled="confirmEditDisabled">
                            <i class="far fa-save"></i>
                            Opslaan
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Delete dialog -->
        <v-dialog v-model="dialogs.delete.show" width="500">
            <div class="dialog" v-if="dialogs.delete.index !== null">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.delete.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Team rol verwijderen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.delete.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.delete.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Text -->
                    <div class="dialog-text">
                        Weet je zeker dat je deze team rol ({{ getRoleTitle(dialogs.delete.index) }}) wilt verwijderen?
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <v-btn text @click="dialogs.delete.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Nee, annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn 
                            dark
                            color="red"
                            @click="onClickConfirmDelete">
                            <i class="fas fa-trash-alt"></i>
                            Ja, verwijder
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Hidden input -->
        <input type="hidden" :name="name" :value="encodedTeamRoles">

    </div>
</template>

<script>
    export default {
        props: [
            "name",
            "label",
            "value",
            "skills",
        ],
        data: () => ({
            tag: "[team-roles-field]",
            mutableTeamRoles: [],
            skillOptions: [],
            loaded: false,
            dialogs: {
                view: {
                    show: false,
                    index: null,
                },
                add: {
                    show: false,
                    errors: [],
                    form: {
                        name: "",
                        description: "",
                        skills: [],
                    }
                },
                edit: {
                    show: false,
                    index: null,
                    errors: [],
                    form: {
                        name: "",
                        description: "",
                        skills: [],
                    }
                },
                delete: {
                    show: false,
                    index: null,
                    errors: [],
                }
            }
        }),
        computed: {
            labelText() {
                return this.label !== undefined && this.label !== null && this.label !== "" ? this.label : "Team rollen";
            },
            confirmAddDisabled() {
                return this.dialogs.add.form.name === "";
            },
            confirmEditDisabled() {
                return this.dialogs.edit.form.name === "";
            },
            encodedTeamRoles() {
                return JSON.stringify(this.mutableTeamRoles);
            },
        },
        watch: {
            value() {
                console.log(this.tag+" value changed: ", this.value);
                console.log(this.tag+" loaded: ", this.loaded);
                if (!this.loaded) {
                    this.mutableTeamRoles = this.value;
                    this.loaded = true;
                }
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" name: ", this.name);
                console.log(this.tag+" label: ", this.label);
                console.log(this.tag+" value: ", this.value);
                console.log(this.tag+" skills: ", this.skills);
                this.generateSkillOptions();
                this.initializeData();
            },
            initializeData() {
                console.log(this.tag+" initializing data");
                console.log(this.tag+" value: ", this.value);
                if (this.value !== undefined && this.value !== null && this.value !== "" && this.value.length > 0) {
                    this.mutableTeamRoles = this.value;
                    this.loaded = true;
                }
            },
            generateSkillOptions() {
                if (this.skills !== undefined && this.skills !== null && this.skills.length > 0) {
                    for (let i = 0; i < this.skills.length; i++) {
                        this.skillOptions.push(this.skills[i].name);
                    }
                }
            },
            onClickAdd() {
                // Show the dialogs
                this.dialogs.add.show = true;
            },
            onClickConfirmAdd() {
                // Add team member to the list
                this.mutableTeamRoles.push({
                    name: this.dialogs.add.form.name,
                    description: this.dialogs.add.form.description,
                    skills: this.dialogs.add.form.skills,
                });
                // Reset form
                this.dialogs.add.form.name = "";
                this.dialogs.add.form.description = "";
                this.dialogs.add.form.skills = [];
                // Hide dialog
                this.dialogs.add.show = false;
            },
            onClickView(index) {
                this.dialogs.view.index = index;
                this.dialogs.view.show = true;
            },
            onClickEdit(index) {
                // Close the view dialog if its open
                if (this.dialogs.view.show) this.dialogs.view.show = false;
                // Save the index
                this.dialogs.edit.index = index;
                // Populate the dialog's form
                this.dialogs.edit.form.name = this.mutableTeamRoles[index].title;
                this.dialogs.edit.form.description = this.mutableTeamRoles[index].description;
                this.dialogs.edit.form.skills = this.mutableTeamRoles[index].skills;
                // Show the edit dialog
                this.dialogs.edit.show = true;
            },
            onClickConfirmEdit() {
                // Update the team member
                this.mutableTeamRoles[this.dialogs.edit.index].title = this.dialogs.edit.form.title;
                this.mutableTeamRoles[this.dialogs.edit.index].skills = this.dialogs.edit.form.skills;
                // Hide the dialog
                this.dialogs.edit.show = false;
            },
            onClickDelete(index) {
                // Close the view dialog if its open
                if (this.dialogs.view.show) this.dialogs.view.show = false;
                // Save the index
                this.dialogs.delete.index = index;
                // Open up the dialog
                this.dialogs.delete.show = true;
            },
            onClickConfirmDelete() {
                // Remove the team member from the list
                this.mutableTeamRoles.splice(this.dialogs.delete.index, 1);
                // Hide the dialog
                this.dialogs.delete.show = false;
            },
            getRoleName(index) {
                let role = this.mutableTeamRoles[index];
                if (role) {
                    return role.name;
                }
                return "";
            },
            getRoleDescription(index) {
                return this.mutableTeamRoles[index].description;
            },
            getRoleSkills(index) {
                return this.mutableTeamRoles[index].skills;
            },
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    .team-roles-field {
        .team-roles-field__label {
            color: #737373;
            font-size: .85em;
            margin: 0 0 10px 0;
        }
        .team-roles-field__roles {
            background-color: hsl(0, 0%, 95%);
            .role {
                display: flex;
                padding: 10px 15px;
                flex-direction: row;
                box-sizing: border-box;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                &:last-child {
                    border-bottom: 0;
                }
                .role-name {
                    flex: 2;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
                .role-skills {
                    flex: 1;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
                .role-actions {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    .role-action {
                        width: 24px;
                        height: 24px;
                        display: flex;
                        font-size: .8em;
                        color: #ffffff;
                        border-radius: 3px;
                        margin: 0 10px 0 0;
                        transition: all .3s;
                        align-items: center;
                        justify-content: center;
                        background-color: hsl(0, 0%, 0%);
                        &.view {
                            background-color: #006ac7;
                            &:hover {
                                background-color: #005197;
                            }
                        }
                        &.edit {
                            background-color: #f04400;
                            &:hover {
                                background-color: #c73800;
                            }
                        }
                        &.delete {
                            background-color: #d40000;
                            &:hover {
                                background-color: #950000;
                            }
                        }
                        &:hover {
                            cursor: pointer;
                            background-color: hsl(0, 0%, 15%);
                        }
                        &:last-child {
                            margin: 0;
                        }
                    }
                }
            }
        }
        .team-roles-field__no-roles {
            padding: 15px;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: hsl(0, 0%, 95%);
        }
        .team-roles-field__actions {
            display: flex;
            margin: 15px 0 0 0;
            flex-direction: row;
            justify-content: flex-end;
            .v-btn {
                margin: 0 0 0 15px;
            }
        }
    }
</style>