<x-app-layout>

    {{-- HEADER --}}
        <x-slot name="header">    
            {{ __('Manage Users') }}
        </x-slot>

<div class="max-w-7xl mx-auto py-8 space-y-8
                text-gray-900 dark:text-gray-100">

{{-- USERS LIST --}}
        <div class="bg-white dark:bg-gray-900
                    border border-gray-200 dark:border-gray-800
                    rounded-2xl p-6 shadow-lg">

                    <div class="flex justify-center ">
            <x-ui.buttons.actions.link href="{{ route('users.create') }}">
                    <x-ui.buttons.variants variant="create">
                        create users
                    </x-ui.buttons.variants>
                </x-ui.buttons.actions.link>
        </div>

            <h2 class="text-xl font-bold">
                Existing Users
            </h2>

            {{-- Recycle Bin --}}
            <div class=" pb-6 flex justify-end">
                <x-ui.buttons.actions.link href="{{ route('users.trash') }}">
                    <x-ui.buttons.variants variant="trash">
                        🗑 Recycle Bin ({{ $trashedCount }})
                    </x-ui.buttons.variants>
                </x-ui.buttons.actions.link>
            </div>
            <div class="space-y-5">
                @foreach ($users as $user)
                    <div class="flex items-center justify-between
                                bg-gray-50 dark:bg-gray-800
                                border border-gray-200 dark:border-gray-700
                                rounded-xl p-5
                                hover:shadow-md hover:border-blue-400
                                transition">

                        {{-- LEFT LIST --}}
                        <div class="flex items-center gap-5">
                            <img
                                src="{{ $user->image_url }}"
                                class="w-14 h-14 rounded-full object-cover
                                       border border-gray-300 dark:border-gray-600">    
                            <div>
                                <p class="text-lg font-bold">
                                    {{ $user->name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->email }}
                                </p>
                                <p class="text-xs mt-2 text-blue-600 dark:text-blue-400">
                                    {{ $user->roles->pluck('name')->join(', ') }}
                                </p>
                            </div>
                        </div>

                        {{-- RIGHT ACTIONS --}}
                        <div class="flex items-center gap-3">
                            @can('update', $user)
                                <x-ui.buttons.actions.link href="{{ route('users.edit', $user->id) }}">
                                    <x-ui.buttons.variants variant="show-edit">
                                        Edit
                                    </x-ui.buttons.variants>
                                </x-ui.buttons.actions.link>
                            @endcan
                            @can('delete', $user)
                                <x-ui.buttons.actions.form
                                    action="{{ route('users.destroy', $user->id) }}"
                                    method="DELETE">
                                    <x-ui.buttons.variants variant="show-delete">
                                        Delete
                                    </x-ui.buttons.variants>
                                </x-ui.buttons.actions.form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Pagination --}}
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
</div>
</x-app-layout>