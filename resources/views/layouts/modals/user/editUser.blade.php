@foreach($users as $user)
    <div id="edit-user-modal{{ $user->id }}" tabindex="-1" aria-hidden="true"
        class="modalBg overflow-auto flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
        <div class="relative my-auto mx-auto p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    onclick="document.getElementById('edit-user-modal{{ $user->id }}').classList.toggle('hidden')">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <h2 class="mb-4 text-lg font-bold text-black">Edit User</h2>
                    <form class="login-form rounded-lg"
                        action="{{ route('user.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-2 gap-3">
                            <div class="mb-2 col-span-2">
                                @if($user->profile_picture)
                                    <img src="{{ asset($user->profile_picture) }}" alt="User Profile"
                                        class="mb-2 w-20 h-20 object-cover bg-no-repeat rounded-full mx-auto">
                                @else
                                    <img src="{{ asset('profile/defaultProfile.png') }}"
                                        alt="Default Image" class="w-20 h-20 object-cover bg-no-repeat rounded-full mx-auto mb-2">
                                @endif
                                <label for="profile_picture"
                                    class="text-left block text-gray-700 font-bold mb-2">Profile
                                    Picture:</label>
                                <input type="file" id="profile_picture" name="profile_picture"
                                    class="w-full border rounded-md  bg-gray-100">
                            </div>
                            <div class="mb-2">
                                <label for="first_name" class="text-left block text-gray-700 font-bold mb-2">First
                                    Name:</label>
                                <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}"
                                    class="w-full p-2 border rounded-md  bg-gray-100" required>
                            </div>
                            <div class="mb-2">
                                <label for="middle_name" class="text-left block text-gray-700 font-bold mb-2">Middle
                                    Name:</label>
                                <input type="text" id="middle_name" name="middle_name"
                                    value="{{ $user->middle_name }}" class="w-full p-2 border rounded-md  bg-gray-100">
                            </div>
                            <div class="mb-2">
                                <label for="last_name" class="text-left block text-gray-700 font-bold mb-2">Last
                                    Name:</label>
                                <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}"
                                    class="w-full p-2 border rounded-md  bg-gray-100" required>
                            </div>
                                                    <div class="mb-2">
                            <label for="contact_number" class="text-left block text-gray-700 font-bold mb-2">Contact
                                Number:</label>
                            <input type="text" id="contact_number" name="contact_number" value="{{ $user->contact_number }}" class="w-full p-2 border rounded-md  bg-gray-100"
                                required>
                        </div>
                        <div class="mb-2">
                            <label for="address" class="text-left block text-gray-700 font-bold mb-2">Address:</label>
                            <input type="text" id="address" name="address" value="{{ $user->address }}" class="w-full p-2 border rounded-md  bg-gray-100"
                                required>
                        </div>
                        <div class="mb-2">
                            <label for="role_id" class="text-left block text-gray-700 font-bold mb-2">Role:</label>
                            <select id="role_id" name="role_id" class="w-full p-2 border rounded-md  bg-gray-100" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="text-left block text-gray-700 font-bold mb-2">Email:</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full p-2 border rounded-md  bg-gray-100" required>
                        </div>
                        <div class="mb-2">
                            <label for="username" class="text-left block text-gray-700 font-bold mb-2">Username:</label>
                            <input type="text" id="username" name="username" value="{{ $user->username }}" class="w-full p-2 border rounded-md  bg-gray-100" required>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="submit"
                            class="rounded-md shadow-md px-5 py-2 bg-blue-600 hover:shadow-md hover:bg-blue-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                            </svg>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach