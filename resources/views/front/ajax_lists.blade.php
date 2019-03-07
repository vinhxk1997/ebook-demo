<button class="dropdown-item on-archive">
    <i class="fa fa-bookmark fa-fw"></i>
    <span>@lang('app.my_library') (@lang('app.private'))</span>
    @if (!! $is_archived)
        <i class="fa fa-check-circle-o saved"></i>
    @endif
</button>
@foreach ($lists as $list)
   @include('front.items.ajax_list', ['list' => $list])
@endforeach
@can('create', App\Models\SaveList::class)
<div class="dropdown-divider"></div>
{!! Form::open(['url' => route('create_list'), 'class' => 'inputs on-create-list']) !!}
    <div class="d-flex">
    {!! Form::text(
        'list_name',
        null,
        [
            'class' => 'form-control form-control-sm',
            'placeholder' => __('app.add_new_reading_list'),
            'autocomplete' => 'off'
        ]
    ) !!}
    {!! Form::submit('+', ['class' => 'btn btn-primary btn-sm']) !!}
    </div>
    <div class="invalid-feedback"></div>
{!! Form::close() !!}
@endcan
