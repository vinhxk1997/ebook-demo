<div class="story col-sm-6 mb-3">
    <div class="card">
        <div class="card-body d-flex">
            @if ($story->cover_image)
            <a class="cover cover-xs mr-2" href="{{ route('story_edit', ['story_id' => $story->id]) }}"><img src="{{ get_story_cover($story) }}" /></a>
            @else
            <a class="cover cover-xs mr-2 bg-gray"></a>
            @endif
            <div class="info flex-grow-1">
                <h4><a href="{{ route('story_edit', ['story_id' => $story->id]) }}">{{ $story->title }}</a></h4>
                <small>
                    {{ trans_choice('app.published_chapters', $story->published_chapters_count) }}
                    -
                    {{ trans_choice('app.drafts', $story->chapters_count - $story->published_chapters_count) }}
                </small>
            </div>
            <div class="my-auto dropdown">
                <button class="btn btn-light" data-toggle="dropdown">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" target="blank" href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">
                        @lang('app.view_as_reader')
                    </a>
                    @if ($story->is_published)
                    <button class="dropdown-item on-unpublish-story" data-url="{{ route('story_unpublish', [
                        'story' => $story->id
                    ]) }}">
                        @lang('app.unpublish')
                    </button>
                    @endif
                    <button class="dropdown-item on-delete-story" data-url="{{ route('story_delete', [
                        'story' => $story->id
                    ]) }}">
                        @lang('app.delete_story')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>