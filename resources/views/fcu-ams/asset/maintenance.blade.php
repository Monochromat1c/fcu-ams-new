@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div x-data="{ sidebarOpen: true }" class="grid grid-cols-6">
    <div x-show="sidebarOpen" class="col-span-1">
        @include('layouts.sidebar')
    </div>
    <div :class="{ 'col-span-5': sidebarOpen, 'col-span-6': !sidebarOpen }" class="bg-slate-200 content min-h-screen">
    <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
            <h1 class="my-auto text-3xl">Maintenance</h1>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex gap-3 focus:outline-none" style="min-width:100px;">
                    <div>
                         @if(auth()->user()->profile_picture)
                            <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                class="w-14 h-14 object-cover bg-no-repeat rounded-full mx-auto">
                        @else
                            <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                                class="w-14 h-14 object-cover bg-no-repeat rounded-full mx-auto">
                        @endif
                    </div>
                     
                </button>
                <div x-show="open" 
                    @click.away="open = false"
                    class="absolute right-0 mt-4 w-72 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                    <div class="p-4 border-b border-gray-100 rounded-t-lg bg-gradient-to-r from-gray-100 to-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500">
                                @else
                                    <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Profile"
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500">
                                @endif
                            </div>
                            <div class="ml-3 flex-grow">
                                <div class="font-semibold text-base text-gray-800">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-sm text-gray-600">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.index') }}" class="ml-2 p-1 hover:bg-gray-100 rounded-full transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                            <p class="font-medium">Role</p>
                            <p class="ml-auto text-gray-600">{{ auth()->user()->role->role }}</p>
                        </div>
                        <div class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Username</span>
                            <span class="ml-auto text-gray-600">{{ auth()->user()->username }}</span>
                        </div>
                        <button onclick="document.getElementById('logout-modal').classList.toggle('hidden')"
                            class="flex items-center px-4 py-3.5 text-red-600 hover:bg-red-50 w-full text-left transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </div>
                </div>
            </div>
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
                <div class="overflow-x-auto rounded-lg border-2 border-slate-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Asset Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Maintenance Period</th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Action</th>
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
                                        <button onclick="openConditionModal({{ $asset->id }}, '{{ $asset->condition->condition }}')" 
                                           class="text-blue-600 hover:text-blue-900 inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-blue-50 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            @endif
        </div>
    </div>
</div>

<!-- Condition Update Modal -->
<div id="condition-modal" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
            <form id="update-condition-form" method="POST">
                @csrf
                <!-- Header -->
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Update Asset Condition</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeConditionModal()">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <!-- Condition Dropdown -->
                        <div>
                            <label for="condition_id" class="block text-sm font-medium text-gray-700">Condition</label>
                            <select id="condition_id" name="condition_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($conditions as $condition)
                                    <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Maintenance Dates (shown only when maintenance is selected) -->
                        <div id="maintenance-dates" class="hidden">
                            <div class="space-y-4">
                                <div>
                                    <label for="maintenance_start_date" class="block text-sm font-medium text-gray-700">
                                        Maintenance Start Date
                                    </label>
                                    <input type="date" id="maintenance_start_date" name="maintenance_start_date"
                                        class="mt-1 block w-full rounded-md border-2 px-3 py-2 bg-slate-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="maintenance_end_date" class="block text-sm font-medium text-gray-700">
                                        Maintenance End Date
                                    </label>
                                    <input type="date" id="maintenance_end_date" name="maintenance_end_date"
                                        class="mt-1 block w-full rounded-md border-2 px-3 py-2 bg-slate-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        onclick="closeConditionModal()">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Condition
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openConditionModal(assetId, currentCondition) {
        const modal = document.getElementById('condition-modal');
        const form = document.getElementById('update-condition-form');
        const conditionSelect = document.getElementById('condition_id');
        const maintenanceDates = document.getElementById('maintenance-dates');

        // Set the form action
        form.action = `/asset/${assetId}/update-condition`;

        // Show the modal
        modal.classList.remove('hidden');

        // Set current condition
        Array.from(conditionSelect.options).forEach(option => {
            if (option.text === currentCondition) {
                option.selected = true;
            }
        });

        // Show/hide maintenance dates based on selected condition
        conditionSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            maintenanceDates.classList.toggle('hidden', selectedOption.text !== 'Maintenance');
        });

        // Trigger change event to set initial state
        conditionSelect.dispatchEvent(new Event('change'));
    }

    function closeConditionModal() {
        document.getElementById('condition-modal').classList.add('hidden');
    }
</script>

@endsection