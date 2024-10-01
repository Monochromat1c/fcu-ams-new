@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/addAsset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Alerts</h1>
            <a href="{{ route('profile.index') }}" class="flex space-x-1" style="min-width:100px;">
                <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset="">
                <p class="my-auto">Lighttt</p>
            </a>
        </nav>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <h2 class="text-2xl mb-4">Assets Past Maintenance Due Date</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Asset Name</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Brand</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Model</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Serial Number</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Site</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Location</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Category</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Department</th>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Maintenance End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pastDueAssets as $asset)
                        <tr>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->asset_name }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->brand }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->model }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->serial_number }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->site->site }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->location->location }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->category->category }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->department->department }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->maintenance_end_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
