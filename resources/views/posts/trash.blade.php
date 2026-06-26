<x-app-layout>

    <x-slot name="header">    
        {{ __('Trashed Posts') }}
    </x-slot>

    {{-- PAGE TITLE --}}
    <h1 class="text-3xl font-bold mb-10 text-center
        text-gray-900 dark:text-white transition-colors">
        🗑️ Trashed Posts
    </h1>
    {{-- BACK BUTTON --}}
    <div class="flex justify-end mb-10">
        <x-ui.buttons.actions.link href="{{ route('posts.index') }}">
            <x-ui.buttons.variants variant="back">
                Back
            </x-ui.buttons.variants>
        </x-ui.buttons.actions.link>
    </div>

    {{-- EMPTY STATE --}}
    @if($posts->isEmpty())
        <div class="rounded-xl text-center p-8 transition-colors
            bg-white border border-gray-200 text-gray-700 shadow-sm
            dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
            No deleted posts found.
        </div>
    @else
        <div class="space-y-6">
            @foreach($posts as $post)
            <div class="rounded-2xl overflow-hidden transition-all duration-300
                bg-white border border-gray-200 shadow-sm hover:shadow-xl
                dark:bg-gray-900 dark:border-gray-700 dark:hover:border-gray-600">
                <div class="flex flex-col md:flex-row">

                    {{-- IMAGE --}}
                    @if(!empty($post->image))
                        <div class="w-full md:w-48 h-52 md:h-40 flex-shrink-0">
                            <img
                                src="{{ asset('storage/'.$post->image) }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif

                    {{-- CONTENT --}}
                    <div class="flex flex-col justify-between p-6 w-full">

                        {{-- TOP --}}
                        <div>

                            {{-- TITLE --}}
                            <h3 class="text-2xl font-bold mb-2 break-words
                                text-gray-900 dark:text-white transition-colors">
                                {{ $post->title }}
                            </h3>

                            {{-- CATEGORY --}}
                            <p class="text-sm mb-4
                                text-gray-500 dark:text-gray-400">
                                {{ $post->category?->name ?? 'Uncategorized' }}
                            </p>

                            <div class="flex items-center gap-4 flex-wrap">
                                {{-- TYPE --}}
                                <span class="text-xs px-3 py-1 rounded-full font-semibold
                                        {{ $post->type === 'news'
                                            ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400'
                                            : 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' }}">
                                        {{ strtoupper($post->type) }}
                                </span>

                                {{-- USER --}}
                                <div class="flex items-center gap-2">
                                    <img
                                        src="{{ $post->user_image_url }}"
                                        class="w-8 h-8 rounded-full object-cover border
                                        border-gray-300 dark:border-gray-600">

                                    <span class="text-sm
                                        text-gray-700 dark:text-gray-300">
                                        {{ $post->user->name ?? 'Unknown' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex justify-end gap-6 mt-8">

                            {{-- RESTORE --}}
                            <x-ui.buttons.actions.form
                                action="{{ route('posts.restore', $post->id) }}"
                                method="POST">
                                <x-ui.buttons.variants variant="restore">
                                    Restore
                                </x-ui.buttons.variants>
                            </x-ui.buttons.actions.form>

                            {{-- FORCE DELETE --}}
                            <x-ui.buttons.actions.form
                                action="{{ route('posts.forceDelete', $post->id) }}"
                                method="DELETE">
                                <x-ui.buttons.variants variant="danger">
                                    Delete Forever
                                </x-ui.buttons.variants>
                            </x-ui.buttons.actions.form>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{-- PAGINATION --}}
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @endif
</x-app-layout>