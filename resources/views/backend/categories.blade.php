@extends('backend.master')
@section('title', 'Category')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-user"></i>
        {{ trans('tran.meta') }}</div>
    <hr>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    {!! Form::open(['method' => 'POST']) !!}
    <div class="form-group row">
        {!! Form::label('meta_name', trans('tran.meta_name'), ['class' => 'col-md-2 col-form-label text-center']) !!}
        <div class="col-md-4">
            {!! Form::text('meta_name', $cate->name, ['class' => 'form-control' . ($errors->has('meta_name') ? ' is-invalid' : '') , 'id' => 'cate', 'placeholder' =>
            trans('tran.enter_cate')]) !!}
        </div>
        @if ($errors->has('meta_name'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('meta_name') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group row">
        {!! Form::label('meta_type', trans('tran.meta_type'), ['class' => 'col-md-2 col-form-label text-center']) !!}
        <div class="col-md-2">
            @if ($cate->type == null)
                {!! Form::select('meta_type', ['category' => 'Category' ,'tag' => 'Tag'], '',
                ['class' => 'form-control custom-select custom-select-lg mb-3']) !!}
            @else
                {!! Form::select('meta_type', ['category' => 'Category' ,'tag' => 'Tag'], ($cate->type == 'category') ?
                'category' : 'tag',
                ['class' => 'form-control custom-select custom-select-lg mb-3']) !!}
            @endif
        </div>
    </div>
    <div class="for-group row mb-0">
        <div class="col offset-md-2">
            {!! Form::submit(trans('tran.save'), ['class' => 'btn btn-primary' ]) !!}
        </div>
    </div>
    {!! Form::close() !!}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>{{ trans('tran.id') }}</th>
                        <th>{{ trans('tran.meta_name') }}</th>
                        <th>{{ trans('tran.meta_type') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cates as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->type }}</td>
                        <td><a class="btn btn-secondary" href="{!! URL::route('update_cate', $category->id) !!}"><i
                                    class="fas fa-pen"></i>{{ trans('tran.edit') }}</a>
                            <a onclick="return confirm('{{ trans('tran.delete_cate') }}')"
                                href="{{ route('delete_cate',['id' => $category->id]) }}" class="btn btn-danger"><i
                                    class="fas fa-trash-alt"></i> {{ trans('tran.delete') }}</a>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
