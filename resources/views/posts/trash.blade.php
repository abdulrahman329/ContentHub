<x-app-layout>
    <x-slot name="header">    
        {{ __('Trashed Posts') }}
    </x-slot>

    <h1 class="text-3xl font-bold mb-10 text-center text-white">
        🗑️ Trashed Posts
    </h1>

    @if($posts->isEmpty())
        <div class="bg-gray-800 text-gray-300 p-8 rounded-xl text-center">
            No deleted posts found.
        </div>
    @else

        <div class="space-y-6">

            @foreach($posts as $post)

            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">

            <div class="flex">

                {{-- Image (only if exists) --}}
                @if(!empty($post->image))
                    <div class="w-48 h-40 flex-shrink-0">
                        <img
                            src="{{ asset('storage/'.$post->image) }}"
                            class="w-full h-full object-cover"
                        >
                    </div>
                @endif

                {{-- Content --}}
                <div class="flex flex-col justify-between p-6 w-full">

                    {{-- Top --}}
                    <div>

                        <h3 class="text-2xl font-bold text-white mb-2">
                            {{ $post->title }}
                        </h3>

                        <p class="text-sm text-gray-400 mb-3">
                            {{ $post->category?->name ?? 'Uncategorized' }}
                        </p>

                        <div class="flex items-center gap-3 flex-wrap">

                            <span class="text-xs px-3 py-1 rounded-full bg-blue-600 text-white">
                                {{ strtoupper($post->type) }}
                            </span>

                            {{-- User --}}
                            <div class="flex items-center gap-2">
                                <img
                                    src="{{ $post->user?->image 
                                        ? asset('storage/'.$post->user->image)
                                        : asset('storage/images/user_image.png') }}"
                                    class="w-8 h-8 rounded-full object-cover border border-gray-600"
                                >

                                <span class="text-sm text-gray-300">
                                    {{ $post->user->name ?? 'Unknown' }}
                                </span>
                            </div>

                        </div>

                    </div>

                    {{-- Bottom Actions --}}
                    <div class="flex justify-end gap-6 mt-6">

                        <form method="POST" action="{{ route('posts.restore', $post->id) }}">
                            @csrf
                            <button class="text-green-400 hover:text-green-300 font-semibold">
                                Restore
                            </button>
                        </form>

                        <form method="POST" action="{{ route('posts.forceDelete', $post->id) }}"
                            onsubmit="return confirm('Delete this post forever?')">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-500 hover:text-red-400 font-semibold">
                                Delete Forever
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>
            @endforeach

        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>

    @endif

    {{-- Back --}}
    <div class="flex justify-start mt-10">
        <a href="{{ route('posts.index') }}"
           class="bg-blue-600 hover:bg-blue-800 text-white px-6 py-3 rounded-md font-semibold transition">
            Back
        </a>
    </div>
</x-app-layout>