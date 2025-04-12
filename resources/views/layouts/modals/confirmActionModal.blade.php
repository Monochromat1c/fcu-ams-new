<!-- Generic Confirmation Modal -->
<div id="confirmActionModal" class="fixed inset-0 flex items-center justify-center z-[100] hidden backdrop-blur-sm">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity duration-300"></div>
    <div class="bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/3 lg:max-w-md relative z-[110] transform transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <h3 id="confirmModalTitle" class="text-xl font-semibold text-gray-800">Confirm Action</h3>
            <button type="button" onclick="closeConfirmModal()" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <p id="confirmModalMessage" class="text-gray-600 mb-6">Are you sure you want to proceed?</p>
        <div class="flex justify-end gap-4">
            <button type="button" onclick="closeConfirmModal()" 
                class="px-5 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-200">
                Cancel
            </button>
            <button id="confirmModalButton" type="button" 
                class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
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