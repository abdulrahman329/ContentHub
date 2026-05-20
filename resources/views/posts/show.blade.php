<x-app-layout>

    <x-slot name="header">
        <span class="text-gray-900 dark:text-white">
            {{ __('Show Post') }}
        </span>
    </x-slot>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 py-8">

        {{-- LEFT / MAIN CONTENT --}}
        <div class="lg:col-span-8 space-y-8">

            {{-- POST CARD --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-8 shadow-sm dark:shadow-none transition">

                {{-- TOP META --}}
                <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400 text-sm mb-6">
                    <img
                        src="{{ $post->user?->image_url }}"
                        class="w-10 h-10 rounded-full object-cover border border-gray-300 dark:border-gray-700">
                    <span class="font-medium">
                        {{ $post->user?->name ?? 'Unknown' }}
                    </span>

                    <span>•</span>

                    <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs border border-gray-200 dark:border-gray-700">
                        {{ $post->category?->name ?? 'Uncategorized' }}
                    </span>
                </div>

                {{-- TITLE --}}
                <h1 class="text-4xl break-words font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    {{ $post->title }}
                </h1>

                {{-- IMAGE --}}
                @if($post->image)
                    <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800 mb-8">
                        <img
                            src="{{ $post->image_url }}"
                            class="w-full max-h-[450px] object-cover hover:scale-[1.01] transition duration-500"
                        >
                    </div>
                @endif

                {{-- CONTENT --}}
                <div class="text-gray-700 dark:text-gray-300 break-words text-lg leading-relaxed whitespace-pre-line">
                    {{ $post->content }}
                </div>

                {{-- ACTIONS --}}
                <div class="flex items-center pt-8 mt-8 border-t border-gray-200 dark:border-gray-800">

                    {{-- BACK --}}
                    <x-ui.buttons.actions.link href="{{ route('posts.index') }}">
                        <x-ui.buttons.variants variant="back">
                            Back
                        </x-ui.buttons.variants>
                    </x-ui.buttons.actions.link>
                    
                    {{-- LIKE --}}
                    <div class="flex items-center gap-2 ml-4">
                        
                        <x-ui.buttons.variants 
                        onclick="toggleLike('post', {{ $post->id }}, this)"
                        variant="like">
                            <span>
                                {{ $post->isLikedBy(auth()->user()) ? '❤️' : '🤍' }}
                            </span>                     
                        </x-ui.buttons.variants>
                        <span
                            id="like-count-post-{{ $post->id }}"
                            class=" text-base text-gray-500"
                        >
                            ( {{ $post->likes_count }} )
                        </span>

                    </div>

                    {{-- RIGHT ACTIONS --}}
                    <div class="flex gap-3 ml-auto">
                        @can('update', $post)
                            <x-ui.buttons.actions.link href="{{ route('posts.edit', $post->id) }}">
                                <x-ui.buttons.variants variant="show-edit">
                                    Edit
                                </x-ui.buttons.variants>
                            </x-ui.buttons.actions.link>
                        @endcan
                        @can('delete', $post)
                            <x-ui.buttons.actions.form
                                action="{{ route('posts.destroy', $post->id) }}"
                                method="DELETE">
                                    <x-ui.buttons.variants variant="show-delete">
                                        Delete
                                    </x-ui.buttons.variants>
                            </x-ui.buttons.actions.form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT / COMMENTS --}}
        <div class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">

                {{-- COMMENTS HEADER --}}
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Comments
                    </h3>
                    @can('viewTrash', App\Models\Comment::class)
                        <x-ui.buttons.actions.link href="{{ route('comments.trash') }}">
                            <x-ui.buttons.variants variant="trash">
                                {{ $trashedCommentsCount }}
                            </x-ui.buttons.variants>
                        </x-ui.buttons.actions.link>
                    @endcan
                </div>

                {{-- COMMENT FORM --}}
                @can('create', App\Models\Comment::class)
                    @auth
                        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 shadow-sm">
                            <x-comment.form :parentId="$post->id" />
                            @error('content')
                                <p class="text-red-500 text-xs mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endauth
                @endcan

                {{-- COMMENTS LIST --}}
                <div class="space-y-4 max-h-[700px] overflow-y-auto pr-2">
                    @forelse($comments as $comment)
                        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-4 shadow-sm transition">

                            {{-- HEADER --}}
                            <div class="flex items-start gap-3">

                                <img
                                    src="{{ $comment->user?->image_url }}"
                                    class="w-9 h-9 rounded-full object-cover border border-gray-300 dark:border-gray-700">

                                <div class="flex-1">

                                    {{-- NAME + BADGE --}}
                                    <div class="flex items-center gap-2">

                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $comment->user?->name ?? 'Deleted User' }}                                        
                                        </p>

                                        @if($comment->user_id === $post->user_id)
                                            <span class="text-[10px] px-2 py-0.5 rounded bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300">
                                                Author
                                            </span>
                                        @endif

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
                                class="mt-3 text-sm text-gray-700 dark:text-gray-300 break-words leading-relaxed">

                                {{ $comment->content }}

                                {{-- LIKE --}}
                                <div class="mt-3 flex items-center gap-2">
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
                                       ( {{ $comment->likes_count }} )
                                    </span>
                                        {{-- NEW: Author liked badge --}}
                                        <span  id="author-badge-comment-{{ $comment->id }}"
                                         class="ml-2 text-[10px] px-2 py-0.5 rounded-full
                                                        bg-blue-100 text-blue-600
                                                        dark:bg-blue-900 dark:text-blue-300 hidden">
                                                Author liked
                                            </span>
                                </div>
                            </div>

                            {{-- EDIT MODE --}}
                            <div id="edit-{{ $comment->id }}" class="hidden mt-3">
                                <x-comment.form :comment="$comment" :parentId="$post->id"/>
                            </div>

                            {{-- ACTIONS --}}
                            <div class="flex gap-4 mt-3 pt-3 border-t border-gray-100 dark:border-gray-800 text-xs">

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

                    @empty
                        <div class="bg-white dark:bg-gray-900 border border-dashed border-gray-300 dark:border-gray-700 rounded-2xl p-8 text-center">
                            <p class="text-gray-500 dark:text-gray-400">
                                No comments yet
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>