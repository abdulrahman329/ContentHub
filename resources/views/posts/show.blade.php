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

            @can('viewTrash', App\Models\Comment::class)
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('comments.trash') }}"
                    class="text-sm text-white bg-gray-600 hover:bg-gray-800 px-4 py-2 rounded-md transition-all">
                        View Deleted Comments
                    <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs border border-gray-200 dark:border-gray-700">
                        {{ $post->category?->name ?? 'Uncategorized' }}
                    </span>
                    </a>
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

                {{-- CONTENT --}}
                <div class="text-gray-700 dark:text-gray-300 break-words text-lg leading-relaxed whitespace-pre-line">
                    {{ $post->content }}
                </div>

                        @can('update', $comment)
                        <x-ui.buttons.edit 
                            href="{{ route('comments.edit', $comment->id) }}">
                            Edit
                        </x-ui.buttons.edit>
                        @endcan

                        @can('delete', $comment)
                            <form method="POST"
                                  action="{{ route('comments.destroy', $comment->id) }}">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="text-red-500 hover:text-red-700"
                                    onclick="return confirm('Delete comment?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex justify-between items-center mt-8">

            <a href="{{ route('posts.index') }}"
            class="text-lg text-white bg-blue-600 hover:bg-blue-800 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all">
            Back
            </a>

            <div class="space-x-4">

                @can('update', $post)
                <a href="{{ route('posts.edit', $post->id) }}"
                    class="inline-block text-lg text-white bg-yellow-500 hover:bg-yellow-700 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all"> 
                    Edit
                </a>

                @endcan

                @can('delete', $post)
                    <form method="POST"
                          action="{{ route('posts.destroy', $post->id) }}"
                          class="inline-block">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                        class="text-lg text-white bg-red-500 hover:bg-red-800 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all"                                
                        onclick="return confirm('Delete post?')">
                            Delete
                        </button>
                    </form>
                @endcan

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