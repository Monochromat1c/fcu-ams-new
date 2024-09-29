@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/addAsset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Add Category</h1>
            <a href="{{ route('profile.index') }}" class="flex space-x-1" style="min-width:100px;">
                <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset="">
                <p class="my-auto">Lighttt</p>
            </a>
        </nav>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
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
        <h3 class="text-lg font-semibold mb-3">Category Details</h3>
            <form action="{{ route('categories.add.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" id="category" name="category"
                        class="block w-full p-2 mt-1 text-sm text-gray-700 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="space-x-2 flex">
                    <a href="{{ route('categories.list') }}" class="ml-auto rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Back</a>
                    <button type="submit" class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                        Category</button>
                </div>
            </form>
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

@endsection
