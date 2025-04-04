<div id="add-user-modal" tabindex="-1" aria-hidden="true"
    class="modalBg fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black bg-opacity-50 p-4 hidden">
    <div class="relative w-full max-w-4xl transform rounded-2xl bg-white shadow-2xl transition-all">
        <div class="relative overflow-auto rounded-2xl max-h-[80dvh]">
            <!-- Gradient Background Overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-purple-100 opacity-50 pointer-events-none">
            </div>

            <!-- Modal Content -->
            <div class="relative z-20 p-8">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Add New User</h2>

                    <!-- Close Button -->
                    <button type="button"
                        onclick="document.getElementById('add-user-modal').classList.toggle('hidden')"
                        class="text-gray-500 hover:text-gray-800 bg-white/50 hover:bg-white/80 rounded-full p-2 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Add Form -->
                <form class="login-form" action="{{ route('user.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Profile Picture Section -->
                        <div class="md:col-span-2 flex flex-col items-center mb-6">
                            <div class="relative mb-4">
                                <input type="file" name="profile_picture" id="profilePicInputAdd"
                                    class="hidden" accept="image/*"
                                    onchange="previewProfilePic(this, 'Add')">

                                <img id="profilePicPreviewAdd"
                                    src="{{ asset('profile/defaultProfile.png') }}"
                                    alt="User Profile"
                                    onclick="document.getElementById('profilePicInputAdd').click()"
                                    class="w-40 h-40 object-cover rounded-full border-4 border-white shadow-lg ring-4 ring-blue-200/50 transform transition-all hover:scale-105 cursor-pointer">

                                <div id="imageOverlayAdd"
                                    class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                                    onclick="document.getElementById('profilePicInputAdd').click()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm">Click image to upload profile picture</p>
                        </div>

                        <!-- Input Fields -->
                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">First Name</label>
                            <input type="text" name="first_name"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Middle Name</label>
                            <input type="text" name="middle_name"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors">
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Last Name</label>
                            <input type="text" name="last_name"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Contact Number</label>
                            <input type="text" name="contact_number"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Address</label>
                            <input type="text" name="address"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Role</label>
                            <select name="role_id"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Department</label>
                            <select name="department_id"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                                <option value="">Select a department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class=" bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Email</label>
                            <input type="email" name="email"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Username</label>
                            <input type="text" name="username"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Password</label>
                            <input type="password" name="password"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="w-full bg-transparent border-b-2 border-gray-300 focus:border-blue-500 transition-colors"
                                required>
                        </div>
                    </div>

                    <!-- Add User Button -->
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="submit"
                            class="rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                            transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                            </svg>
                            Add New User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewProfilePic(input, action) {
        const preview = document.getElementById('profilePicPreview' + action);

        if (input.files && input.files[0]) {
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validImageTypes.includes(input.files[0].type)) {
                alert('Please select a valid image file (JPEG, PNG, or GIF)');
                input.value = '';
                return;
            }

            const maxSizeInBytes = 5 * 1024 * 1024; // 5MB
            if (input.files[0].size > maxSizeInBytes) {
                alert('File is too large. Maximum file size is 5MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>