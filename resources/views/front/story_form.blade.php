@extends('front.layouts.master')
@section('title', __('app.my_works'))

@section('content')
<div class="container pt-5">
    {!! Form::open(['method' => 'post', 'class' => 'row', 'id' => 'storyForm', 'files' => true]) !!}
        <div class="col-sm-3">
            <div class="thumbnail thumbnail-md bg-light border rounded d-flex"
                @if ($story->cover_image)
                style="background-size: cover; background-image: url({{ get_story_cover($story, 1) }})"
                @endif
            >
                <div class="dropdown mx-auto my-auto">
                    <button class="btn" data-toggle="dropdown" type="button">
                        <i class="fa fa-image fa-2x"></i>
                    </button>
                    <div class="dropdown-menu">
                        <label for="storyCover" class="dropdown-item">@lang('app.upload_cover')</label>
                    </div>
                    {!! Form::file('story_cover', ['id' => 'storyCover', 'hidden']) !!}
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="card card-simple-header">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#storyDetails">@lang('app.story_details')</a>
                        </li>
                        @if ($is_edit)
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tableOfContents">@lang('app.table_of_contents')</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="storyDetails">
                        <div class="card-body">
                            <div class="form-group">
                                {!! Form::label('title', __('app.title')) !!}
                                {!! Form::text('story_title', $story->title, [
                                    'class' => 'form-control',
                                    'id' => 'title',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('storySummary', __('app.summary')) !!}
                                {!! Form::textarea('story_summary', $story->summary, [
                                    'class' => 'form-control',
                                    'id' => 'storySummary',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('tags', __('app.tags')) !!}
                                {!! Form::text('story_tags', $story->tags, [
                                    'class' => 'form-control',
                                    'id' => 'tags',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('genre', __('app.genre')) !!}
                                {!! Form::select('story_genre', $categories->pluck('name', 'id'), $story->genre, [
                                    'class' => 'custom-select',
                                    'id' => 'genre',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-control-reverse custom-switch">
                                {!! Form::checkbox('story_rating', $story->is_mature, false, [
                                    'class' => 'custom-control-input',
                                    'id' => 'rating',
                                ]) !!}
                                {!! Form::label('rating', __('app.mature'), ['class' => 'custom-control-label']) !!}
                                </div>
                            </div>
                            @if ($is_edit)
                            <div class="form-group">
                                <div class="custom-control custom-control-reverse custom-switch">
                                {!! Form::checkbox('story_completed', $story->is_complete, false, [
                                    'class' => 'custom-control-input',
                                    'id' => 'completed',
                                ]) !!}
                                {!! Form::label('completed', __('app.completed'), ['class' => 'custom-control-label']) !!}
                                </div>
                            </div>
                            @endif
                            <div class="form-group border-top pt-3">
                                {!! Form::button(__('app.save'), ['class' => 'btn btn-primary mr-3', 'type' => 'submit']) !!}
                                <a class="btn btn-warning" type="button" href="{{ route('works') }}">@lang('app.cancel')</a>
                            </div>
                        </div>
                    </div>
                    @if ($is_edit)
                    <div class="tab-pane fade" id="tableOfContents">
                        <div class="border-top">
                            <button type="button" class="btn btn-primary btn-sm on-create-chapter my-2 ml-3" data-url="{{ route('chapter_create', [
                                'story' => $story->id
                            ]) }}">
                                @lang('app.new_chapter')
                            </button>
                        </div>
                        <div class="list-group list-group-flush">
                                @foreach ($story->chapters as $chapter)
                                    @include('front.items.work_chapter', ['chapter' => $chapter])
                                @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection
