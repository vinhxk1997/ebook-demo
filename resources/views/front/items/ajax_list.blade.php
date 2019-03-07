<button class="dropdown-item d-flex on-add-to-list" data-id="{{ $list->id }}" >
    <i class="fa fa-book fa-fw"></i>
    <span>{{ $list->name }}</span>
    @if (!! $list->story_exists)
        <i class="fa fa-check-circle-o saved"></i>
    @endif
</button>