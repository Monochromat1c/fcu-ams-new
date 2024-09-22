@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/signup.css') }}">

<div class="body min-h-screen p-5 flex align-items-center justify-center">
    <div class="login-container flex align-items-center justify-center bg bg-transparent rounded-lg p-5">
        <div class="form-container">
            <form class="login-form rounded-lg shadow-md shadow-black p-5 flex"
                action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- <img class="fcu-icon mb-3" src="/img/login/fcu-icon.png" alt="" srcset=""> -->
                <h1 class=" text-blue-900 text-center text-5xl">FCU</h1>
                <h2 class=" text-blue-900 text-center text-2xl">Asset Management System</h2>
                <h2 class=" text-2xl my-3">Create New Account:</h2>
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-2 col-span-2">
                        <label for="profile_picture" class="block text-gray-700 font-bold mb-2">Profile Picture:</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="w-full border rounded-md">
                    </div>
                    <div class="mb-2">
                        <label for="first_name" class="block text-gray-700 font-bold mb-2">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="w-full p-2 border rounded-md"
                            required>
                    </div>
                    <div class="mb-2">
                        <label for="middle_name" class="block text-gray-700 font-bold mb-2">Middle Name:</label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mb-2">
                        <label for="last_name" class="block text-gray-700 font-bold mb-2">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" class="w-full p-2 border rounded-md"
                            required>
                    </div>
                    <div class="mb-2">
                        <label for="address" class="block text-gray-700 font-bold mb-2">Address:</label>
                        <input type="text" id="address" name="address" class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-2">
                        <label for="contact_number" class="block text-gray-700 font-bold mb-2">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number"
                            class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-2">
                        <label for="role_id" class="block text-gray-700 font-bold mb-2">Role:</label>
                        <select id="role_id" name="role_id" class="w-full p-2 border rounded-md" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                        <input type="email" id="email" name="email" class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-2">
                        <label for="username" class="block text-gray-700 font-bold mb-2">Username:</label>
                        <input type="text" id="username" name="username" class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
                        <input type="password" id="password" name="password" class="w-full p-2 border rounded-md"
                            required>
                    </div>
                    <div class="mb-2">
                        <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm
                            Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full p-2 border rounded-md" required>
                    </div>
                </div>
                <button type="submit" class="flex justify-center w-full bg-green-700 p-3 rounded-lg mt-3">
                    <label for="" class="text-white">Sign Up</label>
                </button>
                <div class="my-2 flex justify-center items-center">
                    <div class="w-1/2 relative">
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-px bg-black w-full"></div>
                    </div>
                    <span class="mx-2">or</span>
                    <div class="w-1/2 relative">
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-px bg-black w-full"></div>
                    </div>
                </div>
                <a href="{{ route('login') }}"
                    class="w-full flex justify-center bg-blue-900 p-3 rounded-lg">
                    <label for="" class="text-white">Sign In</label>
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
