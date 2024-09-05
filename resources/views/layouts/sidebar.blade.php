<style>
    .break-line {
        padding: 1px 0;
        margin: .50rem 1rem 1rem 1rem;
    }

    .fcu-icon {
        width: 150px;
        height: 150px;
    }
</style>

<div class="sidebar flex-grow flex flex-col overflow-y-auto">
    <div class="flex flex-col mx-auto">
        <img class="fcu-icon mb-1 mx-auto" src="/img/login/fcu-icon.png" alt="" srcset="">
        <h1 class="text-blue-900 text-center text-3xl">FCU</h1>
        <h2 class="text-blue-900 text-center text-2xl">Asset Management System</h2>
    </div>
    <!-- <div class="bg-blue-900 break-line"></div> -->
    <div class=" break-line"></div>
    <nav class="mb-3">
        @include('layouts.sidebar-links')
    </nav>
    <div class="mt-auto mb-2">
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
        <button onclick="confirmLogout()"
            class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                    clip-rule="evenodd" />
            </svg>
            Logout
        </button>
    </div>
</div>
