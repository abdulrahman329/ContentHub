<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-6 py-12 overflow-hidden">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-600 text-white p-4 mb-6 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Create User --}}
        @can('create', App\Models\User::class)
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8 border border-gray-700">
                <h3 class="text-3xl text-white mb-6">Create User</h3>
                <x-user.form :roles="$roles" />
            </div>
        @endcan


        {{-- Existing Users --}}
        @can('viewAny', App\Models\User::class)
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700">

                {{-- Header + Trash Button --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl text-white">Existing Users</h3>

                    @can('viewTrash', App\Models\User::class)
                        <a href="{{ route('users.trash') }}"
                           class="bg-gray-600 hover:bg-gray-800 text-white font-bold px-5 py-2 rounded-md shadow transition">
                            🗑 Recycle Bin ({{ $trashedCount }})
                        </a>
                    @endcan
                </div>

                {{-- Users List --}}
                <ul class="space-y-6">
                    @foreach ($users as $user)

                        <li class="flex justify-between items-center bg-gray-700 p-5 rounded-lg shadow">

                            {{-- Left: User Info --}}
                            <div class="flex items-center gap-4 flex-1">

                                {{-- Image --}}
                                <img
                                    src="{{ $user->image 
                                        ? asset('storage/' . $user->image) 
                                        : asset('storage/images/user_image.png') }}"
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
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="text-yellow-400 hover:text-yellow-300 font-semibold">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete', $user)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-500 hover:text-red-400 font-semibold"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            Delete
                                        </button>
                                    </form>
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
        @endcan

    </div>
</x-app-layout>