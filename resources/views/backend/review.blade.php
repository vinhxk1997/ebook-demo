@extends('backend.master')
@section('title', 'Review')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-user"></i>
        {{ trans('tran.review') }}</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>{{ trans('tran.id') }}</th>
                        <th>{{ trans('tran.author') }}</th>
                        <th>{{ trans('tran.title') }}</th>
                        <th>{{ trans('tran.book') }}</th>
                        <th>{{ trans('tran.content') }}</th>
                        <th>{{ trans('tran.create_at') }}</th>
                        <th>{{ trans('tran.update_at') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Nguyễn Chu Nam Phương</td>
                        <td>Numagician</a></td>
                        <td>Numagician</td>
                        <td>Status</td>
                        <td>12/08/2018</td>
                        <td>12/08/2018</td>
                        <td class="text-center"><a class="btn btn-danger" href="#"><i class="fas fa-trash-alt"></i>{{ trans('tran.delete') }}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
