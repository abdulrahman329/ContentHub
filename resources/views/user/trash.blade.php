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

            @foreach($users as $user)

                <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl flex justify-between items-center hover:bg-gray-750 transition shadow-lg">

                    {{-- user info --}}
                    <div class="flex items-center gap-6">

                        {{-- User Image --}}
                        <img
                            src="{{ $user->image_url }}"
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