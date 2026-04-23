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
            <form action="{{ route('news.index') }}" method="GET">
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
        @can('create', App\Models\News::class)
            <a href="{{ route('news.create') }}" class="inline-block bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-md shadow-md transform hover:scale-105 transition-all duration-200 ease-in-out">
                Create News
            </a>
         @endcan
         
        </div>
        <!-- Check if there is any news available -->
        @if($news->isEmpty())
            <!-- If no news available, display this message -->
            <div class="text-center text-gray-500 text-lg">No News available. Please create one.</div>
        @else
            <!-- Display News Articles -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($news as $newsItem)
                <x-content-card :item="$newsItem" type="news" />
                @endforeach
            </div>
        @endif
        <div class='p-4'>
    {{ $news->links() }}  <!-- This will display the pagination links -->
    </div>
</div>
</x-app-layout>
