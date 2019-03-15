@extends('front.layouts.master')
@section('title', __('app.my_works'))

@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-truncated">
                    <a href="{{ route('story_edit', ['id' => $story->id]) }}">
                        <i class="fa fa-angle-left"></i>
                        {{ $story->title }}</a>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ($story->chapters as $_chapter)
                    <a class="list-group-item{{ $chapter->id == $_chapter->id ? ' font-weight-bold' : '' }}" href="{{ route('chapter_write', [
                        'story_id' => $story->id,
                        'chapter_id' => $_chapter->id
                    ]) }}">
                        {{ $_chapter->title }}
                    </a>
                    @endforeach
                </div>
                <div class="card-body text-right">
                    <button class="btn btn-primary btn-sm on-create-chapter" data-url="{{ route('chapter_create', [
                        'story' => $story->id
                    ]) }}">
                        @lang('app.new_chapter')
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'id' => 'chapterForm']) !!}
                    <div class="form-group">
                        {!! Form::label('title', __('app.title')) !!}
                        {!! Form::text('chapter_title', $chapter->title, ['class' => 'form-control', 'id' => 'title'])
                        !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('content', __('app.content')) !!}
                        {!! Form::textarea('chapter_content', $chapter->content, ['class' => 'form-control', 'id' =>
                        'content']) !!}
                    </div>
                    <div class="form-group text-right">
                        <a class="btn btn-warning mr-3" href="{{ route('story_edit', ['id' => $story->id]) }}">
                            @lang('app.cancel')
                        </a>
                        <button type="submit" class="btn btn-primary mr-3 on-save-chapter" data-publish="1">@lang('app.publish')</button>
                        <button type="submit" class="btn btn-success on-save-chapter" data-publish="0">@lang('app.save')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
