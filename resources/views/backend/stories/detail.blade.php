@extends('backend.master')
@section('title', 'Story')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-book"></i>
        {{ trans('tran.chapter') }}</div>
    <div class="card-body">
        <hr/>
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
                        <th>{{ trans('tran.story') }}</th>
                        <th>{{ trans('tran.title') }}</th>
                        <th>Slug</th>
                        <th>{{ trans('tran.completed') }}</th>
                        <th>{{ trans('tran.create_at') }}</th>
                        <th>{{ trans('tran.update_at') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chapters as $chapter)
                        <tr>
                            <td>{!! $chapter->id !!}</td>
                            <td>{!! $chapter->story->title !!}</td>
                            <td><a class="btn btn-light" data-toggle="tooltip" data-placement="right" title="click here to show chapter detail"
                                    href="{{ route('chapter', ['id' => $chapter->id ]) }}">{!! $chapter->title !!}</a></td>
                            <td>{{ $chapter->slug }}</td>
                            <td>{{ ($chapter->status > 0 ) ? 'no' : 'yes' }}</td>
                            <td>{{ $chapter->created_at }}</td>
                            <td>{{ $chapter->updated_at }}</td>
                            <td><a onclick="return confirm('{{ trans('tran.delete_story') }}')"
                                href="{{ route('delete_chapter', ['id' => $chapter->id]) }}" class="btn btn-danger"><i
                                    class="fas fa-trash-alt"></i> {{ trans('tran.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
