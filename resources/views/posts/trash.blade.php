<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-200 leading-tight">
        {{ __('Trashed Posts') }}
    </h2>
</x-slot>

<div class="container mx-auto px-10 py-14">

    {{-- Title --}}
    <h1 class="text-3xl font-bold mb-10 text-center text-white">
        Trashed Posts
    </h1>

    {{-- Empty --}}
    @if($posts->isEmpty())
        <div class="bg-gray-800 text-gray-300 p-8 rounded-xl text-center">
            No deleted posts found.
        </div>
    @else

        <div class="space-y-6">

            @foreach($posts as $post)

                <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-lg flex justify-between items-center hover:bg-gray-750 transition">

                    {{-- Left --}}
                    <div class="flex items-center gap-5">

                        {{-- Image (optional) --}}
                        <img
                            src="{{ $post->image 
                                ? asset('storage/'.$post->image) 
                                : asset('storage/images/user_image.png') }}"
                            class="w-16 h-16 object-cover rounded-lg border border-gray-600"
                        >

                        {{-- Info --}}
                        <div>
                            <h3 class="text-xl font-bold text-white">
                                {{ $post->title }}
                            </h3>

                            <p class="text-sm text-gray-400">
                                {{ $post->category?->name ?? 'Uncategorized' }}
                            </p>

                            <div class="flex gap-2 mt-2">
                                <span class="text-xs px-3 py-1 rounded-full bg-blue-600 text-white">
                                    {{ strtoupper($post->type) }}
                                </span>

                                <span class="text-xs text-gray-400">
                                    by {{ $post->user->name ?? 'Unknown' }}
                                </span>
                            </div>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-6 text-lg">

                        {{-- Restore --}}
                        <form method="POST" action="{{ route('posts.restore', $post->id) }}">
                            @csrf
                            <button class="text-green-400 hover:text-green-300 font-semibold">
                                Restore
                            </button>
                        </form>

                        {{-- Force Delete --}}
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

            @endforeach

        </div>

        {{-- Pagination --}}
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

</div>

</x-app-layout>