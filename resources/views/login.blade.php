@extends('layouts.layout')
@section('content')
<script>
    function preventBack() {
        window.history.forward()
    };
    setTimeout("preventBack()", 0);
    window.onunload = function () {
        null;
    }

    function togglePassword() {
        const password = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');
        
        if (password.type === 'password') {
            password.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            password.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="body min-h-screen p-5 flex align-items-center justify-center">
    <div class="login-container flex align-items-center justify-center bg bg-transparent rounded-lg p-5">
        <div class="form-container">
            <form class="login-form rounded-lg shadow-md shadow-black p-5 flex"
                action="{{ route('login.submit') }}" method="post">
                @csrf
                <img class="fcu-icon mb-3" src="/img/login/fcu-icon.png" alt="" srcset="">
                <h1 class=" text-blue-900 text-center text-5xl">FCU</h1>
                <h2 class=" text-blue-900 text-center text-2xl mb-5">Asset Management System</h2>
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
                <div class="input-container mb-3">
                    <label class="icon" for="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                clip-rule="evenodd" />
                        </svg>
                    </label>
                    <input type="text" name="username" placeholder="USERNAME"
                        value="{{ old('username') }}">
                </div>
                <div class="input-container mb-3">
                    <label class="icon" for="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M15.75 1.5a6.75 6.75 0 0 0-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 0 0-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 0 0 .75-.75v-1.5h1.5A.75.75 0 0 0 9 19.5V18h1.5a.75.75 0 0 0 .53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1 0 15.75 1.5Zm0 3a.75.75 0 0 0 0 1.5A2.25 2.25 0 0 1 18 8.25a.75.75 0 0 0 1.5 0 3.75 3.75 0 0 0-3.75-3.75Z"
                                clip-rule="evenodd" />
                        </svg>
                    </label>
                    <input type="password" name="password" id="password" placeholder="PASSWORD">
                    <button type="button" onclick="togglePassword()" class="eye-icon absolute right-3 top-1/2 -translate-y-1/2">
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>
                </div>
                <div class="flex justify-between mb-3">
                    <div>
                        <!-- <a href="#">Sign Up</span></a> -->
                    </div>
                    <!-- <div>
                        <a href="#" class="text-red-700">Forgot Password</a>
                    </div> -->
                </div>
                <button type="submit" class="flex justify-center w-full bg-blue-900 p-3 rounded-lg">
                    <label for="" class="text-white">Sign In</label>
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
                <a href="{{ route('signup') }}" class="w-full flex justify-center bg-green-700 p-3 rounded-lg">
                    <label for="" class="text-white">Create New Account</label>
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
