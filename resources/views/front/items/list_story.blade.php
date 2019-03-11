<div class="story d-flex list-group-item" data-url="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">
    <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="item-cover">
        <img class="cover cover-xs" src="{{ get_story_cover($story, 0) }}" />
    </a>
    <div class="story-details text-truncate flex-grow-1">
        <h5 class="story-title text-truncate">
            <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="text-truncate">
                {{ $story->title }}
            </a>
        </h5>
        <div class="story-stats">
            <span class="view-count"><i class="fa fa-eye"></i> {{ $story->views }}</span>
            <span class="vote-count"><i class="fa fa-star"></i> {{ $story->votes }}</span>
            <span class="chapter-count"><i class="fa fa-list-ul"></i> {{ $story->chapters_count }}</span>
        </div>
        <p class="story-summary hide-on-edit">{{ str_limit($story->summary, config('app.story_summary_limit'), '...') }}</p>
    </div>
    <div class="show-on-edit">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="story_{{ $story->id }}" name="select[]" value="{{ $story->id }}" autocomplete="off">
            <label class="custom-control-label" for="story_{{ $story->id }}"></label>
        </div>
    </div>
</div>
