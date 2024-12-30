@extends('layouts.layout')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Navigation Bar -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <a href="javascript:history.back()"
            class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="my-auto text-3xl">Supply Request Details</h1>
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
                    class="absolute right-0 mt-4 border-2 border-gray-400 w-72 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100 r rounded-t-lg bg-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Profile"
                                        class="w-12 h-12 rounded-full object-cover">
                                @endif
                            </div>
                            <div class="ml-3 flex-grow">
                                <div class="font-medium text-base">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.index') }}" class="ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center border-b-2 border-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                        </svg>
                        <p class="role">
                            Role
                        </p>
                        <p class="ml-auto">{{ auth()->user()->role->role }}</p>
                    </div>
                    <div class="flex items-center border-b-2 border-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>Username</span>
                        <span class="ml-auto">{{ auth()->user()->username }}</span>
                    </div>
                    <button onclick="document.getElementById('logout-modal').classList.toggle('hidden')"
                        class="flex items-center px-4 py-2 text-red-500 hover:bg-gray-100 w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="m-3">
            <!-- Request Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Request #{{ $request->request_id }}</h2>
                        <div class="mt-2 space-y-1">
                            <p class="text-gray-600">
                                <span class="font-medium">Requester:</span> 
                                {{ $request->requester }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Department:</span> 
                                {{ $request->department->department }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Date Requested:</span> 
                                {{ \Carbon\Carbon::parse($request->request_date)->format('F d, Y') }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Notes:</span> 
                                {{ $request->notes }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($request->status === 'approved' ? 'bg-green-100 text-green-800' : 
                               'bg-red-100 text-red-800') }}">
                            {{ ucfirst($request->status) }}
                        </span>
                        @if($request->status === 'pending')
                            <div class="mt-4 space-x-2">
                                <button onclick="approveRequest('{{ $request->request_id }}')" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Approve
                                </button>
                                <button onclick="rejectRequest('{{ $request->request_id }}')"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Reject
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Requested Items -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Requested Items</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($items as $item)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-medium text-gray-900">
                                        {{ $item->inventory->brand->brand }} {{ $item->inventory->items_specs }}
                                    </h4>
                                    <div class="mt-1">
                                        <span class="text-sm text-gray-500">Quantity: </span>
                                        <span class="text-sm font-medium text-gray-900">{{ $item->quantity }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="text-sm font-medium text-gray-500">Stock Available:</span>
                                    <span class="ml-1 text-sm font-semibold {{ $item->inventory->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->inventory->quantity }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function approveRequest(requestId) {
        if (confirm('Are you sure you want to approve this request?')) {
            fetch(`/inventory/supply-request/${requestId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Error approving request');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error approving request');
            });
        }
    }

    function rejectRequest(requestId) {
        if (confirm('Are you sure you want to reject this request?')) {
            fetch(`/inventory/supply-request/${requestId}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Error rejecting request');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error rejecting request');
            });
        }
    }
</script>
@endpush
