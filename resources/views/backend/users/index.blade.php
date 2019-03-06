@extends('backend.master')
@section('title', 'User')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-user"></i>
        {{ trans('tran.user') }}</div>
    <div class="card-body">
        <div>
            <a class="btn btn-success" href="{{ route('add_user') }}">{{ trans('tran.add_user') }}</a>
        </div>
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
                        <th>{{ trans('tran.name') }}</th>
                        <th>{{ trans('tran.loginname') }}</th>
                        <th>Email</th>
                        <th>{{ trans('tran.role') }}</th>
                        <th>{{ trans('tran.ban') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{!! $user->id !!}</td>
                        <td><a href="{{ route('update_user', ['id' => $user->id]) }}">{!! $user->full_name !!}</a></td>
                        <td>{!! $user->login_name !!}</td>
                        <td>{!! $user->email !!}</td>
                        <td>{!! ($user->role > 0) ? 'admin' : 'normal' !!}</td>
                        <td>{!! ($user->is_banned > 0) ? 'yes' : 'no' !!}</td>
                        <td>
                            <a onclick="return confirm('{{ trans('tran.delete_user') }}')"
                            href="{!! URL::route('delete_user', $user->id) !!}" class="btn btn-danger"><i class="fas fa-trash-alt"></i> {{ trans('tran.delete') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
