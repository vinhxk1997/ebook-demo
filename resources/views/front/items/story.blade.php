<div class="story d-flex" data-url="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">
    <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="on-story-preview item-cover">
        <img class="thumbnail thumbnail-md" src="{{ get_story_cover($story, 0) }}" />
    </a>
    <div class="story-details text-truncate">
        <h5 class="story-title text-truncate">
            <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="on-story-preview text-truncate">{{ $story->title }}</a>
        </h5>
        @if (!isset($in_profile))
        <div class="story-uploader"><a href="{{ route('user_about', ['user' => $story->user->login_name]) }}">@lang('app.by') {{ $story->user->full_name }}</a></div>
        @endif
        <div class="story-stats">
            <span class="view-count"><i class="fa fa-eye"></i> {{ $story->chapters->sum('views') }}</span>
            <span class="vote-count"><i class="fa fa-star"></i> {{ $story->chapters->sum('votes_count') }}</span>
            <span class="chapter-count"><i class="fa fa-list-ul"></i> {{ $story->chapters_count }}</span>
        </div>
        <p class="story-summary">{{ str_limit($story->summary, config('app.story_summary_limit'), '...') }}</p>
        <div class="story-tags">
            <ul class="tag-items">
                @foreach ($story->metas->take(config('app.shown_meta')) as $meta)
                <li><a href="{{ route('meta', ['slug' => $meta->slug]) }}">{{ $meta->name }}</a></li>
                @endforeach
            </ul>
            @if ($story->metas->count() > config('app.shown_meta'))
            <span class="on-story-preview num-not-show">
                +@lang('app.more_tag', ['count' => ($story->metas->count() - config('app.shown_meta'))])
            </span>
            @endif
        </div>
    </div>
</div>
