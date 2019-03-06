<div class="col-sm-6 list-item mb-3" data-id="{{ $list->id }}">
    <div class="card">
        <div class="card-body d-flex">
            @if ($list->stories->count())
            <img class="cover cover-xs mr-2" src="{{ get_story_cover($list->stories->first(), 0) }}" />
            @else
            <div class="cover cover-xs mr-2 bg-gray"></div>
            @endif
            <div class="info flex-grow-1">
                <h4><a href="{{ route('list', ['id' => $list->id]) }}">{{ $list->name }}</a></h4>
                <a href="{{ route('list', ['id' => $list->id]) }}">
                    {{ trans_choice('app.stories', $list->stories_count) }}
                </a>
            </div>
            <div class="dropdown align-self-center">
                <button class="btn btn-light" data-toggle="dropdown">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item on-delete-list" data-delete-url="{{ route('delete_list', ['id' => $list->id]) }}">
                        <i class="fa fa-trash fa-fw"></i>
                        @lang('app.delete_list')
                    </button>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" target="_blank" href="https://www.facebook.com/sharer.php?u={{ $list->share_url }}"><i class="fa fa-facebook fa-fw"></i> @lang('app.share_via_facebook')</a>
                    <a class="dropdown-item" target="_blank" href="https://twitter.com/intent/tweet?text={{ $list->share_text }}&url={{ $list->share_url }}"><i class="fa fa-twitter fa-fw"></i> @lang('app.share_via_twitter')</a>
                    <a class="dropdown-item" target="_blank" href="mailto:?subject={{ $list->share_text }}&body={{ $list->share_text }}%0A{{ $list->share_url }}"><i class="fa fa-envelope fa-fw"></i> @lang('app.share_via_email')</a>
                </div>
            </div>
        </div>
    </div>
</div>
