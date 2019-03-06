@extends('backend.master')
@section('title', 'Report')
@section('content')
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="text-center">
        <h1>{{ trans('tran.update_report') }}</h1>
    </div>
    {!! Form::open(['method' => 'POST']) !!}
        <div class="form-group row">                           
            {!! Form::label('author', 'Author', ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-4">
                {!! Form::text('author', $report->user->full_name, ['class' => 'form-control', 'id' => 'author', 'readonly']) !!}
            </div>
            {!! Form::label('story', 'Story', ['class' => 'col-md-2 col-form-label text-md-right']) !!}
            <div class="col-md-4">
                {!! Form::text('story', $report->story->title, ['class' => 'form-control', 'id' => 'author', 'readonly']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('note', 'Note', ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col-md-4">
                {!! Form::textarea('note', $report->note, ['class' => 'form-control', 'id' => 'note']) !!}
            </div>
            {!! Form::label('content', 'Content', ['class' => 'col-md-2 col-form-label text-md-right']) !!}
            <div class="col-md-4">
                {!! Form::textarea('content', $report->content, ['class' => 'form-control', 'id' => 'content', 'readonly']) !!}
            </div>
        </div>
       
        <div class="form-group row">
            {!! Form::label('status', 'Status', ['class' => 'col-md-1 col-form-label text-md-right']) !!}
            <div class="col">
            {!! Form::select('status', ['processing' => 'Processing' ,'rejected' => 'Rejected', 'resolved' => 'Resolved']
                , $report->status) !!}
            </div>
        </div>

        <div class="for-group row mb-0">
            <div class="col offset-md-4">
                {!! Form::submit('Update', ['class' => 'btn btn-primary' ]) !!}
                {!! Form::reset('Back', ['class' => 'btn btn-secondary' ]) !!}
            </div>                
        </div>
    {!! Form::close() !!}
</div>
@endsection
