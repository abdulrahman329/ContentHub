<x-app-layout>

<x-slot name="header">
    {{ __('Trashed Users') }}
</x-slot>

    {{-- Success Message --}}
    @if(session('success'))
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

            <x-ui.buttons.actions.link href="{{ route('users.create') }}">
                <x-ui.buttons.variants variant="back">
                    Back
                </x-ui.buttons.variants>
            </x-ui.buttons.actions.link>

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

                            {{-- RESTORE --}}
                            <x-ui.buttons.actions.form
                                action="{{ route('users.restore', $user->id) }}"
                                method="POST">
                                <x-ui.buttons.variants variant="restore">
                                    Restore
                                </x-ui.buttons.variants>
                            </x-ui.buttons.actions.form>

                            {{-- FORCE DELETE --}}
                            <x-ui.buttons.actions.form
                                action="{{ route('users.forceDelete', $user->id) }}"
                                method="DELETE">
                                <x-ui.buttons.variants variant="danger">
                                    Delete Forever
                                </x-ui.buttons.variants>
                            </x-ui.buttons.actions.form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="mt-8">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-app-layout>