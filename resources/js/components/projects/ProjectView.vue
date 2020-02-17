<template>
    <div id="project-view">

        <!-- Project status -->
        <div id="project-stats">
            <!-- Status -->
            <div id="project-status" class="elevation-1" :class="project.status.name">
                <div id="project-status__label">Status</div>
                <div id="project-status__value">{{ project.status.label }}</div>
            </div>
        </div>
        
        <!-- Project content -->
        <v-tabs v-model="currentTab" id="project-tabs" class="elevation-1">
            <!-- Tabs -->
            <v-tab>Algemene informatie</v-tab>
            <v-tab>Het Team</v-tab>
            <!-- General info tab -->
            <v-tab-item>
                <div class="tab-content">
                
                    <div id="project-info">
                        <div id="project-info__left">
                            
                            <!-- Projectomschrijving -->
                            <div class="project-paragraph">
                                <h3 class="project-paragraph__title">Projectomschrijving</h3>
                                <div class="project-paragraph__text">{{ project.description }}</div>
                            </div>

                            <!-- Resources -->
                            <div class="project-paragraph">
                                <h3 class="project-paragraph__title">Resources</h3>
                                <div id="project-resources">
                                    <div id="project-resources__list" v-if="project.resources.length > 0">
                                        <div class="resource" v-for="(resource, ri) in project.resources" :key="ri">
                                            <div class="resource-icon">
                                                <i class="far fa-file"></i>
                                            </div>
                                            <div class="resource-title">{{ resource.title }}</div>
                                            <div class="resource-size">{{ resource.file_size }} kb</div>
                                        </div>
                                    </div>
                                    <div id="project-resources__empty" v-if="project.resources.length === 0">
                                        Er zijn nog geen resources toegevoegd.
                                    </div>
                                </div>
                            </div>

                            <!-- Comments -->
                            <comments
                                :user="user"
                                :comments="comments"
                                per-page="3"
                                target-type="project"
                                :target-id="project.id"
                                :create-comment-api-endpoint="createCommentApiEndpoint"
                                :update-comment-api-endpoint="updateCommentApiEndpoint"
                                :delete-comment-api-endpoint="deleteCommentApiEndpoint">
                            </comments>

                        </div>
                        <div id="project-info__right">

                            <!-- Author of the project -->
                            <div class="project-paragraph">
                                <h3 class="project-paragraph__title">Project gestart door</h3>
                                <div id="project-author">
                                    <user-pill :user="project.author" dark></user-pill>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="project-paragraph">
                                <h3 class="project-paragraph__title">Details</h3>
                                <div id="project-details">
                                    <!-- ID -->
                                    <div class="detail">
                                        <div class="key">ID</div>
                                        <div class="val">{{ project.id }}</div>
                                    </div>
                                    <!-- Category -->
                                    <div class="detail">
                                        <div class="key">Categorie</div>
                                        <div class="val">{{ project.category.label }}</div>
                                    </div>
                                    <!-- Work method -->
                                    <div class="detail">
                                        <div class="key">Werkmethode</div>
                                        <div class="val">{{ project.work_method.label }}</div>
                                    </div>
                                    <!-- Starts at -->
                                    <div class="detail">
                                        <div class="key">Start op</div>
                                        <div class="val">
                                            <span class="italic" v-if="project.formatted_starts_at === null">Nader te bepalen</span>
                                            <span v-if="project.formatted_starts_at !== null">{{ project.formatted_starts_at }}</span>
                                        </div>
                                    </div>
                                    <!-- Ends at -->
                                    <div class="detail">
                                        <div class="key">Stopt op</div>
                                        <div class="val">
                                            <span class="italic" v-if="project.formatted_ends_at === null">Nader te bepalen</span>
                                            <span v-if="project.formatted_ends_at !== null">{{ project.formatted_ends_at }}</span>
                                        </div>
                                    </div>
                                    <!-- Created by -->
                                    <div class="detail">
                                        <div class="key">Toegevoegd door</div>
                                        <div class="val">
                                            <a :href="project.author.profile_href">{{ project.author.formatted_name }}</a>
                                        </div>
                                    </div>
                                    <!-- Created at -->
                                    <div class="detail">
                                        <div class="key">Toegevoegd op</div>
                                        <div class="val">{{ project.formatted_created_at }}</div>
                                    </div>
                                    <!-- Updated at -->
                                    <div class="detail">
                                        <div class="key">Laatste gewijzigd op</div>
                                        <div class="val">{{ project.formatted_updated_at }}</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </v-tab-item>
            <!-- The team tab -->
            <v-tab-item>
                <div class="tab-content">
                    
                    <!-- Title & desc -->
                    <h3 class="content-subtitle">Team rollen</h3>
                    <div class="content-desc">Alle rollen die vervult dienen te worden om dit project tot een succes te maken.</div>
                    
                    <!-- Team -->
                    <div id="team">
                        <!-- Team role list -->
                        <div id="team-roles" v-if="mutableRoles.length > 0">
                            <!-- Team role -->
                            <div class="team-role__wrapper" v-for="(role, ri) in mutableRoles" :key="ri">
                                <div class="team-role">
                                    <!-- Avatar -->
                                    <div class="team-role__avatar-wrapper">
                                        <div class="team-role__avatar" v-if="role.team_member" :style="{ backgroundImage: 'url('+role.team_member.user.avatar_url+')' }"></div>
                                        <div class="team-role__avatar" v-if="!role.team_member">
                                            Open!<br>
                                            Meld je aan
                                        </div>
                                    </div>
                                    <!-- Text -->
                                    <div class="team-role__text-wrapper">
                                        <div class="role-name">{{ role.name }}</div>
                                        <div class="role-skills__wrapper" v-if="role.skills.length > 0"> 
                                            <!-- <div class="role-skills__label">Vereiste skills</div> -->
                                            <div class="role-skills">
                                                <div class="role-skill" v-for="(skill, si) in role.skills" :key="si">
                                                    {{ skill.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Assigned member -->
                                    <div class="team-role__member" v-if="role.team_member">
                                        <div class="team-role__member-label">Vervuld door:</div>
                                        <user-pill :user="role.team_member.user"></user-pill>
                                    </div>
                                    <!-- Actions -->
                                    <div class="team-role__actions" v-if="!role.team_member">
                                        <v-btn color="primary" large depressed @click="onClickApplyForRole(ri)">
                                            Meld je aan!
                                        </v-btn>
                                    </div>
                                </div>
                                <div class="team-role__footer" v-if="role.team_member">
                                    <div class="team-role__footer-left">

                                    </div>
                                    <div class="team-role__footer-right">
                                        <v-btn small color="red" dark depressed @click="onClickUnassignMember(ri)">
                                            Team lid afzetten
                                        </v-btn>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- No team roles -->
                        <div id="no-team-roles" v-if="project.team_roles.length === 0">
                            Er zijn nog geen rollen gedefineert.
                        </div>
                    </div>
                    
                    <!-- Applications -->
                    <h3 class="content-subtitle">Aanmeldingen</h3>
                    <div id="member-applications">
                        <div id="member-applications__list" v-if="mutableApplications.length > 0">
                            <div class="member-application" v-for="(application, ai) in mutableApplications" :key="ai" @click="onClickMemberApplication(ai)">
                                <div class="status-wrapper">
                                    <div class="status" :class="getApplicationStatusClass(application)">
                                        {{ getApplicationStatusLabel(application) }}
                                    </div>                                    
                                </div>
                                <div class="user-name">
                                    {{ application.user.formatted_name }}
                                </div>
                                <div class="role-name">
                                    {{ application.team_role.name }}
                                </div>
                                <div class="created-at">
                                    {{ application.formatted_created_at }}
                                </div>
                            </div>
                        </div>
                        <div id="member-applications__empty" v-if="mutableApplications.length === 0">
                            Er zijn nog geen aanmeldingen binnengekomen.
                        </div>
                    </div>

                </div>
            </v-tab-item>
        </v-tabs>

        <!-- Apply for team member position dialog -->
        <v-dialog v-model="dialogs.apply.show" width="500">
            <div class="dialog">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.apply.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Aanmelden als {{ getApplicationJobTitle() }}</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.apply.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.apply.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Motivation -->
                    <div class="form-field">
                        <v-textarea 
                            label="Motivatie" 
                            placeholder="Waarom zou je deze rol willen vervullen?"
                            :loading="dialogs.apply.loading"
                            v-model="dialogs.apply.form.motivation">
                        </v-textarea>
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <v-btn text @click="dialogs.apply.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn 
                            depressed 
                            color="success"
                            @click="onClickConfirmApply" 
                            :loading="dialogs.apply.loading" 
                            :dark="!submitApplicationDisabled"
                            :disabled="submitApplicationDisabled">
                            <i class="far fa-save"></i>
                            Opslaan
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Edit application dialog -->
        <v-dialog v-model="dialogs.edit_application.show" width="500">
            <div class="dialog">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.edit_application.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Aanmelding wijzigingen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.edit_application.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.edit_application.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Motivation -->
                    <div class="form-field">
                        <v-textarea 
                            label="Motivatie" 
                            placeholder="Waarom zou je deze rol willen vervullen?"
                            :loading="dialogs.edit_application.loading"
                            v-model="dialogs.edit_application.form.motivation">
                        </v-textarea>
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <v-btn text @click="dialogs.edit_application.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn 
                            depressed 
                            color="success"
                            @click="onClickConfirmEditApplication" 
                            :loading="dialogs.edit_application.loading" 
                            :dark="!editApplicationDisabled"
                            :disabled="editApplicationDisabled">
                            <i class="far fa-save"></i>
                            Opslaan
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Delete application dialog -->
        <v-dialog v-model="dialogs.delete_application.show" width="500">
            <div class="dialog">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.delete_application.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Aanmelding wijzigingen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.delete_application.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.delete_application.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Text -->
                    <div class="dialog-text">
                        Weet je zeker dat je deze aanmelding wilt verwijderen?
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <v-btn 
                            text 
                            @click="dialogs.delete_application.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Nee, annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn 
                            dark depressed color="red"
                            @click="onClickConfirmDeleteApplication" 
                            :loading="dialogs.delete_application.loading">
                            <i class="fas fa-trash"></i>
                            Ja, verwijderen
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- View team member application dialog -->
        <v-dialog v-model="dialogs.application.show" width="700">
            <div class="dialog">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.application.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Bekijk aanmelding</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.application.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.application.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <div id="application-dialog-text" v-if="mutableApplications[dialogs.application.index] !== undefined">
                        <!-- Role -->
                        <div id="role-name">
                            <div id="role-name__label">Aangemeld voor de rol</div>
                            <div id="role-name__text">
                                {{ mutableApplications[dialogs.application.index].team_role.name }}
                            </div>
                        </div>
                        <!-- User -->
                        <div id="user-wrapper">
                            <user-pill dark :user="mutableApplications[dialogs.application.index].user"></user-pill>
                        </div>
                        <!-- Motivation -->
                        <div id="motivation">
                            <div id="motivation-label">Motivatie</div>
                            <div id="motivation-text">
                                {{ mutableApplications[dialogs.application.index].motivation }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls" v-if="showApplicationDialogControls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <!-- Deny button -->
                        <v-btn 
                            depressed 
                            color="red" 
                            @click="onClickDenyApplication"
                            :dark="!denyApplicationDisabled"
                            :loading="denyApplicationLoading"
                            :disabled="denyApplicationDisabled">
                            <i class="far fa-thumbs-down"></i>
                            Afwijzen
                        </v-btn>
                        <!-- Accept button -->
                        <v-btn 
                            depressed 
                            color="success"
                            @click="onClickAcceptApplication"
                            :loading="acceptApplicationLoading"
                            :disabled="acceptApplicationDisabled">
                            <i class="far fa-thumbs-up"></i>
                            Accepteren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <!-- Edit button -->
                        <v-btn
                            depressed
                            color="warning"
                            @click="onClickEditApplication(dialogs.application.index)">
                            Edit
                        </v-btn>
                        <!-- Delete button -->
                        <v-btn
                            dark
                            depressed
                            color="red"
                            @click="onClickDeleteApplication(dialogs.application.index)">
                            Delete
                        </v-btn>
                    </div>
                </div>
                <!-- Alternative to controls -->
                <div class="dialog-controls" v-if="!showApplicationDialogControls && mutableApplications[dialogs.application.index] !== undefined">
                    <div class="dialog-controls__left">
                        {{ getApplicationStatusLabel(mutableApplications[dialogs.application.index]) }}
                    </div>
                    <div class="dialog-controls__right">
                        <!-- Edit button -->
                        <v-btn
                            small
                            depressed
                            color="warning"
                            @click="onClickEditApplication(dialogs.application.index)">
                            Edit
                        </v-btn>
                        <!-- Delete button -->
                        <v-btn
                            small
                            dark
                            depressed
                            color="red"
                            @click="onClickDeleteApplication(dialogs.application.index)">
                            Delete
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Unassign member dialog -->
        <v-dialog v-model="dialogs.unassign.show" width="500">
            <div class="dialog" v-if="dialogs.unassign.index !== null">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.unassign.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Team lid afzetten</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.unassign.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.unassign.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <div class="dialog-text">
                        Weet je zeker dat je {{ mutableRoles[dialogs.unassign.index].team_member.user.formatted_name }} wilt afzetten uit/haar rol als {{ mutableRoles[dialogs.unassign.index].name }}?
                    </div>
                </div>
                <!-- Controls -->
                <div class="dialog-controls">
                    <!-- Cancel -->
                    <div class="dialog-controls__left">
                        <!-- Deny button -->
                        <v-btn 
                            depressed
                            @click="dialogs.unassign.show = false">
                            <i class="fas fa-arrow-left"></i>
                            Nee, annuleren
                        </v-btn>
                    </div>
                    <!-- Confirm delete -->
                    <div class="dialog-controls__right">
                        <v-btn
                            dark
                            depressed
                            color="red"
                            @click="onClickConfirmUnassignMember">
                            Delete
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

    </div>
</template>

<script>
    export default {
        props: [
            "project",
            "user",
            "comments",
            "createCommentApiEndpoint",
            "updateCommentApiEndpoint",
            "deleteCommentApiEndpoint",
            "createTeamMemberApplicationApiEndpoint",
            "updateTeamMemberApplicationApiEndpoint",
            "deleteTeamMemberApplicationApiEndpoint",
            "acceptTeamMemberApplicationApiEndpoint",
            "denyTeamMemberApplicationApiEndpoint",
        ],
        data: () => ({
            tag: "[project-view]",
            currentTab: 0,
            mutableRoles: [],
            mutableApplications: [],
            dialogs: {
                apply: {
                    show: false,
                    index: null,
                    errors: [],
                    loading: false,
                    form: {
                        motivation: "",
                    }
                },
                application: {
                    show: false,
                    index: null,
                    errors: [],
                    loading: false,
                    operation: null,
                },
                edit_application: {
                    closed_view: false,
                    show: false,
                    index: null,
                    loading: false,
                    errors: [],
                    form: {
                        motivation: "",
                    }
                },
                delete_application: {
                    closed_view: false,
                    show: false,
                    index: null,
                    loading: false,
                    errors: [],
                },
                unassign: {
                    show: false,
                    index: null,
                    loading: false,
                    errors: [],
                },
            }
        }),
        computed: {
            submitApplicationDisabled() {
                return this.dialogs.apply.form.motivation === "";
            },
            acceptApplicationDisabled() {
                return this.dialogs.application.operation === "deny" && this.dialogs.application.loading;
            },
            acceptApplicationLoading() {
                return this.dialogs.application.operation === 'accept' && this.dialogs.application.loading;
            },
            denyApplicationDisabled() {
                return this.dialogs.application.operation === "accept" && this.dialogs.application.loading;
            },
            denyApplicationLoading() {
                return this.dialogs.application.operation === 'deny' && this.dialogs.application.loading;
            },
            showApplicationDialogControls() {
                return this.mutableApplications[this.dialogs.application.index] !== undefined && 
                      !this.mutableApplications[this.dialogs.application.index].processed;
            },
            editApplicationDisabled() {
                return this.dialogs.edit_application.form.motivation === "";
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" project: ", this.project);
                console.log(this.tag+" user: ", this.user);
                console.log(this.tag+" comments: ", this.comments);
                console.log(this.tag+" create comment api endpoint: ", this.createCommentApiEndpoint);
                console.log(this.tag+" update comment api endpoint: ", this.updateCommentApiEndpoint);
                console.log(this.tag+" delete comment api endpoint: ", this.deleteCommentApiEndpoint);
                console.log(this.tag+" create team member application api endpoint: ", this.createTeamMemberApplicationApiEndpoint);
                console.log(this.tag+" update team member application api endpoint: ", this.updateTeamMemberApplicationApiEndpoint);
                console.log(this.tag+" delete team member application api endpoint: ", this.deleteTeamMemberApplicationApiEndpoint);
                console.log(this.tag+" accept team member application api endpoint: ", this.acceptTeamMemberApplicationApiEndpoint);
                console.log(this.tag+" deny team member application api endpoint: ", this.denyTeamMemberApplicationApiEndpoint);
                this.initializeData();
            },
            initializeData() {
                if (this.project !== undefined && this.project !== null) {
                    if (this.project.team_member_applications !== undefined && this.project.team_member_applications !== null && this.project.team_member_applications.length > 0) {
                        for (let i = 0; i < this.project.team_member_applications.length; i++) {
                            this.mutableApplications.push(this.project.team_member_applications[i]);
                        }
                    }
                    if (this.project.team_roles !== undefined && this.project.team_roles !== null && this.project.team_roles.length > 0) {
                        for (let i = 0; i < this.project.team_roles.length; i++) {
                            this.mutableRoles.push(this.project.team_roles[i]);
                        }
                    }
                }
            },
            onClickViewTeam() {
                this.currentTab = 1;
            },
            onClickApplyForRole(index) {
                console.log(this.tag+" clicked apply for role button", index);
                this.dialogs.apply.index = index;
                this.dialogs.apply.show = true;
            },
            onClickConfirmApply() {
                console.log(this.tag+" clicked confirm apply button");

                this.dialogs.apply.loading = true;
                this.dialogs.apply.errors = [];
                
                let payload = new FormData();
                payload.append("project_id", this.project.id);
                payload.append("team_role_id", this.project.team_roles[this.dialogs.apply.index].id);
                payload.append("motivation", this.dialogs.apply.form.motivation);
                
                console.log(this.tag+" sending API request");
                this.axios.post(this.createTeamMemberApplicationApiEndpoint, payload)
                    .then(function(response) {
                        console.log(this.tag+" request succeeded");
                        if (response.data.status === "success") {
                            console.log(this.tag+" operation succeeded");
                            this.mutableApplications.push(response.data.application);
                            this.dialogs.apply.loading = false;
                            this.dialogs.apply.show = false;
                            this.dialogs.apply.form.description = "";
                        } else {
                            console.warn(this.tag+" operation failed", response.data.error);
                            this.dialogs.apply.loading = false;
                            this.dialogs.apply.errors = [response.data.error];
                        }
                    }.bind(this))
                    .catch(function(error) {
                        console.log(this.tag+" request failed", error);
                        this.dialogs.apply.loading = false;
                        this.dialogs.apply.errors = [error];
                    }.bind(this));

            },
            getApplicationJobTitle() {
                if (this.dialogs.apply.index !== null && this.project.team_roles[this.dialogs.apply.index] !== undefined) {
                    return this.project.team_roles[this.dialogs.apply.index].name;
                }
                return "..";
            },
            onClickMemberApplication(index) {
                console.log(this.tag+" clicked member application", index);
                console.log("-- aids", this.mutableApplications[index]);
                this.dialogs.application.index = index;
                this.dialogs.application.show = true;
            },
            onClickDenyApplication() {
                console.log(this.tag+" clicked deny application button");
                
                this.dialogs.application.operation = "deny";
                this.dialogs.application.loading = true;
                
                let payload = new FormData();
                payload.append("team_member_application_id", this.mutableApplications[this.dialogs.application.index].id);
                
                console.log(this.tag+" sending API request");
                this.axios.post(this.denyTeamMemberApplicationApiEndpoint, payload)
                    .then(function(response) {
                        console.log(this.tag+" request succeeded", response.data);
                        if (response.data.status === "success") {
                            console.log(this.tag+" operation succeeded");
                            this.mutableApplications[this.dialogs.application.index].accepted = false;
                            this.mutableApplications[this.dialogs.application.index].processed = true;
                            this.dialogs.application.loading = false;
                            this.dialogs.application.show = false;
                        } else {
                            console.warn(this.tag+" operation failed", response.data.error);
                            this.dialogs.application.errors = [response.data.error];
                            this.dialogs.application.loading = false;
                        }
                    }.bind(this))
                    .catch(function(error) {
                        console.warn(this.tag+" request failed", error);
                        this.dialogs.application.loading = false;
                        this.dialogs.application.errors = [error];
                    }.bind(this));
            },
            onClickAcceptApplication() {
                console.log(this.tag+" clicked accept application button");
                
                this.dialogs.application.operation = "accept";
                this.dialogs.application.loading = true;
                
                let payload = new FormData();
                payload.append("team_member_application_id", this.mutableApplications[this.dialogs.application.index].id);

                console.log(this.tag+" sending API request");
                this.axios.post(this.acceptTeamMemberApplicationApiEndpoint, payload)
                    .then(function(response) {
                        console.log(this.tag+" request succeeded", response.data);
                        if (response.data.status === "success") {
                            console.log(this.tag+" operation succeeded");
                            this.mutableApplications[this.dialogs.application.index].accepted = true;
                            this.mutableApplications[this.dialogs.application.index].processed = true;
                            this.dialogs.application.loading = false;
                            this.dialogs.application.show = false;
                        } else {
                            console.warn(this.tag+" operation failed", response.data.error);
                            this.dialogs.application.errors = [response.data.error];
                            this.dialogs.application.loading = false;
                        }
                    }.bind(this))
                    .catch(function(error) {
                        console.warn(this.tag+" request failed", error);
                        this.dialogs.application.loading = false;
                        this.dialogs.application.errors = [error];
                    }.bind(this));
            },
            getApplicationStatusClass(application) {
                if (application.processed) {
                    if (application.accepted) {
                        return "accepted";
                    } else {
                        return "denied";
                    }
                }
                return "open";
            },
            getApplicationStatusLabel(application) {
                if (application.processed) {
                    if (application.accepted) {
                        return "Geaccepteerd";
                    } else {
                        return "Afgewezen";
                    }
                }
                return "Open";
            },
            onClickEditApplication(index) {
                console.log(this.tag+" clicked edit button");

                if (this.dialogs.application.show) {
                    this.dialogs.application.show = false;
                    this.dialogs.edit_application.closed_view = true;
                }
                
                this.dialogs.edit_application.index = index;
                this.dialogs.edit_application.form.motivation = this.mutableApplications[index].motivation;
                this.dialogs.edit_application.show = true;

            },
            onClickConfirmEditApplication() {
                console.log(this.tag+" clicked confirm edit button");

                this.dialogs.edit_application.loading = true;
                this.dialogs.edit_application.errors = [];

                let payload = new FormData();
                payload.append("team_member_application_id", this.mutableApplications[this.dialogs.edit_application.index].id);
                payload.append("motivation", this.dialogs.edit_application.form.motivation);

                this.axios.post(this.updateTeamMemberApplicationApiEndpoint, payload)
                    .then(function(response) {
                        if (response.data.status === "success") {
                            this.mutableApplications[this.dialogs.edit_application.index].motivation = this.dialogs.edit_application.form.motivation;
                            this.dialogs.edit_application.show = false;
                            this.dialogs.edit_application.loading = false;
                            if (this.dialogs.edit_application.closed_view) {
                                this.dialogs.application.show = true;
                            }
                        } else {
                            this.dialogs.edit_application.loading = false;
                            this.dialogs.edit_application.errors [response.data.error];
                        }
                    }.bind(this))
                    .catch(function(error) {
                        this.dialogs.edit_application.loading = false;
                        this.dialogs.edit_application.errors = [error];
                    }.bind(this));

            },
            onClickDeleteApplication(index) {
                console.log(this.tag+" clicked delete button", index);

                if (this.dialogs.application.show) this.dialogs.application.show = false;
                
                this.dialogs.delete_application.index = index;
                this.dialogs.delete_application.show = true;
                
            },
            onClickConfirmDeleteApplication() {
                console.log(this.tag+" clicked confirm delete button");

                this.dialogs.delete_application.loading = true;
                this.dialogs.delete_application.errors = [];

                let payload = new FormData();
                payload.append("team_member_application_id", this.mutableApplications[this.dialogs.delete_application.index].id);

                this.axios.post(this.deleteTeamMemberApplicationApiEndpoint, payload)
                    .then(function(response) {
                        if (response.data.status === "success") {
                            this.mutableApplications.splice(this.dialogs.delete_application.index, 1);
                            this.dialogs.delete_application.loading = false;
                            this.dialogs.delete_application.show = false;
                        } else {
                            this.dialogs.delete_application.loading = false;
                            this.dialogs.delete_application.errors = [response.data.error];
                        }
                    }.bind(this))
                    .catch(function(error) {
                        this.dialogs.delete_application.errors = [error];
                        this.dialogs.delete_application.loading = true;
                    }.bind(this));
            },
            onClickUnassignMember(index) {
                console.log(this.tag+" clicked unassign member button", index);
                this.dialogs.unassign.index = index;
                this.dialogs.unassign.show = true;
            },
            onClickConfirmUnassignMember() {
                console.log(this.tag+" clicked confirm unassign member button");

                this.dialogs.unassign.loading = true;
                this.dialogs.unassign.errors = [];

                let payload = new FormData();
                payload.append("team_role_id", this.mutableRoles[this.dialogs.unassign.index].id);

                this.axios.post()


            }
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    #project-view {
        margin-top: -75px;
        #team {
            #team-roles {
                margin: 0 0 30px 0;
                .team-role__wrapper {
                    overflow: hidden;
                    border-radius: 3px;
                    margin: 0 0 30px 0;
                    background-color: hsl(0, 0%, 95%);
                    &:last-child {
                        margin: 0;
                    }
                    .team-role {
                        display: flex;
                        padding: 30px;
                        flex-direction: row;
                        box-sizing: border-box;
                        .team-role__avatar-wrapper {
                            flex: 0 0 120px;
                            margin: 0 30px 0 0;
                            .team-role__avatar {
                                width: 120px;
                                display: flex;
                                height: 120px;
                                font-size: .8em;
                                text-align: center;
                                border-radius: 60px;
                                flex-direction: row;
                                align-items: center;
                                justify-content: center;
                                color: hsl(0, 0%, 50%);
                                background-color: hsl(0, 0%, 100%);
                            }
                        }
                        .team-role__text-wrapper {
                            display: flex;
                            flex: 0 0 300px;
                            flex-direction: column;
                            justify-content: center;
                            .role-name {
                                font-size: 2em;
                                font-weight: 500;
                                margin: 0 0 5px 0;
                            }
                            .role-skills__wrapper {
                                .role-skills__label {
                                    font-size: .8em;
                                    margin: 0 0 5px 0;
                                    color: hsl(0, 0%, 0%);
                                }
                                .role-skills {
                                    display: flex;
                                    flex-direction: row;
                                    .role-skill {
                                        font-size: .8em;
                                        margin: 0 5px 0 0;
                                        border-radius: 2px;
                                        box-sizing: border-box;
                                        padding: 3px 3px 3px 5px;
                                        background-color: hsl(0, 0%, 100%);
                                    }
                                }
                                .role-member {
                                    
                                }
                            }
                        }
                        .team-role__description {
                            display: flex;
                            flex: 0 0 250px;
                            font-size: .8em;
                            margin: 0 50px 0 0;
                            flex-direction: row;
                            align-items: center;
                        }
                        .team-role__member {
                            flex: 1;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            .team-role__member-label {
                                font-size: .8em;
                                margin: -16px 0 5px 0;
                            }
                        }
                        .team-role__actions {
                            flex: 1;
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            justify-content: flex-end;
                        }
                    }
                    .team-role__footer {
                        padding: 15px 30px;
                        box-sizing: border-box;
                        background-color: hsl(0, 0%, 90%);
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        .team-role__footer-left {
                            flex: 1;
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                        }
                        .team-role__footer-right {
                            flex: 1;
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            justify-content: flex-end
                        }
                    }
                }
            }
        }
        #member-applications {
            #member-applications__list {
                border-radius: 3px;
                background-color: hsl(0, 0%, 95%);
                .member-application {
                    display: flex;
                    padding: 10px 15px;
                    flex-direction: row;
                    transition: all .3s;
                    box-sizing: border-box;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                    &:last-child {
                        border-bottom: 0;
                    }
                    &:hover {
                        cursor: pointer;
                        background-color: hsl(0, 0%, 90%);
                    }
                    .status-wrapper {
                        flex: 1;
                        margin: 0 15px 0 0;
                        .status {
                            font-size: .8em;
                            color: #ffffff;
                            border-radius: 3px;
                            text-align: center;
                            box-sizing: border-box;
                            padding: 3px 10px 5px 10px;
                            background-color: hsl(0, 0%, 15%);
                            &.denied {
                                background-color:hsl(0, 100%, 25%);
                            }
                            &.accepted {
                                background-color: hsl(132, 100%, 24%);
                            }
                        }
                    }
                    .role-name {
                        flex: 3;
                    }
                    .user-name {
                        flex: 2;
                        margin: 0 0 0 15px;
                    }
                    .created-at {
                        margin: 0 0 0 15px;
                        justify-content: flex-end;
                    }
                    .role-name, .user-name, .created-at {
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                    }
                }
            }
            #member-applications__empty {

            }
        }
    }
    #application-dialog-text {
        #role-name {
            text-align: center;
            #role-name__label {
                color: #737373;
                font-size: .85em;
                margin: 0 0 5px 0;
            }
            #role-name__text {
                font-size: 1.5em;
                font-weight: 500;
            }
        }
        #user-wrapper { 
            display: flex;
            margin: 15px 0;
            flex-direction: row;
            justify-content: center;
        }
        #motivation {
            text-align: center;
            #motivation-label {
                color: #737373;
                font-size: .85em;
                margin: 0 0 10px 0;
            }
            #motivation-text {
                padding: 10px;
                border-radius: 3px;
                box-sizing: border-box;
                background-color: hsl(0, 0%, 95%);
            }
        }
    }
</style>