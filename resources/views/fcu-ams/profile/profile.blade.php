@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div x-data="{ sidebarOpen: true }" class="grid grid-cols-6">
    <div x-show="sidebarOpen" class="col-span-1">
        @include('layouts.sidebar')
    </div>
    <div :class="{ 'col-span-5': sidebarOpen, 'col-span-6': !sidebarOpen }" class="content min-h-screen bg-gray-100">
        <!-- Header -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 2xl:max-w-7xl 2xl:mx-auto shadow-md rounded-md">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="my-auto text-3xl">Profile</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">Member since {{ $user->created_at->format('F j, Y') }}</span>
            </div>
        </nav>

        <div class="m-3 2xl:max-w-7xl 2xl:mx-auto">
            <div class="mb-4">
                @include('layouts.messageWithoutTimerForError')
            </div>

            <!-- Profile Content -->
            <div class="space-y-6">
                <!-- Personal Information Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <form method="POST" action="{{ route('profile.updatePersonalInformation') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Profile Header -->
                        <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600">
                            <div class="flex items-center">
                                <div class="relative group">
                                    <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg cursor-pointer hover:opacity-90 transition-all duration-300"
                                        onclick="document.getElementById('profile-picture-input').click();">
                                        @if(auth()->user()->profile_picture)
                                            <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                                class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                                                class="w-full h-full object-cover">
                                        @endif
                                        <input type="file" id="profile-picture-input" name="profile_picture" accept="image/*"
                                            class="hidden" onchange="this.form.submit();">
                                        
                                        <!-- Camera Icon Overlay -->
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-8 h-8 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <h2 class="text-2xl font-bold text-white">
                                        {{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}
                                    </h2>
                                    <p class="text-blue-100 mt-1">{{ $user->email }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="px-3 py-1 bg-blue-700 text-white text-sm rounded-full">
                                            {{ $user->role->role }}
                                        </span>
                                        <span class="mx-2 text-blue-100">•</span>
                                        <span class="text-blue-100">{{ $user->department->department }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Information -->
                        <div class="p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Personal Information -->
                                <div class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Personal Information
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors duration-300">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                            <input type="text" name="full_name"
                                                value="{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors duration-300">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors duration-300">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                            <input type="text" name="contact_number" value="{{ $user->contact_number }}"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors duration-300">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                            <input type="text" name="address" value="{{ $user->address }}"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Information -->
                                <div class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Account Information
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                            <p class="text-gray-800 py-2 font-semibold">{{ $user->department->department }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                            <p class="text-gray-800 py-2 font-semibold">{{ $user->username }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                            <p class="text-gray-800 py-2 font-semibold">{{ $user->role->role }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Member Since</label>
                                            <p class="text-gray-800 py-2 font-semibold">{{ $user->created_at->format('F j, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="mt-8 flex justify-end">
                                <button type="submit" 
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-500 
                                    transition-all duration-300 transform hover:scale-105 flex items-center gap-2 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Change Password Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-purple-500 to-purple-600">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Change Password
                        </h3>
                    </div>
                    <div class="p-8">
                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-purple-400 transition-colors duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                    <input type="password" name="current_password" 
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300" required>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-purple-400 transition-colors duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" name="new_password" 
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300" required>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-purple-400 transition-colors duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                    <input type="password" name="confirm_new_password"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300" required>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" 
                                    class="px-6 py-3 bg-purple-600 text-white rounded-lg shadow-md hover:bg-purple-500 
                                    transition-all duration-300 transform hover:scale-105 flex items-center gap-2 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection