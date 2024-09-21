@extends('layouts.layout')
@section('content')
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
                    <input type="password" name="password" placeholder="PASSWORD">
                </div>
                <div class="flex justify-between mb-3">
                    <div>
                        <!-- <a href="#">Sign Up</span></a> -->
                    </div>
                    <div>
                        <a href="#" class="text-red-700">Forgot Password</a>
                    </div>
                </div>
                <button type="submit" class="flex justify-center w-full bg-blue-900 p-3 rounded-lg">
                    <label for="" class="text-white">Sign In</label>
                </button>
                <div class="my-4 flex justify-center items-center">
                    <div class="w-1/2 relative">
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-px bg-black w-full"></div>
                    </div>
                    <span class="mx-2">or</span>
                    <div class="w-1/2 relative">
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-px bg-black w-full"></div>
                    </div>
                </div>
                <a href="#" class="w-full flex justify-center bg-green-700 p-3 rounded-lg">
                    <label for="" class="text-white">Create New Account</label>
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
