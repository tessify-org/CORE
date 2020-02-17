<template>
    <div class="comments">

        <!-- Title -->
        <div class="comments__title">{{ titleText }}</div>

        <!-- Comments list -->
        <div class="comments__list" v-if="paginatedComments.length > 0">
            <div class="comment-wrapper" v-for="(comment, ci) in paginatedComments" :key="ci">
                <div class="comment">
                    {{ comment.body }}
                </div>
                <div class="comment-footer">
                    <div class="comment-footer__left">
                        <div class="comment-author">
                            <div class="comment-author__avatar" :style="{ backgroundImage: 'url('+comment.user.avatar_url+')' }"></div>
                            <div class="comment-author__text">
                                {{ comment.user.formatted_name }}
                            </div>
                        </div>
                    </div>
                    <div class="comment-footer__right">
                        <div class="comment-actions" v-if="belongsToUser(comment)">
                            <div class="comment-action edit" @click="onClickEdit(comment)">
                                <i class="fas fa-pen-square"></i>
                            </div>
                            <div class="comment-action delete" @click="onClickDelete(comment)">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                        </div>
                        <div class="comment-created-at">
                            {{ comment.formatted_created_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- No comments -->
        <div class="comments__empty" v-if="paginatedComments.length === 0">
            Er is nog geen commentaar geplaatst.
        </div>

        <!-- Pagination -->
        <div class="comments__pagination" v-if="numPaginatedPages > 1">
            <v-pagination total-visible="9" v-model="pagination.currentPage" :length="numPaginatedPages"></v-pagination>
        </div>

        <!-- Post comment form -->
        <div class="comments__form">

            <!-- Label -->
            <div class="comments__form-label">Plaats commentaar</div>
            
            <!-- Errors -->
            <div class="comments__form-errors" v-if="form.errors.length > 0">
                <div class="form-error" v-for="(error, ei) in form.errors" :key="ei">
                    {{ error }}
                </div>
            </div>
            
            <!-- Input -->
            <div class="form-field">
                <v-textarea
                    :loading="form.loading"
                    v-model="form.comment"
                    maxlength="255" 
                    auto-grow 
                    rows="3"
                    counter>
                </v-textarea>
            </div>

            <!-- Actions -->
            <div class="comments__form-actions">
                <v-btn 
                    color="primary" 
                    @click="onClickPost" 
                    :loading="form.loading" 
                    :disabled="submitCommentDisabled">
                    Plaats commentaar
                </v-btn>
            </div>

        </div>

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
                    <h3 class="dialog-title">Comment aanpassen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.edit.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.edit.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Comment -->
                    <div class="form-field">
                        <v-textarea
                            :loading="dialogs.edit.loading"
                            v-model="dialogs.edit.form.comment"
                            maxlength="255" counter
                            auto-grow rows="3">
                        </v-textarea>
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
                    <h3 class="dialog-title">Commentaar verwijderen</h3>
                    <!-- Errors -->
                    <div class="dialog-errors" v-if="dialogs.delete.errors.length > 0">
                        <div class="dialog-error" v-for="(error, ei) in dialogs.delete.errors" :key="ei">
                            {{ error }}
                        </div>
                    </div>
                    <!-- Text -->
                    <div class="dialog-text">
                        Weet je zeker dat je dit commentaar wilt verwijderen?
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
                            :loading="dialogs.delete.loading"
                            @click="onClickConfirmDelete">
                            <i class="fas fa-trash-alt"></i>
                            Ja, verwijder
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
            "user",
            "comments",
            "targetId",
            "targetType",
            "createCommentApiEndpoint",
            "updateCommentApiEndpoint",
            "deleteCommentApiEndpoint",
            "perPage"
        ],
        data: () => ({
            tag: "[comments]",
            mutableComments: [],
            paginatedComments: [],
            pagination: {
                perPage: 5,
                currentPage: 1
            },
            form: {
                loading: false,
                errors: [],
                comment: "",
            },
            dialogs: {
                edit: {
                    show: false,
                    index: null,
                    comment: null,
                    loading: false,
                    errors: [],
                    form: {
                        comment: "",
                    }
                },
                delete: {
                    show: false,
                    index: null,
                    errors: [],
                    comment: null,
                    loading: false,
                }
            }
        }),
        computed: {
            hasUser() {
                return this.user !== undefined && this.user !== null && this.user !== "";
            },
            titleText() {
                return this.title !== undefined && this.title !== null && this.title !== "" ? this.title : "Commentaar";
            },
            submitCommentDisabled() {
                return this.form.comment === "";
            },
            numPaginatedPages() {
                return Math.ceil(this.mutableComments.length / this.pagination.perPage);
            },
            paginationPerPage() {
                if (this.perPage !== undefined && this.perPage !== null && parseInt(this.perPage) > 0) {
                    return parseInt(this.perPage);
                } else {
                    this.pagination.perPage;
                }
            },
            confirmEditDisabled() {
                return this.dialogs.edit.form.comment === "";
            },
        },
        watch: {
            "pagination.currentPage": function() {
                this.paginateComments();
            },
        },
        methods: {
            initialize() {
                console.log(this.tag+" initializing");
                console.log(this.tag+" user: ", this.user);
                console.log(this.tag+" comments: ", this.comments);
                console.log(this.tag+" target id: ", this.targetId);
                console.log(this.tag+" target type: ", this.targetType);
                console.log(this.tag+" create comment api endpoint: ", this.createCommentApiEndpoint);
                console.log(this.tag+" update comment api endpoint: ", this.updateCommentApiEndpoint);
                console.log(this.tag+" delete comment api endpoint: ", this.deleteCommentApiEndpoint);
                this.initializeData();
            },
            initializeData() {
                if (this.comments !== undefined && this.comments !== null && this.comments.length > 0) {
                    for (let i = 0; i < this.comments.length; i++) {
                        this.mutableComments.push(this.comments[i]);
                    }
                }
                this.paginateComments();
            },
            paginateComments() {
                let start_at = (this.pagination.currentPage - 1) * this.paginationPerPage;
                let stop_at = start_at + this.paginationPerPage;
                this.paginatedComments = this.mutableComments.slice(start_at, stop_at);
                if (this.pagination.currentPage > this.numPaginatedPages) {
                    this.pagination.currentPage = 1;
                }
            },
            onClickPost() {
                console.log(this.tag+" clicked submit comment button");
                
                this.form.loading = true;
                this.form.errors = [];

                let payload = new FormData();
                payload.append("target_type", this.targetType);
                payload.append("target_id", this.targetId);
                payload.append("comment", this.form.comment);

                this.axios.post(this.createCommentApiEndpoint, payload)
                    .then(function(response) {
                        console.log(this.tag+" request succeeded", response);
                        if (response.data.status === "success") {
                            console.log(this.tag+" operation succeeded: ", response.data.comment);
                            this.mutableComments.unshift(response.data.comment);
                            this.paginateComments();
                            this.form.loading = false;
                            this.form.comment = "";
                        } else {
                            console.warn(this.tag+" operation failed: ", response.data.error);
                            this.form.loading = false;
                            this.form.errors = [response.data.error];
                        }
                    }.bind(this))
                    .catch(function(error) {
                        console.warn(this.tag+" request failed", error);
                        this.form.loading = false;
                        this.form.errors = [error];
                    }.bind(this));

            },
            onClickEdit(comment) {
                console.log(this.tag+" clicked edit button", comment);
                
                let mutableIndex = null;
                for (let i = 0; i < this.mutableComments.length; i++) {
                    if (this.mutableComments[i].id === comment.id) {
                        this.dialogs.edit.index = i;
                        this.dialogs.edit.comment = comment;
                        this.dialogs.edit.form.comment = comment.body;
                        break;
                    }
                }

                this.dialogs.edit.show = true;

            },
            onClickConfirmEdit() {
                console.log(this.tag+" clicked confirm edit button");

                this.dialogs.edit.loading = true;

                let payload = new FormData();
                payload.append("comment_id", this.dialogs.edit.comment.id);
                payload.append("comment", this.dialogs.edit.form.comment);

                this.axios.post(this.updateCommentApiEndpoint, payload)
                    .then(function(response) {
                        console.log(this.tag+" request succeeded", response.data);
                        if (response.data.status === "success") {
                            console.log(this.tag+" operation succeeded");
                            this.mutableComments[this.dialogs.edit.index].body = this.dialogs.edit.form.comment;
                            this.dialogs.edit.loading = false;
                            this.dialogs.edit.show = false;
                        } else {
                            console.warn(this.tag+" operation failed", response.data.error);
                            this.dialogs.edit.loading = false;
                            this.dialogs.edit.errors = [response.data.error];
                        }
                    }.bind(this))
                    .catch(function(error) {
                        console.warn(this.tag+" request failed", error);
                        this.dialogs.edit.loading = false;
                        this.dialogs.edit.errors = [error];
                    }.bind(this));

            },
            onClickDelete(comment) {
                console.log(this.tag+" clicked delete button", comment);

                for (let i = 0; i < this.mutableComments.length; i++) {
                    if (this.mutableComments[i].id === comment.id) {
                        this.dialogs.delete.index = i;
                        this.dialogs.delete.comment = comment;
                        break;
                    }
                }

                this.dialogs.delete.show = true;

            },
            onClickConfirmDelete() {
                console.log(this.tag+" clicked confirm delete button");

                this.dialogs.delete.loading = true;

                let payload = new FormData();
                payload.append("comment_id", this.dialogs.delete.comment.id);

                this.axios.post(this.deleteCommentApiEndpoint, payload)
                    .then(function(response) {
                        console.log(this.tag+" request succeeded: ", response);
                        if (response.data.status === "success") {
                            console.log(this.tag+" operation succeeeded");
                            this.mutableComments.splice(this.dialogs.delete.index, 1);
                            this.paginateComments();
                            this.dialogs.delete.loading = false;
                            this.dialogs.delete.show = false;
                        } else {
                            console.warn(this.tag+" operation failed", response.data.error);
                            this.dialogs.delete.loading = false;
                            this.dialogs.delete.errors = [response.data.error];
                        }

                    }.bind(this))
                    .catch(function(error) {
                        console.warn(this.tag+" request failed: ", error);
                        this.dialogs.delete.loading = false;
                        this.dialogs.delete.errors = [error];
                    }.bind(this));

            },
            belongsToUser(comment) {
                return this.hasUser && this.user.id === comment.user.id;
            },
        },
        mounted() {
            this.initialize();
        }
    }
</script>

<style lang="scss">
    .comments {
        .comments__title {
            font-size: 1.4em;
            font-weight: 500;
            line-height: 1em;
            margin: 0 0 15px 0;
            padding: 0 0 8px 0;
            box-sizing: border-box;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }
        .comments__list {
            .comment-wrapper {
                margin: 0 0 15px 0;
                &:last-child {
                    margin: 0;
                }
                .comment {
                    padding: 20px;
                    font-size: .9em;
                    border-radius: 3px;
                    box-sizing: border-box;
                    background-color: hsl(0, 0%, 95%);
                }
                .comment-footer {
                    display: flex;
                    margin: 10px 0 0 0;
                    flex-direction: row;
                    .comment-footer__left {
                        flex: 1;
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        .comment-author {
                            display: flex;
                            flex-direction: row;
                            .comment-author__avatar {
                                width: 24px;
                                height: 24px;
                                margin: 0 10px 0 0;
                                border-radius: 12px;
                                background-size: cover;
                                background-repeat: no-repeat;
                                background-position: center center;
                            }
                            .comment-author__text {
                                display: flex;
                                font-size: .9em;
                                flex-direction: row;
                                align-items: center;
                            }
                        }
                    }
                    .comment-footer__right {
                        flex: 1;
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        justify-content: flex-end;
                        .comment-actions {
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            margin: 0 15px 0 0;
                            .comment-action {
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
                        .comment-created-at {
                            font-size: .9em;
                        }
                    }
                }
            }
        }
        .comments__empty {
            padding: 15px;
            box-sizing: border-box;
            background-color: hsl(0, 0%, 95%);
        }
        .comments__pagination {
            display: flex;
            margin: 30px 0 0 0;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
        .comments__form {
            margin: 30px 0 0 0;
            .comments__form-label {
                font-size: 1.4em;
                font-weight: 500;
                line-height: 1em;
                margin: 0 0 10px 0;
                padding: 0 0 8px 0;
                box-sizing: border-box;
                border-bottom: 2px solid rgba(0, 0, 0, 0.1);
            }
            .comments__form-errors {
                display: flex;
                margin: 0 0 10px 0;
                flex-direction: row;
                .form-error {
                    color: hsl(0, 79%, 43%);
                    margin: 0 0 5px 0;
                    &:last-child {
                        margin: 0;
                    }
                }
            }
            .form-field {
                margin: 0;
            }
            .comments__form-actions {
                display: flex;
                margin: 15px 0 0 0;
                flex-direction: row;
                align-items: center;
                justify-content: flex-end;
            }
        }
    }
</style>