@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/viewAsset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Asset</h1>
            <a href="{{ route('profile.index') }}" class="flex space-x-1" style="min-width:100px;">
                <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset="">
                <p class="my-auto">Lighttt</p>
            </a>
        </nav>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">View Asset</h2>
                <div class="flex align-items-center gap-1">
                    <a href="{{ route('asset.list') }}"
                        class="rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Back
                        to Asset List</a>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">ID</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Asset Image</th>
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
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Purchase Date</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Condition</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->id }}</td>
                            <td class="border border-slate-300 px-4 py-2 min-width">
                                @if($asset->asset_image)
                                    <img src="{{ asset($asset->asset_image) }}" alt="Asset Image"
                                        class="mx-auto rounded-full" style="width:2.7rem;height:2.7rem;">
                                @else
                                    <img src="{{ asset('profile/default.png') }}"
                                        alt="Default Image" class="w-14 h-14 rounded-full mx-auto">
                                @endif
                            </td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->asset_name }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->brand }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->model }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->serial_number }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->cost }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->supplier->supplier }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->site->site }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->location->location }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->category->category }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->department->department }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->purchase_date }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->condition->condition }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">Edit History</h2>
                <div class="flex align-items-center gap-1"></div>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Date</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">User</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Changes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asset->editHistory as $editHistory)
                            <tr>
                                <td class="border border-slate-300 px-4 py-2">{{ $editHistory->created_at }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $editHistory->user->first_name }}
                                    {{ $editHistory->user->last_name }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $editHistory->changes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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