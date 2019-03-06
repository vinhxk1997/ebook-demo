@extends('backend.master')
@section('title', 'Story')
@section('content')
<div class="card-body">
    <div>
        <h1 class="text-success">{{ trans('tran.story_info') }}</h1>
    </div>
    <div>
        {!! Form::open(['method' => 'POST']) !!}
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="form-group row">
            {!! Form::label('storyid', trans('tran.id'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-1">
                {!! Form::text('storyid', $story->id, ['class' => 'form-control', 'id' => 'storyid', 'readonly']) !!}
            </div>
            {!! Form::label('report', trans('tran.report'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-1">
                {!! Form::text('report', '', ['class' => 'form-control', 'id' => 'report', 'readonly']) !!}
            </div>
            {!! Form::label('chapter', trans('tran.chapter'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-1">
                {!! Form::text('chapter', $story->chapters->count(), ['class' => 'form-control', 'id' => 'chapter', 'readonly']) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('image', trans('tran.image'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-2">
                <img src="{{ get_story_cover($story, 1) }}" alt="Image" class="img-thumbnail">
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('author', trans('tran.author'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-3">
                {!! Form::text('author', $story->user->full_name, ['class' => 'form-control', 'id' => 'author', 'readonly']) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('title', trans('tran.title'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-6">
                {!! Form::text('title', $story->title, ['class' => 'form-control', 'id' => 'title', 'readonly']) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('slug', 'Slug', ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-6">
                {!! Form::text('Slug', $story->slug, ['class' => 'form-control', 'id' => 'slug', 'readonly']) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('summary', trans('tran.summary'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-6">
                {!! Form::textarea('summary', $story->summary, ['class' => 'form-control', 'id' => 'summary', 'readonly']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('view', trans('tran.views'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-2">
                {!! Form::text('view', $story->views, ['class' => 'form-control', 'id' => 'view', 'readonly']) !!}
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <div class="col-md-2 custom-control custom-switch">
                {!! Form::checkbox('mature', null, ($story->is_mature < 1) ? null : 'checked', ['id' => 'mature', 'class' => 'custom-control-input']) !!}
                {!! Form::label('mature', trans('tran.mature'), ['class' => 'custom-control-label']) !!}
            </div>
            <div class="col-md-2 custom-control custom-switch">
                {!! Form::checkbox('status', null, ($story->status < 1) ? null : 'checked', ['id' => 'status', 'class' => 'custom-control-input']) !!}
                {!! Form::label('status', trans('tran.published'), ['class' => 'custom-control-label']) !!}
            </div>
            <div class="col-md-2 custom-control custom-switch">
                {!! Form::checkbox('recommended', null, ($story->is_recommended < 1) ? null : 'checked', ['id' => 'recommended', 'class' => 'custom-control-input']) !!}
                {!! Form::label('recommended', trans('tran.recommended'), ['class' => 'custom-control-label']) !!}
            </div>
        </div>

        <div class="form-group row tag-form">
            {!! Form::label('tag', 'Tag', ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-5">
                @foreach ($tags as $tag)
                    <span class="cates">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('category', trans('tran.category'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-5">
                @foreach ($cates as $cate)
                    <div class="cates">{{ $cate->name }}</div>
                @endforeach
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('create-at', trans('tran.create_at'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-2">
                {!! Form::date('create-at', $createAt, ['class' => 'form-control', 'id' => 'create-at', 'readonly']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('update-at', trans('tran.update_at'), ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-2">
                {!! Form::date('update-at', $updateAt, ['class' => 'form-control', 'id' => 'update-at', 'readonly']) !!}
            </div>
        </div>
        <div class="for-group row mb-0">
            <div class="col offset-md-1">
                {!! Form::submit(trans('tran.save'), ['class' => 'btn btn-primary' ]) !!}
                {!! Form::reset(trans('tran.back'), ['class' => 'btn btn-primary' ]) !!}
            </div>
        </div>
    {!! Form::close() !!}
    </div>
</div>
@endsection
