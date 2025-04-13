<!-- Generic Confirmation Modal -->
<div id="confirmActionModal" class="fixed inset-0 flex items-center justify-center z-[100] hidden backdrop-blur-sm">
    <div class="fixed inset-0 bg-gray-900/30 transition-opacity duration-300"></div>
    <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-1/3 lg:max-w-md relative z-[110] transform transition-all duration-300 overflow-hidden">
        {{-- Header Section --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 id="confirmModalTitle" class="text-lg font-semibold text-gray-700">Confirm Action</h3>
            <button type="button" onclick="closeConfirmModal()" class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-600 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        {{-- Content Section --}}
        <div class="p-6">
            <p id="confirmModalMessage" class="text-gray-600 leading-relaxed">Are you sure you want to proceed?</p>
        </div>
        {{-- Footer Section --}}
        <div class="flex justify-end gap-3 p-4 bg-gray-50 border-t border-gray-200">
            <button type="button" onclick="closeConfirmModal()" 
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-400 transition-all duration-150">
                Cancel
            </button>
            <button id="confirmModalButton" type="button" 
                class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500/50 transition-all duration-150">
                Confirm
            </button>
        </div>
    </div>
</div>

{{-- Script needs to be included on the page using the modal --}}
@push('scripts')
<script>
    if (typeof confirmActionModalScriptLoaded === 'undefined') {
        let formToSubmit = null;

        function openConfirmModal(formId, title = 'Confirm Action', message = 'Are you sure you want to proceed?') {
            formToSubmit = document.getElementById(formId);
            if (!formToSubmit) {
                console.error('Form not found:', formId);
                return;
            }
            document.getElementById('confirmModalTitle').innerText = title;
            document.getElementById('confirmModalMessage').innerText = message;
            document.getElementById('confirmActionModal').classList.remove('hidden');
        }

        function closeConfirmModal() {
            document.getElementById('confirmActionModal').classList.add('hidden');
            formToSubmit = null; // Clear the form reference
        }

        // Ensure the event listener is only added once
        if (!document.getElementById('confirmModalButton')._eventListenerAttached) {
            document.getElementById('confirmModalButton').addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
                closeConfirmModal();
            });
            document.getElementById('confirmModalButton')._eventListenerAttached = true; 
        }

        // Close modal if clicked outside (ensure this listener is also added only once)
        if (!window._confirmActionModalClickListenerAttached) {
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('confirmActionModal');
                if (event.target == modal) {
                    closeConfirmModal();
                }
            });
            window._confirmActionModalClickListenerAttached = true;
        }
        
        // Mark script as loaded
        var confirmActionModalScriptLoaded = true;
    }
</script>
@endpush 