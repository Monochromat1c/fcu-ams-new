@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/maintenance.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Maintenance</h1>
            <a href="{{ route('profile.index') }}" class="flex gap-3" style="min-width:100px;">
                <!-- <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset=""> -->
                <div>
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset('storage/app/public/profile_pictures/' . auth()->user()->profile_picture) }}"
                            alt="Profile Picture" class="w-14 h-14 rounded-full mx-auto">
                    @else
                        <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                            class="w-14 h-14 rounded-full mx-auto">
                    @endif
                </div>
                <p class="my-auto">
                    {{ (auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'N/A') }}
                </p>
            </a>
        </nav>
        <div class="m-3">
            @if(session('success'))
                <div
                    class="successMessage bg-green-100 border border-green-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div
                    class="errorMessage bg-red-100 border border-red-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">Maintenance List</h2>
                <div class="flex align-items-center gap-1">
                    <!-- <a href="{{ route('asset.list') }}" class="rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Back to Asset List</a> -->
                </div>
            </div>
            @if($assets->where('condition.condition', 'Maintenance')->isEmpty())
                <p class="text-center text-xl text-gray-500">No assets under maintenance.</p>
            @else
                <div class="overflow-x-auto overflow-y-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">ID</th>
                                <th class="px-4 py-2 text-center bg-slate-100 border border-slate-400">Asset Image</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Asset Name</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Brand</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Model</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Serial Number</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Cost</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Supplier</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Site</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Location</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Category</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Department</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Condition</th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Start of Maintenance</th>
                                <th class="px-4 py-2 text-center bg-slate-100 border border-slate-400">Action</th>
                                <!-- <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400 text-center">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                                <tr>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->id }}</td>
                                    <td class="border border-slate-300 px-4 py-2 min-width">
                                        @if($asset->asset_image)
                                            <img src="{{ asset($asset->asset_image) }}" alt="Asset Image"
                                                class="mx-auto rounded-full" style="width:2.7rem;height:2.7rem;">
                                        @else
                                            <img src="{{ asset('profile/defaultIcon.png') }}"
                                                alt="Default Image" class="w-14 h-14 rounded-full mx-auto">
                                        @endif
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->asset_name }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->brand }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->model }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->serial_number }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->cost }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->supplier->supplier }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->site->site }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->location->location }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->category->category }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">
                                        {{ $asset->department->department }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->condition->condition }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->maintenance_start_date }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">
                                        <div class="mx-auto flex">
                                            <form
                                                action="{{ route('asset.finishMaintenance', $asset->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="rounded-md shadow-md px-5 py-2 flex my-auto gap-1 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>

                                                    Done
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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

@endsection