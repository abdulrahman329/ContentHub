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

                            {{-- USER --}}
                            <div class="flex items-center gap-3 mb-4">
                                <img
                                    src="{{ $comment->user->image_url }}"
                                    class="w-9 h-9 rounded-full object-cover border 
                                    border-gray-300  dark:border-gray-700">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $comment->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            {{-- VIEW MODE --}}
                            <div id="view-{{ $comment->id }}"
                                 class="text-gray-700 dark:text-gray-300 text-sm break-words leading-relaxed">
                                {{ $comment->content }}
                            </div>

                            {{-- EDIT MODE --}}
                            <div id="edit-{{ $comment->id }}" class="hidden mt-4">
                                <x-comment.form :comment="$comment" :parentId="$post->id"/>
                            </div>

                            {{-- ACTIONS --}}
                            <div class="flex gap-5 mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 text-sm">
                            @can('update', $comment)
                                <x-ui.buttons.variants
                                    variant="warning"
                                    type="button"
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

<script>
function toggleEdit(id) {
    const view = document.getElementById('view-' + id);
    const edit = document.getElementById('edit-' + id);

    view.classList.toggle('hidden');
    edit.classList.toggle('hidden');
}
</script>