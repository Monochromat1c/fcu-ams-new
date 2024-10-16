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
                                <th class="px-4 py-2 text-center bg-slate-200 border border-slate-400 whitespace-nowrap">Asset Image</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Asset Tag ID</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Brand</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Model</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Serial Number</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Cost</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Supplier</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Site</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Location</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Category</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Department</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                    Start of Maintenance</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                    End of Maintenance</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Condition</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                                <tr class="hover:bg-slate-100">
                                    <td class="border border-slate-300 px-4 py-2 min-width">
                                        @if($asset->asset_image)
                                            <img src="{{ asset($asset->asset_image) }}" alt="Asset Image"
                                                class="mx-auto rounded-full" style="width:2.7rem;height:2.7rem;">
                                        @else
                                            <img src="{{ asset('profile/defaultIcon.png') }}"
                                                alt="Default Image" class="w-14 h-14 rounded-full mx-auto">
                                        @endif
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->asset_tag_id }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->brand->brand }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->model }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->serial_number }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->cost }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->supplier->supplier }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->site->site }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->location->location }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->category->category }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">
                                        {{ $asset->department->department }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap  whitespace-nowrap">
                                        {{ $asset->maintenance_start_date ?? 'N/A' }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap  whitespace-nowrap">
                                        {{ $asset->maintenance_end_date ?? 'N/A' }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $asset->condition->condition }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">
                                        <div class="mx-auto flex justify-center space-x-2">
                                            <a href="{{ route('asset.edit', ['id' => $asset->id]) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            </a>
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
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this asset?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

</script>

@endsection