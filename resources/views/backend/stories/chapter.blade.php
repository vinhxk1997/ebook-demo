@extends('backend.master')
@section('title', 'Story')
@section('content')
<div class="card-body">
    <a href="{{ route('story_detail', ['id' => $chapter->story_id]) }}" class="btn btn-outline-warning">{{ trans('tran.back_all') }}</a>
    <div class="text-center text-danger">
        <h3>{{ $chapter->title }}</h3>
    </div>
    <div>
        {{ $chapter->content }}
    </div>
</div>
@endsection
