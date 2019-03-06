@extends('front.layouts.library')
@section('title', __('app.reading_lists'))

@section('tab_content')
    <div class="list-controls my-2">
        @can('create', App\Models\SaveList::class)
        <button class="btn btn-primary btn-sm on-newlist" data-toggle="modal" data-target="#createReadingListModal">
            @lang('app.new_reading_list')
            <i class="fa fa-plus ml-1"></i>
        </button>
        @endcan
    </div>
    @if ($lists->count())
        <div class="collection row" id="readingLists">
            @foreach ($lists as $list)
            @include('front.items.reading_list', ['list' => $list])
            @endforeach
        </div>
    @else
        <div class="collection row" id="readingLists"></div>
        <p class="py-3">@lang('app.no_list')</p>
    @endif
    @if ($lists->hasPages())
    <div class="row mt-3">
        <div class="col-sm-6 offset-sm-3">
            <button class="btn btn-light btn-block on-show-more" data-url="{{ $lists->nextPageUrl() }}" data-target="#readingLists">
                @lang('app.show_more')
                <i class="fa fa-angle-down"></i>
            </button>
    </div>
    @endif
@endsection

@section('modal')
@can('create', App\Models\SaveList::class)
<div class="modal fade" id="createReadingListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['url' => route('create_list', ['source' => 'library']), 'method' => 'post', 'class' => 'modal-content on-create-list']) !!}
            <div class="modal-header">
                <h5 class="modal-title">@lang('app.create_a_reading_list')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::text('list_name', null, [
                    'class' => 'form-control',
                    'id' => 'listName',
                    'placeholder' => __('app.list_name'),
                    'autocomplete' => 'off',
                    'autofocus'
                ]) !!}
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('app.cancel')</button>
                <button type="submit" class="btn btn-primary">@lang('app.create')</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endcan
@endsection
