@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div class="flex items-center">
                <a href="{{ route('alerts.index') }}"
                    class="mr-4 hover:bg-gray-100 p-2 rounded-full transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-semibold text-gray-800">Overdue Assets</h1>
            </div>
        </nav>

        <div class="bg-white p-6 m-3 rounded-md shadow-md">
            <div class="grid md:grid-cols-2 gap-8">
                @foreach($pastDueAssets as $asset)
                    <div class="bg-slate-50 p-6 rounded-lg border border-slate-200 relative">
                        <div class="absolute top-4 right-4">
                            <a href="{{ route('asset.show', $asset->id) }}"
                                class="text-red-600 hover:text-red-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <h2 class="text-2xl font-bold mb-5 pb-3 border-b border-slate-300 text-gray-700">
                            {{ $asset->asset_tag_id }}</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                                <label class="font-semibold text-gray-600 w-1/3">Brand:</label>
                                <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->brand->brand }}</p>
                            </div>
                            <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                                <label class="font-semibold text-gray-600 w-1/3">Model:</label>
                                <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->model }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <label class="font-semibold text-gray-600 w-1/3">Maintenance End Date:</label>
                                <p class="text-gray-800 font-medium w-2/3 text-right">
                                    {{ \Carbon\Carbon::parse($asset->maintenance_end_date)->format('F d, Y') }}
                                    <span class="text-red-500 ml-2">
                                        ({{ \Carbon\Carbon::parse($asset->maintenance_end_date)->diffForHumans() }})
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection