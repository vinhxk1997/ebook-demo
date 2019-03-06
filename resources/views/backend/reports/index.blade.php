@extends('backend.master')
@section('title', 'Story Reports')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-flag"></i>
        {{ trans('tran.report') }}</div>
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
                        <th>{{ trans('tran.story') }}</th>
                        <th>{{ trans('tran.content') }}</th>
                        <th>{{ trans('tran.status') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{!! $report->id !!}</td>
                        <td>{!! $report->user->full_name !!}</td>
                        <td>{!! $report->story->title !!}</td>
                        <td>{!! $report->content !!}</td>
                        <td>{!! $report->status !!}</td>
                        <td><a class="btn btn-primary" href="{{ route('update_report', ['id' => $report->id]) }}">
                            <i class="fas fa-pen"></i> {{ trans('tran.update') }}</a>
                            <a onclick="return confirm('{{ trans('tran.delete_report') }}')"
                            href="{{ route('delete_report', ['id' => $report->id]) }}" class="btn btn-danger">
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
