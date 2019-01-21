@if($comments->count())

    @foreach($comments as $commant)
        <li class="comment">
            <img class="avatar" src="{{ replaceImageUrl($commant->user) }}" alt="..." style="width: 60px; margin: 10px;">
            <div class="comment-body" style="font-size: 0.8em">
                <div >
                    <span><span>{{ $commant->user->name }}</span> <i> - {{ $commant->date->format('M ,d Y') }}</i></span>
                    <span class="pull-right delete-comment hand" style="color: #e8e8e8;" data-comment-key="{{ $commant->id }}"><i class="fa fa-remove"></i></span>
                </div>
                <div>{{ $commant->text }}</div>
            </div>
        </li>
    @endforeach

@endif
