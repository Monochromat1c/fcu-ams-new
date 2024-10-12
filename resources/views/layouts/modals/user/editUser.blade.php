<div id="edit-user-modal" tabindex="-1" aria-hidden="true"
    class="modalBg overflow-auto flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
    <div class="relative my-auto mx-auto p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                onclick="document.getElementById('add-user-modal').classList.toggle('hidden')">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <h2 class="mb-4 text-lg font-bold text-black">Add New User</h2>
                <form class="login-form rounded-lg" action="{{ route('user.add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div class="mb-2 col-span-2">
                            <label for="profile_picture" class="block text-gray-700 font-bold mb-2">Profile
                                Picture:</label>
                            <input type="file" id="profile_picture" name="profile_picture"
                                class="w-full border rounded-md">
                        </div>
                        <div class="mb-2">
                            <label for="first_name" class="block text-gray-700 font-bold mb-2">First Name:</label>
                            <input type="text" id="first_name" name="first_name" class="w-full p-2 border rounded-md"
                                required>
                        </div>
                        <div class="mb-2">
                            <label for="middle_name" class="block text-gray-700 font-bold mb-2">Middle Name:</label>
                            <input type="text" id="middle_name" name="middle_name" class="w-full p-2 border rounded-md">
                        </div>
                        <div class="mb-2">
                            <label for="last_name" class="block text-gray-700 font-bold mb-2">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" class="w-full p-2 border rounded-md"
                                required>
                        </div>
                        <div class="mb-2">
                            <label for="contact_number" class="block text-gray-700 font-bold mb-2">Contact
                                Number:</label>
                            <input type="text" id="contact_number" name="contact_number"
                                class="w-full p-2 border rounded-md" required>
                        </div>
                        <div class="mb-2">
                            <label for="address" class="block text-gray-700 font-bold mb-2">Address:</label>
                            <input type="text" id="address" name="address" class="w-full p-2 border rounded-md"
                                required>
                        </div>
                        <div class="mb-2">
                            <label for="role_id" class="block text-gray-700 font-bold mb-2">Role:</label>
                            <select id="role_id" name="role_id" class="w-full p-2 border rounded-md" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                            <input type="email" id="email" name="email" class="w-full p-2 border rounded-md" required>
                        </div>
                        <div class="mb-2">
                            <label for="username" class="block text-gray-700 font-bold mb-2">Username:</label>
                            <input type="text" id="username" name="username" class="w-full p-2 border rounded-md"
                                required>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
                            <input type="password" id="password" name="password" class="w-full p-2 border rounded-md"
                                required>
                        </div>
                        <div class="mb-2">
                            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm
                                Password:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full p-2 border rounded-md" required>
                        </div>
                    </div>
                    <button type="submit" class="flex justify-center w-full bg-green-700 p-3 rounded-lg mt-3">
                        <label for="" class="text-white">Sign Up</label>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>