<div id="logout-modal" style="min-height:100vh;" tabindex="-1" aria-hidden="true"
    class="modalBg fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center">
    <div class="relative w-full max-w-md mx-auto">
        <!-- Logout confirmation modal content -->
        <div class="relative bg-white rounded-xl shadow-2xl border border-gray-100 transform transition-all duration-300">
            <button type="button"
                class="absolute top-4 right-4 text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-2 inline-flex items-center transition-colors duration-200"
                onclick="document.getElementById('logout-modal').classList.toggle('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="p-8 text-center" id="modal">
                <div class="mx-auto flex items-center justify-center size-16 bg-red-100 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Logout Confirmation</h3>
                <p class="mb-6 text-gray-500">Are you sure you want to log out of your account?</p>
                <div class="flex justify-between gap-4">
                    <button type="button"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-all duration-200 flex items-center gap-2"
                        onclick="document.getElementById('logout-modal').classList.toggle('hidden')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition-all duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>