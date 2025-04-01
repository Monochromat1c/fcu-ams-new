<div id="add-condition-modal"
    class="modalBg fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden overflow-y-auto p-4">
    <div class="relative w-full max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 relative">
            <button onclick="document.getElementById('add-condition-modal').classList.toggle('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Add New Condition</h2>
                </div>
                <form method="POST" action="{{ route('condition.add') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition Name</label>
                        <input type="text" id="condition" name="condition" required
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-300"
                            placeholder="Enter condition name">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                            onclick="document.getElementById('add-condition-modal').classList.toggle('hidden')"
                            class="px-5 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition duration-300 ease-in-out
                            border border-gray-300 shadow-sm hover:shadow-md
                            flex items-center gap-2
                            transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-300 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                            </svg>
                            Add Condition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>