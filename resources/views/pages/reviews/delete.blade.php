@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("reviews.delete", $review) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::reviews.delete_title")</h1>

            <!-- Form -->
            <form action="{{ route('reviews.delete.post', $review->uuid) }}" method="post">
                @csrf

                <!-- Delete dialog -->
                <div id="delete-dialog" class="elevation-1">
                    <div id="delete-dialog__text">
                        {!! nl2br(__('tessify-core::reviews.delete_text')) !!}
                    </div>
                    <div id="delete-dialog__actions">
                        <div id="delete-dialog__actions-left">
                            <v-btn href="{{ route('reviews.view', $review->uuid) }}" outlined>
                                <i class="fas fa-arrow-left"></i>
                                @lang("tessify-core::reviews.delete_cancel")
                            </v-btn>
                        </div>
                        <div id="delete-dialog__actions-right">
                            <v-btn type="submit" color="red" dark depressed>
                                <i class="fas fa-trash-alt"></i>
                                @lang("tessify-core::reviews.delete_submit")
                            </v-btn>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
@stop
