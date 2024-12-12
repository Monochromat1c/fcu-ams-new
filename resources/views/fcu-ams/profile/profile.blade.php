@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
    <nav class="bg-white flex justify-center py-4 px-6 m-3 shadow-lg rounded-lg">
            <h1 class="my-auto text-3xl font-semibold text-center text-gray-800">Profile</h1>
        </nav>
        <div class="m-3">
            @include('layouts.messageWithoutTimerForError')
        </div>
        <div class="content-area mx-3">
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6 transition-all duration-300 hover:shadow-xl">
                <form method="POST" action="{{ route('profile.updatePersonalInformation') }}"
                    enctype="multipart/form-data">
                @csrf
                <div class="flex items-center mb-6">
                    <div class="relative px-3 py-3 mr-4 cursor-pointer bg-gray-50 border-2 border-gray-200 rounded-xl hover:bg-gray-100 transition-all duration-300"
                        onclick="document.getElementById('profile-picture-input').click();">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                class="object-cover bg-no-repeat rounded-full mx-auto w-28 h-28 shadow-md">
                        @else
                            <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                                class="w-28 h-28 object-cover bg-no-repeat rounded-full mx-auto shadow-md">
                        @endif
                        <input type="file" id="profile-picture-input" name="profile_picture" accept="image/*"
                            class="hidden" onchange="this.form.submit();">

                        <!-- Camera Icon -->
                        <div class="absolute bottom-0 right-0 mb-1 mr-1 bg-white rounded-full p-2 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-semibold text-gray-800">
                            {{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}
                        </h1>
                        <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800 mb-4">Personal Information</h1>
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="full_name"
                                        value="{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                    <input type="text" name="contact_number" value="{{ $user->contact_number }}"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" name="address" value="{{ $user->address }}"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800 mb-4">Account Information</h1>
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <p class="text-gray-800 py-2 segoe font-bold">{{ $user->username }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                    <p class="text-gray-800 py-2 segoe font-bold">{{ $user->role->role }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Member Since</label>
                                    <p class="text-gray-800 py-2 segoe font-bold">{{ $user->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-500
                        transition-all duration-300 hover:scale-105 flex items-center gap-2 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                        </svg>
                        Save
                    </button>
                </div>
                </form>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6 transition-all duration-300 hover:shadow-xl">
                <h1 class="text-xl font-bold text-gray-800 mb-6">Change Password</h1>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="new_password" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="confirm_new_password"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-500
                            transition-all duration-300 hover:scale-105 flex items-center gap-2 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
@endsection