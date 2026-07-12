<x-layouts.app :title="'Edit Profile'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">Edit Profile</h1>
                <p class="page-subtitle">Update your personal information</p>
            </div>
            <a href="{{ route('profile.show') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back to Profile
            </a>
        </div>
    </div>

    <div class="max-w-3xl">
        <x-card title="Profile Information" subtitle="Update your name, email, and other details">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" data-loading class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Profile Photo --}}
                <div class="form-group">
                    <label class="form-label">Profile Photo</label>
                    <div class="flex items-center gap-5">
                        <img id="profile-photo-preview" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                             class="w-20 h-20 rounded-full object-cover ring-4 ring-primary-100 shadow-md">
                        <div>
                            <label for="profile-photo-input" class="btn-secondary btn-sm cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>
                                Change Photo
                            </label>
                            <input id="profile-photo-input" type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" class="hidden">
                            <p class="text-xs text-gray-400 mt-1.5">JPEG, PNG, or WebP. Max 2MB.</p>
                        </div>
                    </div>
                    @error('profile_photo')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Name --}}
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="form-input" placeholder="Your full name">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required
                           class="form-input" placeholder="your_username">
                    @error('username')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="form-input" placeholder="you@example.com">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="form-input" placeholder="+62 812 3456 7890">
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" name="address" rows="3"
                              class="form-input" placeholder="Your address">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Save Changes
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
