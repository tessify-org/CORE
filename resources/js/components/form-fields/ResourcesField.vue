<template>
    <div class="resources-field">
        
        <!-- Label --> 
        <div class="resources-field__label">{{ labelText }}</div>

        <!-- Files -->
        <div class="resources-field__files" v-if="mutableResources.length > 0">
            <div class="file" v-for="(resource, ri) in mutableResources" :key="ri">
                <div class="file-icon">
                    <i class="far fa-file"></i>
                </div>
                <div class="file-title">
                    {{ resource.title }}
                </div>
                <div class="file-size">
                    {{ resource.file_size }} kb
                </div>
                <div class="file-actions">
                    <div class="file-action edit" @click="onClickEdit(ri)">
                        <i class="fas fa-pen-square"></i>
                    </div>
                    <div class="file-action delete" @click="onClickDelete(ri)">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- No files -->
        <div class="resources-field__no-files" v-if="mutableResources.length === 0">
            Er zijn nog geen resources toegevoegd.
        </div>

        <!-- Actions -->
        <div class="resources-field__actions">
            <v-btn depressed small color="primary" @click="onClickAdd">
                <i class="fas fa-plus"></i>
                Resource toevoegen
            </v-btn>
        </div>

        <!-- Add resource dialog -->
        <v-dialog v-model="dialogs.add.show" width="500">
            <div class="dialog">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.add.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Aanstelling toevoegen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.add.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.add.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Title -->
                    <div class="form-field">
                        <v-text-field
                            label="Titel"
                            v-model="dialogs.add.form.title">
                        </v-text-field>
                    </div>
                    <!-- Description -->
                    <div class="form-field">
                        <v-textarea
                            label="Beschrijving"
                            v-model="dialogs.add.form.description">
                        </v-textarea>
                    </div>
                    <!-- File -->
                    <div class="file-field">
                        <div class="file-field__label">Bestand:</div>
                        <div class="file-field__input">
                            <input type="file" @change="addFileChanged($event)">
                        </div>
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
                            :loading="dialogs.add.loading" 
                            :disabled="confirmAddDisabled">
                            <i class="far fa-save"></i>
                            Opslaan
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Update resource dialog -->
        <v-dialog v-model="dialogs.edit.show" width="500">
            <div class="dialog" v-if="dialogs.edit.index !== null">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.edit.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Aanstelling aanpassen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.edit.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.edit.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Title -->
                    <div class="form-field">
                        <v-text-field
                            label="Titel"
                            v-model="dialogs.edit.form.title">
                        </v-text-field>
                    </div>
                    <!-- Description -->
                    <div class="form-field">
                        <v-textarea
                            label="Beschrijving"
                            v-model="dialogs.edit.form.description">
                        </v-textarea>
                    </div>
                    <!-- File -->
                    <div class="file-field">
                        <div class="file-field__label">Bestand:</div>
                        <div class="file-field__input">
                            <input type="file" @change="editFileChanged($event)">
                        </div>
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
                            :loading="dialogs.edit.loading" 
                            :disabled="confirmEditDisabled">
                            <i class="far fa-save"></i>
                            Opslaan
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>

        <!-- Delete resource dialog -->
        <v-dialog v-model="dialogs.delete.show" width="500">
            <div class="dialog" v-if="dialogs.delete.index !== null">
                <!-- Close button -->
                <div class="dialog__close-button" @click="dialogs.delete.show = false">
                    <i class="fas fa-times"></i>
                </div>
                <!-- Content -->
                <div class="dialog-content">
                    <!-- Title -->
                    <h3 class="dialog-title">Aanstelling verwijderen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.delete.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.delete.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Text -->
                    <div class="dialog-text">
                        Weet je zeker dat je deze aanstelling wilt verwijderen?
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
                            @click="onClickConfirmDelete" 
                            :loading="dialogs.delete.loading">
                            <i class="fas fa-trash-alt"></i>
                            Ja, verwijder
                        </v-btn>
                    </div>
                </div>
            </div>
        </v-dialog>        

        <!-- Hidden input -->
        <input type="hidden" :name="name" :value="encodedMutableResourceIds">

    </div>
</template>

<script>
    export default {
        props: [
            "name",
            "label",
            "value",
            "errors",
            "createApiEndpoint",
            "updateApiEndpoint",
            "deleteApiEndpoint",
        ],
        data: () => ({
            tag: "[resources-field]",
            loaded: false,
            mutableResources: [],
            dialogs: {
                add: {
                    show: false,
                    loading: false,
                    errors: [],
                    form: {
                        title: "",
                        description: "",
                        file: null,
                    }
                },
                edit: {
                    show: false,
                    loading: false,
                    index: null,
                    errors: [],
                    form: {
                        title: "",
                        description: "",
                        file: null,
                    }
                },
                delete: {
                    show: false,
                    loading: false,
                    index: null,
                    errors: [],
                },
            }
        }),
        computed: {
            labelText() {
                return this.label !== undefined && this.label !== null && this.label !== "" ? this.label : "Resources";
            },
            encodedMutableResourceIds() {
                let out = [];
                for (let i = 0; i < this.mutableResources.length; i++) {
                    out.push(this.mutableResources[i].id);
                }
                return JSON.stringify(out);
            },
            confirmAddDisabled() {
                return this.dialogs.add.form.title === "" || this.dialogs.add.form.file === null;
            },
            confirmEditDisabled() {
                return this.dialogs.edit.form.title === "";
            },
        },
        watch: {
            value() {
                if (!this.loaded) {
                    this.mutableResources = this.value;
                    this.loaded = true;
                }
            },
            mutableResources: {
                deep: true,
                handler: function() {
                    this.$emit("input", this.mutableResources);
                }
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" name: ", this.name);
                console.log(this.tag+" label: ", this.label);
                console.log(this.tag+" value: ", this.value);
                console.log(this.tag+" create api endpoint: ", this.createApiEndpoint);
                console.log(this.tag+" update api endpoint: ", this.updateApiEndpoint);
                console.log(this.tag+" delete api endpoint: ", this.deleteApiEndpoint);
                this.initializeData();
            },
            initializeData() {
                if (this.value !== undefined && this.value !== null && this.value.length > 0) {
                    this.mutableResources = this.value;
                    this.loaded = true;
                }
            },
            onClickAdd() {
                console.log(this.tag+" clicked add resource button");
                this.dialogs.add.show = true;
            },
            onClickConfirmAdd() {
                console.log(this.tag+" clicked confirm add resource button");

                // Turn on loading for the form
                this.dialogs.add.loading = true;

                // Compose the payload we'll be sending to the API endpoint
                let payload = new FormData();
                payload.append("title", this.dialogs.add.form.title);
                payload.append("description", this.dialogs.add.form.description);
                payload.append("file", this.dialogs.add.form.file);

                // Compose the headers we'll be sending along with the request
                let headers = { headers: { 'Content-Type': 'multipart/form-data' } };

                // Make the API request
                this.axios.post(this.createApiEndpoint, payload, headers)
                    // If the request succeeds
                    .then(function(response) {
                        // If the backend operation succeeds
                        if (response.data.status === "success") {
                            // Add the resource to the mutable resources list
                            this.mutableResources.push(response.data.resource);
                            // Turn off loading
                            this.dialogs.add.loading = false;
                            // Close the dialog
                            this.dialogs.add.show = false;
                            // Reset the form
                            this.dialogs.add.form.title = "";
                            this.dialogs.add.form.description = "";
                            this.dialogs.add.form.file = null;
                        // If the backend operation fails
                        } else {
                            this.dialogs.add.loading = false;
                            this.dialogs.add.errors = [response.data.error];
                        }
                    }.bind(this))
                    // If the request fails
                    .catch(function(error) {
                        console.warn(this.tag+" failed to make API request (create)", error);
                        this.dialogs.add.loading = false;
                        this.dialogs.add.errors = ["API request failed"];
                    }.bind(this));

            },
            onClickEdit(index) {
                console.log(this.tag+" clicked edit resource button", index);
                this.dialogs.edit.index = index;
                this.dialogs.edit.form.title = this.mutableResources[index].title;
                this.dialogs.edit.form.description = this.mutableResources[index].description;
                this.dialogs.edit.show = true;
            },
            onClickConfirmEdit() {
                console.log(this.tag+" clicked confirm edit resource button", this.mutableResources[this.dialogs.edit.index].id);

                // Turn on loading for the form
                this.dialogs.edit.loading = true;

                // Compose the payload we'll be sending to the API endpoint
                let payload = new FormData();
                payload.append("job_resource_id", this.mutableResources[this.dialogs.edit.index].id);
                payload.append("title", this.dialogs.edit.form.title);
                payload.append("description", this.dialogs.edit.form.description);
                if (this.dialogs.edit.form.file !== null) {
                    payload.append("file", this.dialogs.edit.form.file);
                }

                // Compose the headers we'll be sending along with the request
                let headers = { headers: { 'Content-Type': 'multipart/form-data' } };

                // Make the API request
                this.axios.post(this.updateApiEndpoint, payload, headers)
                    // If the request succeeds
                    .then(function(response) {
                        // If the backend operation succeeds
                        if (response.data.status === "success") {
                            // Replace the mutable resource we just updated
                            this.mutableResources[this.dialogs.edit.index] = response.data.resource;
                            // Turn off loading
                            this.dialogs.edit.loading = false;
                            // Close the dialog
                            this.dialogs.edit.show = false;
                        // If the backend operation fails
                        } else {
                            this.dialogs.edit.loading = false;
                            this.dialogs.edit.errors = [response.data.error];
                        }
                    }.bind(this))
                    // If the request fails
                    .catch(function(error) {
                        console.warn(this.tag+" failed to make API request (edit)", error);
                        this.dialogs.edit.loading = false;
                        this.dialogs.edit.errors = ["API request failed"];
                    }.bind(this));

            },
            onClickDelete(index) {
                console.log(this.tag+" clicked delete resource button", index);
                this.dialogs.delete.index = index;
                this.dialogs.delete.show = true;
            },
            onClickConfirmDelete() {
                console.log(this.tag+" clicked confirm delete resource button");

                // Turn on loading
                this.dialogs.delete.loading = true;

                // Compose the payload we'll be sending to the API endpoint
                let payload = new FormData();
                payload.append("job_resource_id", this.mutableResources[this.dialogs.delete.index].id);

                // Make the API request
                this.axios.post(this.deleteApiEndpoint, payload)
                    // If the request succeeds
                    .then(function(response) {
                        // If the backend operation succeeds
                        if (response.data.status === "success") {
                            // Replace the mutable resource we just updated
                            this.mutableResources.splice(this.dialogs.delete.index, 1);
                            // Turn off loading
                            this.dialogs.delete.loading = false;
                            // Close the dialog
                            this.dialogs.delete.show = false;
                        // If the backend operation fails
                        } else {
                            this.dialogs.delete.loading = false;
                            this.dialogs.delete.errors = [response.data.error];
                        }
                    }.bind(this))
                    // If the request fails
                    .catch(function(error) {
                        console.warn(this.tag+" failed to make API request (delete)", error);
                        this.dialogs.delete.loading = false;
                        this.dialogs.delete.errors = ["API request failed"];
                    }.bind(this));

            },
            addFileChanged(event) {
                console.log(this.tag+" add form file changed: ", event);
                this.dialogs.add.form.file = event.target.files[0];
            },
            editFileChanged(event) {
                console.log(this.tag+" update form file changed: ", event);
                this.dialogs.edit.form.file = event.target.files[0];
            },
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    .resources-field {
        .resources-field__label {
            color: #737373;
            font-size: .85em;
            margin: 0 0 10px 0;
        }
        .resources-field__files {
            background-color: hsl(0, 0%, 95%);
            .file {
                display: flex;
                padding: 10px 15px;
                flex-direction: row;
                box-sizing: border-box;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                &:last-child {
                    border-bottom: 0;
                }
                .file-icon {
                    margin: 0 15px 0 0;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
                .file-title {
                    flex: 1;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
                .file-size {
                    display: flex;
                    margin: 0 15px 0 0;
                    flex-direction: row;
                    align-items: center;
                }
                .file-actions {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    .file-action {
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
        .resources-field__no-files {
            padding: 15px;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: hsl(0, 0%, 95%);
        }
        .resources-field__actions {
            display: flex;
            margin: 15px 0 0 0;
            flex-direction: row;
            justify-content: flex-end;
        }
    }
</style>