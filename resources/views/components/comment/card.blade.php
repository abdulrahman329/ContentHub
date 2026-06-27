<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-4 shadow-sm transition">

{{-- HEADER --}}
<div class="flex items-start gap-2">

    <img
    src="{{ $comment->user_image_url }}"
        class="w-9 h-9 rounded-full object-cover border border-gray-300 dark:border-gray-700">

    <div class="flex-1">

        {{-- NAME + BADGE --}}
        <div class=" flex items-center gap-1">

            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                {{ $comment->user?->name ?? 'Deleted User' }}                                        
            </p>

            @if($comment->user_id === $post->user_id)
                <span class="text-[10px] px-2 py-0.5 rounded bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300">
                    Author
                </span>
            @endif
            
            {{-- LIKE --}}
    <div class="ml-auto flex items-center gap-1">
    {{-- NEW: Author liked badge --}}
            <span  
                id="author-badge-comment-{{ $comment->id }}"
                class="ml-2 text-[10px] px-2 py-0.5 rounded-full
                    bg-blue-100 text-blue-600
                    dark:bg-blue-900 dark:text-blue-300
                    {{ $comment->author_liked ? '' : 'hidden' }}">
                Author liked
            </span>
            
        <x-ui.buttons.variants 
        onclick="toggleLike('comment', {{ $comment->id }}, this)"
        variant="like">
            <span>
                {{ $comment->isLikedBy(auth()->user()) ? '❤️' : '🤍' }}
            </span>                     
        </x-ui.buttons.variants>

        <span
            id="like-count-comment-{{ $comment->id }}"
            class="text-xs text-gray-500"
        >
            {{ $comment->likes_count }}
        </span>
    </div>
        </div>


        {{-- TIME + EDIT INFO --}}
        <div class="text-xs text-gray-500 mt-0.5 space-x-1">

            <span>{{ $comment->created_at->diffForHumans() }}</span>

            @if($comment->edited_at)
                <span>•</span>
                <span class="text-amber-500">
                    edited
                    @if($comment->edited_by && $comment->edited_by !== $comment->user_id)
                       by {{ $comment->editor?->name }}
                    @endif
                </span>
            @endif

        </div>
    </div>
</div>    

{{-- CONTENT --}}
<div id="view-{{ $comment->id }}"
    class="mt-1 text-sm text-gray-700 dark:text-gray-300 break-words leading-relaxed">

    {{ $comment->content }}
</div>


{{-- EDIT MODE --}}
<div id="edit-{{ $comment->id }}" class="hidden mt-3">
    <x-comment.form :comment="$comment" :commentableId="$post->id"/>
</div>

<div
id="reply-form-{{ $comment->id }}"
class="hidden mt-3">

<x-comment.form
    :commentableId="$post->id"
    :parentCommentId="$comment->id" />

</div>

{{-- ACTIONS --}}
<div class="flex gap-4 mt-3 pt-3 border-t border-gray-100 dark:border-gray-800 text-xs">
{{-- REPLY BUTTON --}}
<button
    type="button"
    onclick="toggleReply({{ $comment->id }})"                                
    class="text-blue-500 hover:underline text-xs"
>
    Reply
</button>

    @can('update', $comment)
    <x-ui.buttons.variants
        variant="warning"
            type="button"
            class="text-yellow-500 hover:underline"
            onclick="toggleEdit({{ $comment->id }})">
            Edit
    </x-ui.buttons.variants>
    @endcan
    @can('delete', $comment)
    <x-ui.buttons.actions.form
        action="{{ route('comments.destroy', $comment->id) }}"
        method="DELETE">
            <x-ui.buttons.variants variant="danger">
                Delete
            </x-ui.buttons.variants>
    </x-ui.buttons.actions.form>
    @endcan

</div>
</div>


@if($comment->replies->count())
    <div class="ml-8 mt-4 space-y-3 border-l border-gray-200 pl-4">

        @foreach($comment->replies as $reply)
            <x-comment.card
                :comment="$reply"
                :post="$post"
            />
        @endforeach

    </div>
@endif