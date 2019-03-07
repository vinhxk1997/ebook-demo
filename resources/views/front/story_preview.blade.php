<div class="row">
    <a class="col-6">
        <img src="{{ get_story_cover($story, 1) }}" />
    </a>
    <div class="col-6 px-3 pt-3 d-flex flex-column">
        <h4 class="story-title">{{ $story->title }}</h4>
        <div class="story-stats">
            <span class="view-count"><i class="fa fa-eye"></i> {{ $story->views }}</span>
            <span class="vote-count"><i class="fa fa-star"></i> {{ $story->chapters->sum('vote_count') }}</span>
            <span class="chapter-count"><i class="fa fa-list-ul"></i> {{ $story->chapters_count }}</span>
        </div>
        <div class="actions">
            <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="btn btn-sm btn-primary start-reading">
                @lang('app.read')
            </a>
            @auth
            <div class="d-inline-block dropdown button-lists-add" data-id="{{ $story->id }}">
                <button class="btn btn-sm btn-primary on-lists-add">+</button>
                <div class="dropdown-menu dropdown-menu-right lists"></div>
            </div>
            @endauth
        </div>
        <div class="story-summary">{{ str_limit($story->summary, config('app.story_summary_limit'), '...') }}
            <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">@lang('app.more')</a>
        </div>
        <div class="story-tags">
            <ul class="tag-items">
                @foreach ($story->metas->take(config('app.shown_meta')) as $meta)
                <li><a href="{{ route('meta', ['slug' => $meta->slug]) }}">{{ $meta->name }}</a></li>
                @endforeach
            </ul>
            @if ($story->metas_count > config('app.shown_meta'))
            <span class="on-story-preview num-not-show">
                +@lang('app.more_tag', ['count' => ($story->metas_count - config('app.shown_meta'))])
            </span>
            @endif
        </div>
        <div class="story-info py-2 mt-auto">
            @if ($story->is_completed)
                <span class="completed text">@lang('app.completed')</span>
            @else
                <span class="ongoing text">@lang('app.ongoing')</span>
                <time datime="a day ago">@lang('app.updated') {{ $story->updated_at->diffForHumans() }}</time>
            @endif
        </div>
    </div>
</div>
