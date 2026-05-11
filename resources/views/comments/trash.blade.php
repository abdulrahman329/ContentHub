<x-app-layout>
    <x-slot name="header">    
        {{ __('Deleted Comments') }}
    </x-slot>

        {{-- Title --}}
        <h1 class="text-3xl font-bold text-white mb-6">
            🗑️ Deleted Comments
        </h1>

        {{-- Table --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
     
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

            <table class="w-full text-left text-gray-200">

                <thead>
                    <tr class="border-b border-gray-600">
                        <th class="py-2">Content</th>
                        <th class="py-2">User</th>
                        <th class="py-2">Deleted At</th>
                        <th class="py-2 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($comments as $comment)
                    <tr class="border-b border-gray-700">

                        {{-- Content --}}
                        <td class="py-3">
                            {{ Str::limit($comment->content, 50) }}
                        </td>

                        {{-- User --}}
                        <td class="py-3">
                            {{ $comment->user?->name ?? 'Deleted User' }}
                        </td>

                        {{-- Deleted At --}}
                        <td class="py-3 text-gray-400 text-sm">
                            {{ $comment->deleted_at }}
                        </td>

                        {{-- Actions --}}
                        <td class="py-3 text-right space-x-2">

                            {{-- Restore --}}
                            <form action="{{ route('comments.restore', $comment->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-800 px-3 py-1 rounded text-white text-sm">
                                    Restore
                                </button>
                            </form>

                            {{-- Force Delete --}}
                            <form action="{{ route('comments.forceDelete', $comment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Delete permanently?')"
                                        class="bg-red-600 hover:bg-red-800 px-3 py-1 rounded text-white text-sm">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            No deleted comments
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $comments->links() }}
            </div>

        </div>

        {{-- Back Button --}}
        <div class="mt-6">
            <a href="{{ route('posts.index') }}"
                class="text-white bg-blue-600 hover:bg-blue-800 px-4 py-2 rounded-md">
                Back
            </a>
        </div>
</x-app-layout>