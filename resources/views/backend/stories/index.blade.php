@extends('backend.master')
@section('title', 'Story')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-book"></i>
        {{ trans('tran.story') }}</div>
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
                        <th>{{ trans('tran.mature') }}</th>
                        <th>{{ trans('tran.status') }}</th>
                        <th>{{ trans('tran.views') }}</th>
                        <th>{{ trans('tran.completed') }}</th>
                        <th>{{ trans('tran.recommended') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($stories as $story)
                    <tr>
                        <td>{!! $story->id !!}</td>
                        <td>{!! $story->user->full_name !!}</td>
                        <td><a class="btn btn-light" data-toggle="tooltip" data-placement="right" title="{{ trans('tran.tip_detail') }}" href="{{ route('story_detail', ['id' => $story->id]) }}">{!! $story->title !!}</a></td>
                        <td>{!! ($story->is_mature > 0) ? 'no' : 'yes' !!}</td>
                        <td>{!! ($story->status > 0) ? 'no' : 'yes' !!}</td>
                        <td>{!! $story->views !!}</td>
                        <td>{!! ($story->is_completed > 0) ? 'no' : 'yes' !!}</td>
                        <td>{!! ($story->is_recommended < 1) ? 'no' : 'yes' !!}</td>
                        <td class="text-center"><a class="btn btn-secondary" href="{{ route('story_info', ['id' => $story->id]) }}"><i class="fas fa-info-circle"></i> {{ trans('tran.information') }}</a>
                        <a onclick="return confirm('{{ trans('tran.delete_story') }}')"
                                href="{{ route('delete_story', ['id' => $story->id]) }}" class="btn btn-danger"><i
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
