@foreach($assets as $asset)
    <div id="delete-asset-modal{{ $asset->id }}" style="min-height:100vh;" tabindex="-1" aria-hidden="true"
        class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
        <div class="relative my-auto mx-auto p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Delete confirmation modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    onclick="document.getElementById('delete-asset-modal{{ $asset->id }}').classList.toggle('hidden')">
                    <!-- Close button icon -->
                </button>
                <div class="p-6 text-center" id="modal">
                    <h3 class="text-lg font-semibold">Delete Confirmation</h3>
                    <p class="my-2">Are you sure you want to delete the asset "<span
                            class="text-red-800">{{ $asset->asset_tag_id }}</span>"?</p>
                    <div class="flex justify-between">
                        <button type="button"
                            class="rounded-md shadow-md px-5 py-2 bg-gray-600 hover:shadow-md hover:bg-gray-500
                                                transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-1"
                            onclick="document.getElementById('delete-asset-modal{{ $asset->id }}').classList.toggle('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <form
                            action="{{ route('asset.destroy', ['id' => $asset->id]) }}"
                            method="POST" id="delete-asset-form{{ $asset->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                                                    transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Confirm Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach