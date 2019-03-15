<div class="list-group-item">
    <div class="row">
        <div class="details col-sm-6">
            <div class="font-weight-bold">
                <a href="{{ route('chapter_write', ['story_id' => $story->id, 'chapter_id' => $chapter->id]) }}">
                    {{ $chapter->title }}
                </a>
            </div>
            <small>
                @if ($chapter->is_published)
                    <span class="status"><span class="text-success">@lang('app.published')</span></span>
                @else
                <span class="status">@lang('app.draft')</span>
                @endif
                - {{ $chapter->updated_at->format(__('app.d_m_y_format')) }}
            </small>
        </div>
        <div class="stats my-auto col-3">
            <div class="row">
                <div class="col-sm-4"><i class="fa fa-eye mr-2"></i> {{ $chapter->views }}</div>
                <div class="col-sm-4"><i class="fa fa-star mr-2"></i> {{ $chapter->votes_count }}</div>
                <div class="col-sm-4"><i class="fa fa-comment mr-2"></i> {{ $chapter->comments_count }}</div>
            </div>
        </div>
        <div class="my-auto dropdown col-3 text-right">
            <button class="btn btn-light" data-toggle="dropdown">
                <i class="fa fa-ellipsis-h"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" target="blank" href="{{ route('read_chapter', [
                    'id' => $chapter->id, 'slug' => $story->slug . '-' . $chapter->slug
                ]) }}">
                    @lang('app.view_as_reader')
                </a>
                @if ($chapter->is_published)
                <button class="dropdown-item on-unpublish-chapter" data-url="{{ route('chapter_unpublish', [
                    'chapter' => $chapter->id,
                    'story' => $story->id
                ]) }}">
                    @lang('app.unpublish')
                </button>
                @endif
                <button class="dropdown-item on-delete-chapter" data-url="{{ route('chapter_delete', [
                    'chapter' => $chapter->id,
                    'story' => $story->id
                ]) }}">
                    @lang('app.delete_chapter')
                </button>
            </div>
        </div>
    </div>
</div>