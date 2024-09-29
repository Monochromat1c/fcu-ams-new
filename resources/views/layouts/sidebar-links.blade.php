<a href="{{ route('dashboard') }}"
    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100
    {{ Request::is('dashboard') ? 'bg-gray-100' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path
            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
    </svg>
    Dashboard
</a>
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="border-top flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                clip-rule="evenodd" />
        </svg>
        Asset
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="open" class="pl-4">
        <a href="{{ route('asset.list') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('asset/list') ? 'bg-gray-100' : '' }}">Asset
            List</a>
        <a href="{{ route('asset.add') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('asset/add') ? 'bg-gray-100' : '' }}">Add
            Asset</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dispose</a>
        <a href="{{ route('lease.index') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('lease') ? 'bg-gray-100' : '' }}">Lease</a>
        <!-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Lease Return</a> -->
        <a href="{{ route('maintenance') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('maintenance') ? 'bg-gray-100' : '' }}">Maintenance</a>
    </div>
</div>
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="border-top flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path
                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
        </svg>
        Inventory
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="open" class="pl-4">
        <a href="{{ route('inventory.list') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('inventory/list') ? 'bg-gray-100' : '' }}">Inventory
            List</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Purchase Order</a>
        <a href="{{ route('inventory.stock.in') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('inventory/stock/in') ? 'bg-gray-100' : '' }}">Stock
            In</a>
        <a href="{{ route('inventory.stock.out') }}"
            class="block px-4 py-2 text-gray-700
            hover:bg-gray-100{{ Request::is('inventory/stock/out') ? 'bg-gray-100' : '' }}">Stock
            Out</a>
    </div>
</div>
<a href="#" class="border-top flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
            clip-rule="evenodd" />
    </svg>
    Alerts
</a>
<a href="{{ route('reports.index') }}"
    class="border-top flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100
    {{ Request::is('reports') ? 'bg-gray-100' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z"
            clip-rule="evenodd" />
    </svg>
    Reports
</a>
<!-- <div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="border-top flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-5 w-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
        </svg>

        Customer
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="open" class="pl-4">
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Add Customer</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View Customers</a>
    </div>
</div> -->
<!-- <div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="border-top flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                clip-rule="evenodd" />
        </svg>
        Setup
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="open" class="pl-4">
        <a href="{{ route('categories.list') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('categories/list') ? 'bg-gray-100' : '' }}">Category</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Conditions</a>
        <a href="{{ route('departments.list') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100
            {{ Request::is('departments/list') ? 'bg-gray-100' : '' }}">Departments</a>
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Locations</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Sites</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Suppliers</a>
    </div>
</div> -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="border-top flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path
                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
        </svg>
        Users
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="open" class="pl-4">
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Add User</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View Users</a>
    </div>
</div>
<!-- <a href="{{ route('profile.index') }}"
    class="border-top border-bottom flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ Request::is('user/profile') ? 'bg-gray-100' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
    </svg>
    Profile
</a> -->
