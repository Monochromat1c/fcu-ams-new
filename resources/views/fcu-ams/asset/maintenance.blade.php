@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-50 col-span-5">
        <!-- Enhanced Header -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Maintenance</h1>
            <a href="{{ route('profile.index') }}" class="flex gap-3" style="min-width:100px;">
                <!-- <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset=""> -->
                <div>
                     @if(auth()->user()->profile_picture)
                        <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @else
                        <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @endif
                </div>
                <p class="my-auto">
                    {{ (auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'N/A') }}
                </p>
            </a>
        </nav>

        <!-- Main Content -->
        <div class="bg-white p-6 shadow-sm m-3 rounded-lg">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Maintenance List</h2>
                    <p class="text-sm text-gray-500 mt-1">Overview of assets currently under maintenance</p>
                </div>
            </div>

            @if($assets->where('condition.condition', 'Maintenance')->isEmpty())
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-3">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <p class="text-xl font-medium text-gray-500">No assets under maintenance</p>
                    <p class="text-sm text-gray-400 mt-1">All assets are currently in working condition</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maintenance Period</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($assets as $asset)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                @if($asset->asset_image)
                                                    <img src="{{ asset($asset->asset_image) }}" alt="Asset Image"
                                                        class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <img src="{{ asset('profile/defaultIcon.png') }}"
                                                        alt="Default Image" class="w-10 h-10 rounded-full object-cover">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $asset->asset_tag_id }}</div>
                                                <div class="text-sm text-gray-500">{{ $asset->model }}</div>
                                                <div class="text-xs text-gray-400">SN: {{ $asset->serial_number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $asset->site->site }}</div>
                                        <div class="text-sm text-gray-500">{{ $asset->location->location }}</div>
                                        <div class="text-xs text-gray-400">{{ $asset->department->department }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            Start: {{ $asset->maintenance_start_date ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm {{ ($asset->maintenance_end_date && \Carbon\Carbon::parse($asset->maintenance_end_date)->isPast()) ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                            End: {{ $asset->maintenance_end_date ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('asset.edit', ['id' => $asset->id]) }}" 
                                           class="text-blue-600 hover:text-blue-900 inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-blue-50 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- Pagination Controls -->
                        <div class="mt-4 flex items-center justify-between px-4 mb-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ $assets->url(1) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="{{ $assets->previousPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L8.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        
                            <div class="text-sm text-gray-700">
                                Showing {{ $assets->firstItem() ?? 0 }} to {{ $assets->lastItem() ?? 0 }} of {{ $assets->total() }} items
                            </div>
                        
                            <div class="flex items-center gap-2">
                                <a href="{{ $assets->nextPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L11.586 10l-4.293 4.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="{{ $assets->url($assets->lastPage()) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L8.586 10l-4.293 4.293a1 1 0 000 1.414zm6 0a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L14.586 10l-4.293 4.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this asset?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

@endsection