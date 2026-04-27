<script>
    // This function is triggered when the "Submit Comment" button is clicked
    function handleClick(event, button) {
        // Prevents the default form submission behavior (which reloads the page)
        event.preventDefault();

        // Disables the button to prevent multiple clicks
        button.disabled = true;

        // Manually submits the form after disabling the button
        // 'event.target' refers to the button clicked, so we use 'closest('form')' to find the closest form element
        event.target.closest('form').submit();
    }
</script>

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Show Post') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-8 py-12">

        {{-- Title --}}
        <h1 class="text-5xl font-extrabold text-white text-center mb-6">
            {{ $post->title }}
        </h1>

        {{-- Image --}}
        @if($post->image)
            <div class="mb-8 flex justify-center">
                <div class="relative overflow-hidden rounded-lg shadow-xl w-4/5 h-96">
                    <img 
                        src="{{ filter_var($post->image, FILTER_VALIDATE_URL) 
                            ? $post->image 
                            : asset('storage/'.$post->image) }}"
                        class="w-full h-96 object-cover"
                    >
                </div>
            </div>
        @endif

        {{-- Post Info --}}
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">

            <div class="flex items-center mb-4">
                <img 
                    src="{{ $post->user->image 
                        ? asset('storage/'.$post->user->image) 
                        : asset('storage/images/user_image.png') }}"
                    class="w-10 h-10 rounded-full object-cover mr-2"
                >

                <span class="text-white text-2xl">
                    {{ $post->user->name }}
                </span>
            </div>

            <p class="text-gray-300">
                <strong>Category:</strong>
                {{ $post->category?->name }}
            </p>

            <p class="text-gray-200 mt-4 text-lg">
                {{ $post->content }}
            </p>

        </div>

        {{-- Comment Form --}}
        @can('create', App\Models\Comment::class)
            @auth
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-8">
                    <x-comment.form parentType="post" :parentId="$post->id" />
                </div>
            @endauth
        @endcan

        {{-- Comments --}}
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">

            <h3 class="text-2xl text-white mb-4">Comments</h3>

            @forelse($comments as $comment)
                <div class="bg-gray-700 p-4 rounded-md mb-4">

                    <div class="flex items-center mb-2">
                        <img 
                            src="{{ $comment->user->image 
                                ? asset('storage/'.$comment->user->image)
                                : asset('storage/images/user_image.png') }}"
                            class="w-10 h-10 rounded-full mr-2"
                        >

                        <span class="text-gray-200 font-bold">
                            {{ $comment->user->name }}
                        </span>
                    </div>

                    <p class="text-gray-300">
                        {{ $comment->content }}
                    </p>

                    <p class="text-sm text-gray-400 mt-2">
                        {{ $comment->created_at->diffForHumans() }}
                    </p>

                    {{-- Actions --}}
                    <div class="flex justify-end space-x-4 mt-4">

                        @can('update', $comment)
                            <a href="{{ route('comments.edit', $comment->id) }}"
                               class="text-yellow-400 hover:text-yellow-600">
                                Edit
                            </a>
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
            @empty
                <p class="text-gray-400">No comments yet.</p>
            @endforelse

            <div class="mt-4">
                {{ $comments->links() }}
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