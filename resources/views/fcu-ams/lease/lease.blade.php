@extends('layouts.layout')

@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Lease</h1>
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
        <div class="mb-1 flex justify-between m-3 rounded-md">
            <div class="flex">
                <a href="{{ route('lease.create') }}"
                    class="mr-3 rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Lease
                    Asset</a>
                <!-- <a href="#"
                    class="mr-3 rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Stock
                    Out</a>
                <a href="#"
                    class="mr-3 rounded-md shadow-md px-5 py-2 bg-blue-600 hover:shadow-md hover:bg-blue-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Create
                    Purchase Order</a> -->
            </div>
            <div class="flex gap-2">
                {{ $leases->links() }}
            </div>
        </div>
        <div class="m-3">
            @include('layouts.messageWithTimerForError')
        </div>
        @if($leases->isEmpty())
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <h2 class="text-2xl font-bold my-auto mb-2">Leased Items</h2>
            <p class="text-center text-xl text-gray-500">No leased assets.</p>
        </div>
        @else
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">Leased Items</h2>
                <div class="searchBox">
                    <form action="{{ route('lease.index') }}" method="GET" class=" flex gap-1">
                        <input type="text" name="search" placeholder="Search for leases..."
                            class="py-2 px-3 border rounded-md border-red-950 w-96 text-sm text-gray-700 my-auto">
                        <div class="flex align-items-center gap-1">
                            <button type="submit" style="padding: 0.35rem 0.75rem;"
                                class=" border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition-all duration-200 ease-in rounded-md">
                                Search
                            </button>
                            <button type="submit" style="padding: 0.35rem 0.75rem;" name="clear" value="true"
                                class="border border-amber-600 hover:text-white text-amber-600 hover:bg-amber-600 transition-all duration-200 ease-in rounded-md">
                                Clear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                <div class="flex">
                                    <a class="my-auto"
                                        href="{{ route('lease.index', ['sort' => 'asset_tag_id', 'direction' => ($direction == 'asc' && $sort == 'asset_tag_id') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                    <span class="mx-2">Asset</span>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                <div class="flex">
                                    <a class="my-auto"
                                        href="{{ route('lease.index', ['sort' => 'lease_date', 'direction' => ($direction == 'asc' && $sort == 'lease_date') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                    <span class="mx-2">Lease Date</span>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                <div class="flex">
                                    <a class="my-auto"
                                        href="{{ route('lease.index', ['sort' => 'lease_expiration', 'direction' => ($direction == 'asc' && $sort == 'lease_expiration') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                    <span class="mx-2">Lease Expiration</span>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                <div class="flex">
                                    <a class="my-auto"
                                        href="{{ route('lease.index', ['sort' => 'customer', 'direction' => ($direction == 'asc' && $sort == 'customer') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                    <span class="mx-2">Customer</span>
                                </div>
                            </th>
                            <!-- <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400 text-center">
                                Action
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leases as $lease)
                            @foreach($lease->assets as $asset)
                                <tr>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->asset_tag_id }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $lease->lease_date }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $lease->lease_expiration }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $lease->customer }}</td>
                                    <!-- <td class="border border-slate-300 px-4 py-2">
                                        <div class="mx-auto flex justify-center space-x-2">
                                            <div class="mx-auto flex justify-center space-x-2">
                                                <form
                                                    action="{{ route('lease.end', $lease->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">End
                                                        Lease</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td> -->
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
  
 
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this asset?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

</script>
<script>
    function clearSearch() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('form').submit();
    }

</script>
@endsection
