@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/signup.css') }}">


<div class="min-h-screen bg-picture flex items-center justify-center p-6">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="md:flex">
            <!-- Left Side - Decorative Background -->
            <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-green-700 to-purple-600 relative">
                <div class="absolute inset-0 opacity-70 bg-pattern"></div>
                <div class="relative z-10 p-10 text-white flex flex-col justify-center h-full">
                    <h1 class="text-4xl font-bold mb-4">Welcome to FCU</h1>
                    <p class="text-xl mb-6">Asset Management System</p>
                    <div class="bg-white/20 p-4 rounded-xl">
                        <p class="italic">Create your account and get started with managing assets efficiently.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Signup Form -->
            <div class="w-full md:w-1/2 p-8">
                <form action="{{ route('users.signup') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <div class="text-center mb-6">
                        <h2 class="text-3xl font-bold text-gray-800">Create New Account</h2>
                        <p class="text-gray-500">Enter your details to get started</p>
                    </div>

                    @include('layouts.messageWithoutTimerForError')

                    <!-- Profile Picture Upload -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                        <div class="flex items-center justify-center w-full">
                            <label
                                class="flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group">
                                <div class="flex flex-col items-center justify-center pt-7 cursor-pointer">
                                    <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="lowercase text-sm text-gray-400 group-hover:text-purple-600 pt-1">Select a
                                        photo</p>
                                </div>
                                <input type="file" class="hidden" name="profile_picture" id="profile_picture" />
                            </label>
                        </div>
                    </div>

                    <!-- Name Inputs -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" required
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" name="middle_name"
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" required
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact_number" required
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" required
                            class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                    </div>

                    <!-- Account Credentials -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" required
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" required
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" required
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" required
                                class="mt-1 block px-4 py-2 border-2 border-gray-200 w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                            Create Account
                        </button>
                    </div>

                    <!-- Sign In Link -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-purple-600 hover:text-purple-700 focus:outline-none focus:underline transition-all duration-300 ease-in-out">
                                Sign In
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profilePictureInput = document.getElementById('profile_picture');
        const uploadLabel = profilePictureInput.closest('label');

        profilePictureInput.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file) {
                // Create image preview
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Remove existing preview if any
                    const existingPreview = uploadLabel.querySelector('.image-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Create image preview element
                    const imgPreview = document.createElement('img');
                    imgPreview.src = e.target.result;
                    imgPreview.classList.add('image-preview', 'absolute', 'inset-0', 'w-full',
                        'h-full', 'object-cover', 'opacity-80');

                    // Position the image preview absolutely within the label
                    imgPreview.style.position = 'absolute';
                    imgPreview.style.top = '0';
                    imgPreview.style.left = '0';
                    imgPreview.style.width = '100%';
                    imgPreview.style.height = '100%';
                    imgPreview.style.objectFit = 'cover';

                    // Hide default upload icon and text
                    const uploadIcon = uploadLabel.querySelector('svg');
                    const uploadText = uploadLabel.querySelector('p');

                    uploadIcon.classList.add('hidden');
                    uploadText.classList.add('hidden');

                    // Ensure label has relative positioning
                    uploadLabel.style.position = 'relative';

                    // Append image preview
                    uploadLabel.appendChild(imgPreview);
                }

                // Read the image file
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection