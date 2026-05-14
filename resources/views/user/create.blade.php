<x-app-layout>
    <!-- Header -->
    <x-slot name="header">    
        {{ __('Create User') }}
    </x-slot>

        {{-- Success Message --}}
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        {{-- Create User --}}
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8 border border-gray-700">
                <h3 class="text-3xl text-white mb-6">Create User</h3>
                <x-user.form :roles="$roles" />
            </div>

        {{-- Existing Users --}}
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700">

                {{-- Header + Trash Button --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl text-white">Existing Users</h3>
                        <x-ui.buttons.actions.link
                            href="{{ route('users.trash') }}">
                                <x-ui.buttons.variants variant="trash">
                                    🗑 Recycle Bin ({{ $trashedCount }})                                    
                                </x-ui.buttons.variants>
                        </x-ui.buttons.actions.link>
                </div>

                {{-- Users List --}}
                <ul class="space-y-6">
                    @foreach ($users as $user)

                        <li class="flex justify-between items-center bg-gray-700 p-5 rounded-lg shadow">

                            {{-- Left: User Info --}}
                            <div class="flex items-center gap-4 flex-1">

                                {{-- Image --}}
                                <img
                                    src="{{ $user->image_url }}"
                                    class="w-14 h-14 rounded-full object-cover border border-gray-600"
                                    alt="{{ $user->name }}"
                                >

                                {{-- Info --}}
                                <div>
                                    <p class="text-xl font-bold text-white">
                                        {{ $user->name }}
                                    </p>

                                    <p class="text-gray-300 text-sm">
                                        {{ $user->email }}
                                    </p>

                                    {{-- Roles --}}
                                    <div class="mt-2">
                                        <span class="text-blue-400 text-sm font-medium">
                                            {{ $user->roles->pluck('name')->join(', ') }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                            {{-- Right: Actions --}}
                            <div class="flex items-center gap-5 ml-4 text-lg">

                                @can('update', $user)
                                    <x-ui.buttons.actions.link
                                        href="{{ route('users.edit', $user->id) }}">
                                            <x-ui.buttons.variants variant="warning">
                                                Edit
                                            </x-ui.buttons.variants>
                                    </x-ui.buttons.actions.link>
                                @endcan 

                                @can('delete', $user)
                                    <x-ui.buttons.actions.form
                                        action="{{ route('users.destroy', $user->id) }}"
                                        method="DELETE"
                                    >
                                            <x-ui.buttons.variants variant="danger">
                                                Delete
                                            </x-ui.buttons.variants>
                                    </x-ui.buttons.actions.form>
                                @endcan
                            </div>
                        </li>
                    @endforeach
                </ul>
                
            {{-- Pagination --}}
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
</x-app-layout>