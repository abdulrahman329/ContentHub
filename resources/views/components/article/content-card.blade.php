@props(['item'])

<div class="bg-gray-800 text-white rounded-lg shadow-lg overflow-hidden flex flex-col">

    {{-- Image --}}
    @if($item->image)
        <a href="{{ route('posts.show', $item->id) }}">
            <img src="{{ filter_var($item->image, FILTER_VALIDATE_URL)
                ? $item->image
                : asset('storage/'.$item->image) }}"
                class="w-full h-56 object-cover">
        </a>
    @endif

    {{-- Content --}}
    <div class="px-6 py-4 flex-grow">

        @if($item->type)
            <span class="inline-block mb-2 px-3 py-1 text-xs font-bold rounded-full
                {{ $item->type === 'news' ? 'bg-green-600 text-white' : 'bg-blue-600 text-white' }}">
                {{ strtoupper($item->type) }}
            </span>
        @endif
        
        <div class="font-bold text-xl">
            {{ $item->title }}
        </div>

        <p class="text-gray-300 text-sm">
            {{ Str::limit($item->content, 100) }}
        </p>
    </div>

    {{-- Actions --}}
    <div class="px-6 pb-4 space-y-2">

        <a href="{{ route('posts.show', $item->id) }}"
            class="inline-block mb-2 bg-blue-600 text-black py-2 px-4 rounded-lg hover:bg-blue-800 transform transition-all duration-200 ease-in-out w-full text-center">            View
        </a>

        @can('update', $item)
            <a href="{{ route('posts.edit', $item->id) }}"
                class="inline-block bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-700 transform transition-all duration-200 ease-in-out w-full text-center">                Edit
            </a>
        @endcan

        @can('delete', $item)
            <form method="POST" action="{{ route('posts.destroy', $item->id) }}">
                @csrf
                @method('DELETE')

                <button class="bg-red-600 text-black py-2 px-4 rounded-lg hover:bg-red-800 transform transition-all duration-200 ease-in-out w-full text-center" 
                    onclick="return confirm('Are you sure?')">
                    Delete
                </button>
            </form>
        @endcan

        {{-- Meta --}}
        <div class="mt-3 text-gray-400 text-sm space-y-1">

            @if($item->category)
                <p>
                    <strong>Category:</strong> {{ $item->category->name }}
                </p>
            @endif


            @if(isset($item->comments_count))
                <p>
                    <strong>Comments:</strong> {{ $item->comments_count }}
                </p>
            @endif

        </div>

    </div>
</div>