<x-app-layout>
    <!-- Header Section: Displays the title 'News' -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('News') }} <!-- Title of the page, displayed in the header -->
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Main Title: 'Latest News' -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Latest News</h1>

        <!-- Category Filter -->
        <div class="text-center mb-6">
            <form action="{{ route('News.index') }}" method="GET">
                <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300">
                    <option value="">All Categories</option>
                    <!-- Loop through each category to create an option for each one -->
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            @if(request('category_id') == $category->id) selected @endif
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md">
                    Filter
                </button>
            </form>
        </div>

        <!-- Button to Create News -->
        <div class="text-center mb-6">
        @if(Auth::user()->hasRole('writer') || Auth::user()->hasRole('admin'))
        <a href="{{ route('News.create') }}" class="inline-block bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-md shadow-md transform hover:scale-105 transition-all duration-200 ease-in-out">
                Create News
            </a>
            @endif
        </div>

        <!-- Check if there is any news available -->
        @if($News->isEmpty())
            <!-- If no news available, display this message -->
            <div class="text-center text-gray-500 text-lg">No news available. Please create one.</div>
        @else
            <!-- Display News Articles -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($News as $new)
                    <!-- Card for each News Article -->
                    <div class="bg-gray-800 text-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                        
                        <!-- News Image -->
                        @if($new->image)
                            <a href="{{ route('News.show', $new->id) }}">
                                <!-- Display the image if it exists -->
                                <img src="{{ filter_var($new->image, FILTER_VALIDATE_URL) ? $new->image : asset('storage/'.$new->image) }}" alt="{{ $new->title }}" class="w-full h-56 object-cover rounded-t-lg">
                            </a>
                        @endif

                        <!-- News Content Section -->
                        <div class="px-6 py-4 flex-grow">
                            <div class="font-bold text-xl mb-2 line-clamp-2">{{ $new->title }}</div>
                            <p class="text-gray-300 text-sm line-clamp-2">
                                <!-- Limit content preview to 100 characters -->
                                {{ Str::limit($new->content, 100, '...') }}
                            </p>
                        </div>

                        <!-- Action Buttons at the Bottom of the Card -->
                        <div class="px-6 pb-4 mt-auto">
                            <div class="space-y-2">
                                <p>
                                <!-- View Button: Takes the user to the full news page -->
                                <a href="{{ route('News.show', $new->id) }}" class="inline-block bg-blue-600 text-black py-2 px-4 rounded-lg hover:bg-blue-800 transform transition-all duration-200 ease-in-out w-full text-center">
                                    View
                                </a>
                                </p>

                                <!-- Conditional Edit/Delete Buttons (only if the logged-in user is the author or admin) -->
                                @if(Auth::id() === $new->user_id || Auth::user()->hasRole('admin'))
                                <div class="grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

                                    <!-- Edit Button: Redirects to the edit form for the news -->
                                    <p>
                                    <a href="{{ route('News.edit', $new->id) }}" class="inline-block bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-700 transform transition-all duration-200 ease-in-out w-full mt-2 text-center">
                                        Edit
                                    </a>
                                    </p>

                                    <!-- Delete Button: Allows the user to delete the news article -->
                                    <form action="{{ route('News.destroy', $new->id) }}" method="POST" class="inline-block w-full">
                                        @csrf
                                        @method('DELETE') <!-- Spoofing the DELETE method -->
                                        <button type="submit" class="bg-red-600 text-black py-2 px-4 rounded-lg hover:bg-red-800 transform transition-all duration-200 ease-in-out w-full mt-2 text-center" onclick="return confirm('Are you sure you want to delete this News?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                @endif

                                <!-- Show the number of comments on the news article -->
                                <div class="mt-2 text-gray-400 text-sm">
                                <p class="text-lg text-gray-300 mt-4 line-clamp-2"><strong>Category Name:</strong> 
                                <span class="text-gray-400">{{ $new->category->name }}</span></p>
                                    <strong>Comments:</strong> {{ $new->comments_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class='p-4'>
    {{ $News->links() }}  <!-- This will display the pagination links -->
</div>
    </div>
</x-app-layout>
