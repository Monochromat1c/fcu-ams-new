@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div x-data="{ sidebarOpen: true }" class="grid grid-cols-6">
    <div x-show="sidebarOpen" class="col-span-1">
        @include('layouts.sidebar')
    </div>
    <div :class="{ 'col-span-5': sidebarOpen, 'col-span-6': !sidebarOpen }" class="bg-slate-200 content min-h-screen">
        <!-- Header -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 2xl:max-w-7xl 2xl:mx-auto shadow-md rounded-md">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="my-auto text-3xl">My Supply Requests</h1>
            <div class="w-10"></div>
        </nav>

        <div class="m-3 rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            @include('layouts.messageWithoutTimerForError')
        </div>

        <!-- Requests List -->
        <div class="bg-white m-3 shadow-md rounded-md p-6 2xl:max-w-7xl 2xl:mx-auto">
            <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Request Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('inventory.supply-request.details', ['request_group_id' => $request->request_group_id]) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($request->request_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $request->department->department }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $request->items_count }} {{ Str::plural('item', $request->items_count) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        {{ $request->group_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($request->group_status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($request->group_status === 'partially_approved' ? 'bg-blue-100 text-blue-800' :
                                           ($request->group_status === 'cancelled' ? 'bg-gray-100 text-gray-800' :
                                           'bg-red-100 text-red-800'))) }}">
                                        {{ ucfirst(str_replace('_', ' ', $request->group_status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('inventory.supply-request.details', ['request_group_id' => $request->request_group_id]) }}" 
                                           class="text-green-600 hover:text-blue-900"
                                           onclick="event.stopPropagation()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection