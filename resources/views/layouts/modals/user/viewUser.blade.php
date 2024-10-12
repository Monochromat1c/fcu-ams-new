@foreach ($users as $user)
<div id="view-user-modal{{ $user->id }}" tabindex="-1" aria-hidden="true"
    class="modalBg overflow-auto flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
    <div class="relative my-auto mx-auto p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                onclick="document.getElementById('view-user-modal{{ $user->id }}').classList.toggle('hidden')">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <h2 class="mb-4 text-lg font-bold text-black">View User</h2>
                <div class="flex flex-col gap-3">
                    <div class="mb-2">
                        <label for="profile_picture" class="block text-gray-700 font-bold mb-1">Profile
                            Picture:</label>
                            @if($user->profile_picture)
                                <img src="{{ asset($user->profile_picture) }}" alt="User Profile"
                                class="w-14 h-14 rounded-full mx-auto">
                            @else
                                <img src="{{ asset('profile/defaultProfile.png') }}"
                                    alt="Default Image" class="w-14 h-14 rounded-full mx-auto">
                            @endif
                    </div>
                    <div class="mb-2">
                        <label for="first_name" class="block text-gray-700 font-bold mb-2 text-left">First Name:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->first_name }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="middle_name" class="block text-gray-700 font-bold mb-2 text-left">Middle Name:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->middle_name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="last_name" class="block text-gray-700 font-bold mb-2 text-left">Last Name:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->last_name }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="contact_number" class="block text-gray-700 font-bold mb-2 text-left">Contact
                            Number:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->contact_number }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="address" class="block text-gray-700 font-bold mb-2 text-left">Address:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->address }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="role_id" class="block text-gray-700 font-bold mb-2 text-left">Role:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->role->role }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="block text-gray-700 font-bold mb-2 text-left">Email:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->email }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="username" class="block text-gray-700 font-bold mb-2 text-left">Username:</label>
                        <p class="bg-slate-100 rounded-md p-2 text-left">{{ $user->username }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach