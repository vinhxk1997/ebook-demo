@extends('backend.master')
@section('title', 'Reply Comments')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-book"></i>
        {{ trans('tran.reply') }}</div>
    <div class="card-body">
        <hr/>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered bookTable" id="dataTable">
                <thead>
                    <tr>
                        <th>{{ trans('tran.id') }}</th>
                        <th>{{ trans('tran.author') }}</th>
                        <th>{{ trans('tran.title') }}</th>
                        <th>{{ trans('tran.content') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{!! $key++ !!}</td>
                        <td>{!! $comment->user->full_name !!}</td>
                        <td>{!! $comment->commentable->title !!}</td>
                        <td>{!! $comment->content !!}</td>
                        <td><a onclick="return confirm('{{ trans('tran.delete_comment') }}')"
                            href="{{ route('delete_comment', ['id' => $comment->id]) }}" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> {{ trans('tran.delete') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
