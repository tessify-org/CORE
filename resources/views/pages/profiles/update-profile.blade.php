@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("profile.update", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Page title -->
            <h1 class="page-title centered">@lang("tessify-core::profiles.update_profile_title")</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <form action="{{ route('profile.update.post') }}" method="post" enctype="multipart/form-data">
                @csrf

                <update-profile-form
                    :user="{{ $user->toJson() }}"
                    :skills="{{ $skills->toJson() }}"
                    :assignment-types="{{ $assignmentTypes->toJson() }}"
                    :organizations="{{ $organizations->toJson() }}"
                    :organization-locations="{{ $organizationLocations->toJson() }}"
                    :departments="{{ $departments->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    annotation-text="@lang('tessify-core::profiles.update_profile_annotation')"
                    first-name-text="@lang('tessify-core::profiles.update_profile_first_name')"
                    last-name-text="@lang('tessify-core::profiles.update_profile_last_name')"
                    headline-text="@lang('tessify-core::profiles.update_profile_headline')"
                    email-text="@lang('tessify-core::profiles.update_profile_email')"
                    publicly-display-email-text="@lang('tessify-core::profiles.update_profile_publicly_display_email')"
                    phone-text="@lang('tessify-core::profiles.update_profile_phone')"
                    avatar-text="@lang('tessify-core::profiles.update_profile_avatar')"
                    assignments-text="@lang('tessify-core::profiles.update_profile_assignments')"
                    interests-text="@lang('tessify-core::profiles.update_profile_interests')"
                    back-href="{{ route('profile') }}"
                    back-text="@lang('tessify-core::profiles.update_profile_go_back')"
                    save-text="@lang('tessify-core::profiles.update_profile_save_changes')"
                    create-assignment-api-endpoint="{{ route('api.assignments.create.post') }}"
                    update-assignment-api-endpoint="{{ route('api.assignments.update.post') }}"
                    delete-assignment-api-endpoint="{{ route('api.assignments.delete.post') }}"
                    upload-avatar-api-endpoint="{{ route('api.profile.upload-avatar.post') }}"
                    upload-header-image-api-endpoint="{{ route('api.profile.upload-header-image.post') }}"
                    assignments-label-text="@lang('tessify-core::profiles.update_profile_assignments_label')"
                    assignments-no-records-text="@lang('tessify-core::profiles.update_profile_assignments_no_records')"
                    assignments-add-button-text="@lang('tessify-core::profiles.update_profile_assignments_add_button')"
                    assignments-form-title-text="@lang('tessify-core::profiles.update_profile_assignments_form_title')"
                    assignments-form-description-text="@lang('tessify-core::profiles.update_profile_assignments_form_description')"
                    assignments-form-type-text="@lang('tessify-core::profiles.update_profile_assignments_form_type')"
                    assignments-form-organization-text="@lang('tessify-core::profiles.update_profile_assignments_form_organization')"
                    assignments-form-department-text="@lang('tessify-core::profiles.update_profile_assignments_form_department')"
                    assignments-form-location-text="@lang('tessify-core::profiles.update_profile_assignments_form_location')"
                    assignments-form-current-function-text="@lang('tessify-core::profiles.update_profile_assignments_form_current_function')"
                    assignments-form-start-date-text="@lang('tessify-core::profiles.update_profile_assignments_form_start_date')"
                    assignments-form-present-text="@lang('tessify-core::profiles.update_profile_assignments_form_present')"
                    assignments-form-end-date-text="@lang('tessify-core::profiles.update_profile_assignments_form_end_date')"
                    assignments-form-until-present-text="@lang('tessify-core::profiles.update_profile_assignments_form_until_present')"
                    assignments-create-dialog-title-text="@lang('tessify-core::profiles.update_profile_assignments_create_dialog_title')"
                    assignments-create-dialog-cancel-text="@lang('tessify-core::profiles.update_profile_assignments_create_dialog_cancel')"
                    assignments-create-dialog-submit-text="@lang('tessify-core::profiles.update_profile_assignments_create_dialog_submit')"
                    assignments-view-dialog-title-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_title')"
                    assignments-view-dialog-ministry-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_ministry')"
                    assignments-view-dialog-organization-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_organization')"
                    assignments-view-dialog-department-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_department')"
                    assignments-view-dialog-location-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_location')"
                    assignments-view-dialog-assignment-type-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_assignment_type')"
                    assignments-view-dialog-function-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_function')"
                    assignments-view-dialog-duration-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_duration')"
                    assignments-view-dialog-description-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_description')"
                    assignments-view-dialog-edit-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_edit')"
                    assignments-view-dialog-delete-text="@lang('tessify-core::profiles.update_profile_assignments_view_dialog_delete')"
                    assignments-update-dialog-title-text="@lang('tessify-core::profiles.update_profile_assignments_update_dialog_title')"
                    assignments-update-dialog-cancel-text="@lang('tessify-core::profiles.update_profile_assignments_update_dialog_cancel')"
                    assignments-update-dialog-submit-text="@lang('tessify-core::profiles.update_profile_assignments_update_dialog_submit')"
                    assignments-delete-dialog-title-text="@lang('tessify-core::profiles.update_profile_assignments_delete_dialog_title')"
                    assignments-delete-dialog-text="@lang('tessify-core::profiles.update_profile_assignments_delete_dialog_text')"
                    assignments-delete-dialog-cancel-text="@lang('tessify-core::profiles.update_profile_assignments_delete_dialog_cancel')"
                    assignments-delete-dialog-submit-text="@lang('tessify-core::profiles.update_profile_assignments_delete_dialog_submit')"
                    skills-label-text="@lang('tessify-core::profiles.update_profile_skills_label')"
                    skills-no-records-text="@lang('tessify-core::profiles.update_profile_skills_no_records')"
                    skills-add-button-text="@lang('tessify-core::profiles.update_profile_skills_add_button')"
                    skills-form-skill-text="@lang('tessify-core::profiles.update_profile_skills_form_skill')"
                    skills-form-mastery-text="@lang('tessify-core::profiles.update_profile_skills_form_mastery')"
                    skills-form-description-text="@lang('tessify-core::profiles.update_profile_skills_form_description')"
                    skills-view-dialog-title-text="@lang('tessify-core::profiles.update_profile_skills_view_dialog_title')"
                    skills-view-dialog-skill-text="@lang('tessify-core::profiles.update_profile_skills_view_dialog_skill')"
                    skills-view-dialog-mastery-text="@lang('tessify-core::profiles.update_profile_skills_view_dialog_mastery')"
                    skills-view-dialog-description-text="@lang('tessify-core::profiles.update_profile_skills_view_dialog_description')"
                    skills-view-dialog-edit-text="@lang('tessify-core::profiles.update_profile_skills_view_dialog_edit')"
                    skills-view-dialog-delete-text="@lang('tessify-core::profiles.update_profile_skills_view_dialog_delete')"
                    skills-create-dialog-title-text="@lang('tessify-core::profiles.update_profile_skills_create_dialog_title')"
                    skills-create-dialog-cancel-text="@lang('tessify-core::profiles.update_profile_skills_create_dialog_cancel')"
                    skills-create-dialog-submit-text="@lang('tessify-core::profiles.update_profile_skills_create_dialog_submit')"
                    skills-update-dialog-title-text="@lang('tessify-core::profiles.update_profile_skills_update_dialog_title')"
                    skills-update-dialog-cancel-text="@lang('tessify-core::profiles.update_profile_skills_update_dialog_cancel')"
                    skills-update-dialog-submit-text="@lang('tessify-core::profiles.update_profile_skills_update_dialog_submit')"
                    skills-delete-dialog-title-text="@lang('tessify-core::profiles.update_profile_skills_delete_dialog_title')"
                    skills-delete-dialog-text="@lang('tessify-core::profiles.update_profile_skills_delete_dialog_text')"
                    skills-delete-dialog-cancel-text="@lang('tessify-core::profiles.update_profile_skills_delete_dialog_cancel')"
                    skills-delete-dialog-submit-text="@lang('tessify-core::profiles.update_profile_skills_delete_dialog_submit')">
                </update-profile-form>

            </form>

        </div>
    </div>
@stop