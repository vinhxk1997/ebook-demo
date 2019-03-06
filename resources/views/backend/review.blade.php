@extends('backend.master')
@section('title', 'Review')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-user"></i>
        {{ trans('tran.review') }}</div>
    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>{{ trans('tran.id') }}</th>
                        <th>{{ trans('tran.author') }}</th>
                        <th>{{ trans('tran.title') }}</th>
                        <th>{{ trans('tran.story') }}</th>
                        <th>{{ trans('tran.content') }}</th>
                        <th>{{ trans('tran.create_at') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->user->full_name }}</td>
                        <td>{{ $review->title }}</a></td>
                        <td>{{ $review->story->title }}</td>
                        <td>{{ $review->content }}</td>
                        <td>{{ $review->created_at }}</td>
                        <td><a onclick="return confirm('{{ trans('tran.delete_review') }}')"
                                href="{{ route('delete_review', ['id' => $review->id]) }}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> {{ trans('tran.delete') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
