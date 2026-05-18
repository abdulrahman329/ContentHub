<x-app-layout>

    <x-slot name="header">    
        {{ __('Deleted Comments') }}
    </x-slot>

    {{-- TITLE --}}
    <h1 class="text-3xl font-bold mb-6
        text-gray-900 dark:text-white transition-colors">
        🗑️ Deleted Comments
    </h1>

    {{-- TABLE WRAPPER --}}
    <div class="rounded-2xl shadow-lg overflow-hidden transition-colors
        bg-white border border-gray-200
        dark:bg-gray-800 dark:border-gray-700">

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="p-6 pb-0">
                <x-ui.alert>
                    {{ session('success') }}
                </x-ui.alert>
            </div>
        @endif

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left transition-colors">

                {{-- HEAD --}}
                <thead class="border-b
                    border-gray-200 bg-gray-50
                    dark:border-gray-700 dark:bg-gray-900/40">
                    <tr>
                        <th class="py-4 px-6 font-semibold
                            text-gray-700 dark:text-gray-300">
                            Content
                        </th>
                        <th class="py-4 px-6 font-semibold
                            text-gray-700 dark:text-gray-300">
                            User
                        </th>
                        <th class="py-4 px-6 font-semibold
                            text-gray-700 dark:text-gray-300">
                            Deleted At
                        </th>
                        <th class="py-4 px-6 text-right font-semibold
                            text-gray-700 dark:text-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                @forelse($comments as $comment)
                    <tr class="border-b transition-colors
                        border-gray-200 hover:bg-gray-50
                        dark:border-gray-700 dark:hover:bg-gray-900/40">
                        {{-- CONTENT --}}
                        <td class="py-4 px-6
                            text-gray-800 dark:text-gray-200 
                            break-words break-all whitespace-pre-line">
                            {{ ($comment->content) }}
                        </td>
                        {{-- USER --}}
                        <td class="py-4 px-6
                            text-gray-700 dark:text-gray-300">
                            {{ $comment->user?->name ?? 'Deleted User' }}
                        </td>
                        {{-- DATE --}}
                        <td class="py-4 px-6 text-sm
                            text-gray-500 dark:text-gray-400">
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
                        <td colspan="4" class="p-8">
                            <x-ui.empty-state
                                message="No deleted comments." />
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{-- PAGINATION --}}
        <div class="p-6 border-t
            border-gray-200 dark:border-gray-700">
            {{ $comments->links() }}
        </div>
</x-app-layout>