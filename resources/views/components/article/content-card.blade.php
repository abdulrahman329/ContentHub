@props(['item'])

<article class="group rounded-2xl overflow-hidden border shadow-sm transition-all duration-300
    bg-white border-gray-200 hover:border-gray-300 hover:shadow-xl hover:-translate-y-1
    dark:bg-gray-900 dark:border-gray-800 dark:hover:bg-gray-850 dark:hover:border-gray-700">

    {{-- HEADER --}}
    <div class="flex items-center justify-between px-5 py-4 border-b
        border-gray-200
        dark:border-gray-800">

        {{-- TYPE --}}
        @if($item->type)
            <span class="text-xs font-bold tracking-wide px-3 py-1 rounded-full
                {{ $item->type === 'news'
                    ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400'
                    : 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' }}">
                {{ strtoupper($item->type) }}
            </span>
        @endif

        {{-- READ --}}
        <a href="{{ route('posts.show', $item->id) }}"
            class="text-sm font-medium transition
            text-gray-500 hover:text-gray-900
            dark:text-gray-400 dark:hover:text-white">
            Read 
        </a>
    </div>

    {{-- BODY --}}
    <div class="p-5">

        {{-- TITLE --}}
        <h2 class="text-xl font-bold leading-snug mb-3 transition
            text-gray-900 group-hover:text-black
            dark:text-white dark:group-hover:text-gray-200">
            {{ Str::limit($item->title, 30) }}
        </h2>

        {{-- CONTENT --}}
        <p class="text-sm leading-relaxed mb-5
            text-gray-600
            dark:text-gray-400">
            {{ Str::limit($item->content, 40) }}
        </p>
        
        {{-- IMAGE --}}
        <a href="{{ route('posts.show', $item->id) }}" class="block mb-5">
            <div class="relative w-full h-52 rounded-xl overflow-hidden
                bg-gray-100
                dark:bg-gray-800">
                @if($item->image)
                    <img
                        src="{{ $item->image_url }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-full bg-gradient-to-br
                        from-gray-100 to-gray-200
                        dark:from-gray-800 dark:to-gray-900">
                    </div>
                @endif
            </div>
        </a>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-between">

            {{-- VIEW --}}
            <div>
                <x-ui.buttons.actions.link href="{{ route('posts.show', $item->id) }}">
                    <x-ui.buttons.variants variant="back">
                        View
                    </x-ui.buttons.variants>
                </x-ui.buttons.actions.link>
            </div>
            {{-- EDIT + DELETE --}}
            <div class="flex gap-2">
                @can('update', $item)
                    <x-ui.buttons.actions.link href="{{ route('posts.edit', $item->id) }}">
                        <x-ui.buttons.variants variant="show-edit">
                            Edit
                        </x-ui.buttons.variants>
                    </x-ui.buttons.actions.link>
                @endcan
                @can('delete', $item)
                    <x-ui.buttons.actions.form
                        action="{{ route('posts.destroy', $item->id) }}"
                        method="DELETE">
                        <x-ui.buttons.variants variant="show-delete">
                            Delete
                        </x-ui.buttons.variants>
                    </x-ui.buttons.actions.form>
                @endcan
            </div>
        </div>

        {{-- META --}}
        <div class="flex items-center justify-between mt-5 pt-4 border-t
            border-gray-200
            dark:border-gray-800">
            {{-- COMMENTS LEFT --}}
            <div class="flex items-center gap-2 text-sm
                text-gray-500
                dark:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 10h8M8 14h5m-9 7l2.5-2.5A2 2 0 014 18h12a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2h1.5L3 21z" />
                </svg>
                <span>{{ $item->comments_count ?? 0 }} Comments</span>
                            
                            <x-ui.buttons.variants 
                            onclick="toggleLike('post', {{ $item->id }}, this)"
                            variant="like">
                                <span>
                                {{ $item->isLikedBy(auth()->user()) ? '❤️' : '🤍' }}
                                </span>                     
                            </x-ui.buttons.variants>
                            <span id="like-count-post-{{ $item->id }}">
                               ( {{ $item->likes_count }} )
                            </span>
            </div>

            {{-- CATEGORY RIGHT --}}
            <div class="px-3 py-1 rounded-full text-xs font-medium border
                bg-gray-100 border-gray-300 text-gray-700
                dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                {{ $item->category?->name ?? 'Uncategorized' }}
            </div>
        </div>
    </div>
</article>