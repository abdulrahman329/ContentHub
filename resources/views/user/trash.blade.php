<x-app-layout>

<x-slot name="header">
    {{ __('Trashed Users') }}
</x-slot>

    {{-- Success Message --}}
    @if(session('success'))
            <x-ui.buttons.actions.link
                href="{{ route('users.create') }}">       
                    <x-ui.buttons.variants variant="back">
                    back
                    </x-ui.buttons.variants>
            </x-ui.buttons.actions.link>
    </div>

    {{-- Empty state --}}
    @if($users->isEmpty())
        <div class="bg-gray-800 text-gray-300 p-10 rounded-xl text-center text-lg">
            No deleted users found.
        </div>
    @else

        {{-- Users list --}}
        <div class="space-y-6">
        <x-ui.alert>
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <div class="max-w-7xl mx-auto py-8 space-y-8
                text-gray-900 dark:text-gray-100">

        {{-- TITLE --}}
        <div class="flex justify-between items-center">

            <h3 class="text-2xl font-bold">
                Deleted Users
            </h3>


        </div>

        {{-- EMPTY --}}
        @if($users->isEmpty())

            <div class="bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-800
                        p-10 rounded-xl text-center text-lg">
                No deleted users found.
            </div>

        @else

            {{-- LIST --}}
            <div class="space-y-5">

                @foreach($users as $user)

                    <div class="flex justify-between items-center
                                bg-gray-50 dark:bg-gray-800
                                border border-gray-200 dark:border-gray-700
                                rounded-xl p-5
                                hover:border-blue-400 hover:shadow-md
                                transition">

                        {{-- LEFT --}}
                        <div class="flex items-center gap-5">
                            <img
                                src="{{ $user->image_url }}"
                                class="w-14 h-14 rounded-full object-cover
                                       border border-gray-300 dark:border-gray-600"
                                alt="{{ $user->name }}">
                            <div>
                                <p class="text-lg font-bold">
                                    {{ $user->name }}
                                </p>

                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->email }}
                                </p>

                                {{-- ROLES --}}
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($user->roles as $role)
                                        <span class="text-xs px-3 py-1 rounded-full
                                                     bg-blue-100 text-blue-700
                                                     dark:bg-blue-600 dark:text-white">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT --}}
                        <div class="flex items-center gap-3">

                    {{-- Actions --}}
                    <div class="flex items-center gap-6 text-lg">

                        {{-- Restore --}}
                        <x-ui.buttons.actions.form
                            action="{{ route('users.restore', $user->id) }}">       
                                <x-ui.buttons.variants variant="restore">
                                Restore
                                </x-ui.buttons.variants>
                        </x-ui.buttons.actions.form>

                        {{-- Force Delete --}}
                        <x-ui.buttons.actions.form
                            action="{{ route('users.forceDelete', $user->id) }}">       
                                <x-ui.buttons.variants variant="danger">
                                Delete Forever
                                </x-ui.buttons.variants>
                        </x-ui.buttons.actions.form>
                    </div>

                </div>

            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $users->links() }}
        </div>

    @endif
</x-app-layout>