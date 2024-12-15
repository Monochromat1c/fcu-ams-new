@extends('layouts.layout')

@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Navigation Bar -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <a href="{{ route('dashboard') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-2xl font-bold">Supply Request Details</h1>
            <div class="w-24"></div> <!-- Spacer for alignment -->
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
                                    @if($item->notes)
                                        <p class="mt-2 text-sm text-gray-500">
                                            <span class="font-medium">Note:</span> {{ $item->notes }}
                                        </p>
                                    @endif
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
