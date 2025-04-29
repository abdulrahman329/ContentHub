<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Profile Image') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Upload a new profile picture. Only JPG, PNG, or GIF images under 2MB are allowed.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update-image') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

                <!-- Image Input -->
                <div class="mt-4">
                    <label for="image" class="block text-sm font-medium text-gray-300 mb-1">{{ __('Profile Image') }}</label>
                    <input
                        id="image"
                        name="image"
                        type="file"
                        class="w-full p-3 border border-gray-700 text-gray-300 bg-gray-900 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        accept="image/*"
                    />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <!-- Current Image Preview -->
                @if(auth()->user()->image)
                    <div class="mt-6">
                        <p class="text-sm text-gray-400 mb-2">{{ __('Current image:') }}</p>
                        <img src="{{ filter_var(auth()->user()->image, FILTER_VALIDATE_URL) ? auth()->user()->image : asset('storage/' . auth()->user()->image) }}"
                             alt="Profile Image"
                             class="w-20 h-20 object-cover rounded-full border border-gray-600"
                        >
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-400">{{ __('No image uploaded.') }}</p>
                @endif

                <!-- Submit Button -->
                <div class="mt-6">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-400 mt-2"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
</form>
</section>
