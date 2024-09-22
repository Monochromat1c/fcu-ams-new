@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Profile</h1>
            <a href="" class="flex space-x-1" style="min-width:100px;">
                <svg class="h-10 w-10 my-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <p class="my-auto">Lighttt</p>
            </a>
        </nav>
        <div class="content-area mx-3">
            <div class="bg-white rounded-lg shadow-md p-6 mb-3">
                <h2 class="text-2xl mb-2">User Profile</h2>
                <div class="flex flex-col">
                    <div class="flex flex-row mb-3">
                        <label class="mr-3">Profile Picture:</label>
                        <div class="border border-slate-300 px-4 py-2">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                    alt="Profile Picture" class="mx-auto rounded-full"
                                    style="width:2.7rem;height:2.7rem;">
                            @else
                                <img src="{{ asset('profile/default.png') }}" alt="Default Image"
                                    class="w-14 h-14 rounded-full mx-auto">
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-row mb-3">
                        <label class="mr-3">Name:</label>
                        <p class="text-slate-600">
                            {{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}
                        </p>
                    </div>
                    <div class="flex flex-row mb-3">
                        <label class="mr-3">Address:</label>
                        <p class="text-slate-600">{{ $user->address }}</p>
                    </div>
                    <div class="flex flex-row mb-3">
                        <label class="mr-3">Contact Number:</label>
                        <p class="text-slate-600">{{ $user->contact_number }}</p>
                    </div>
                    <div class="flex flex-row mb-3">
                        <label class="mr-3">Email:</label>
                        <p class="text-slate-600">{{ $user->email }}</p>
                    </div>
                    <div class="flex flex-row mb-3">
                        <label class="mr-3">Username:</label>
                        <p class="text-slate-600">{{ $user->username }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 mb-3">
                <h2 class="text-2xl mb-2">Change Password</h2>
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="flex flex-col mb-3">
                        <label class="mr-3">Current Password:</label>
                        <input type="password" name="current_password" class="rounded-md border border-gray-300 p-2" required>
                    </div>
                    <div class="flex flex-col mb-3">
                        <label class="mr-3">New Password:</label>
                        <input type="password" name="new_password" class="rounded-md border border-gray-300 p-2"
                            required>
                    </div>
                    <div class="flex flex-col mb-3">
                        <label class="mr-3">Confirm New Password:</label>
                        <input type="password" name="confirm_new_password"
                            class="rounded-md border border-gray-300 p-2" required>
                    </div>
                    <button type="submit" class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    function confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('logout-form').submit();
        }
    }

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the current URL
        var currentUrl = window.location.href;
        // Get all dropdown buttons
        var dropdownButtons = document.querySelectorAll('.relative button');
        // Loop through each dropdown button
        dropdownButtons.forEach(function (button) {
            // Get the dropdown links
            var dropdownLinks = button.nextElementSibling.querySelectorAll('a');
            // Loop through each dropdown link
            dropdownLinks.forEach(function (link) {
                // Check if the current URL matches the link's href
                if (currentUrl === link.href) {
                    // Open the dropdown
                    button.click();
                }
            });
        });
    });

</script>
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this asset?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

</script>
<script>
    function clearSearch() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('form').submit();
    }

</script>
<script>
    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (window.performance.navigation.type === 1 && urlParams.has('search')) {
            window.location.href = "{{ route('asset.list') }}";
        }
    };

</script>

@endsection
