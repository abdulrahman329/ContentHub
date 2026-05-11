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

    {{-- Title --}}
    <div class="flex justify-between items-center mb-10">
        <h3 class="text-3xl font-bold text-white">Deleted Users</h3>

        <a href="{{ route('users.create') }}"
           class="bg-blue-600 hover:bg-blue-800 text-white px-6 py-3 rounded-md text-lg transition">
            Back
        </a>
    </div>

    {{-- Empty state --}}
    @if($users->isEmpty())
        <div class="bg-gray-800 text-gray-300 p-10 rounded-xl text-center text-lg">
            No deleted users found.
        </div>
    @else

        {{-- Users list --}}
        <div class="space-y-6">

            @foreach($users as $user)

                <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl flex justify-between items-center hover:bg-gray-750 transition shadow-lg">

                    {{-- user info --}}
                    <div class="flex items-center gap-6">

                        {{-- User Image --}}
                        <img
                            src="{{ $user->image 
                                ? asset('storage/'.$user->image) 
                                : asset('storage/images/user_image.png') }}"
                            class="w-16 h-16 rounded-full object-cover border-2 border-gray-600"
                            alt="{{ $user->name }}"
                        >

                        {{-- Info --}}
                        <div>
                            <p class="text-xl font-bold text-white">{{ $user->name }}</p>
                            <p class="text-sm text-gray-400">{{ $user->email }}</p>

                            {{-- Roles --}}
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($user->roles as $role)
                                    <span class="text-xs bg-blue-600 text-white px-3 py-1 rounded-full">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-6 text-lg">

                        {{-- Restore --}}
                        <form method="POST" action="{{ route('users.restore', $user->id) }}">
                            @csrf
                            <button class="text-green-400 hover:text-green-300 font-semibold">
                                Restore
                            </button>
                        </form>

                        {{-- Force Delete --}}
                        <form method="POST" action="{{ route('users.forceDelete', $user->id) }}"
                              onsubmit="return confirm('Are you sure you want to permanently delete this user?')">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-500 hover:text-red-400 font-semibold">
                                Delete Forever
                            </button>
                        </form>

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