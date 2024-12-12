@foreach($users as $user)
<div id="view-user-modal{{ $user->id }}" tabindex="-1" aria-hidden="true"
    class="modalBg fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black bg-opacity-50 p-4 hidden">
    <div class="relative w-full max-w-4xl transform rounded-2xl bg-white shadow-2xl transition-all">
        <div class="relative overflow-hidden rounded-2xl">
            <!-- Gradient Background Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-purple-100 opacity-50 pointer-events-none"></div>

            

            <!-- Modal Content -->
                <div class="relative z-20 p-8">
                    <!-- Profile Header -->
                    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-8 mb-8">
                        <!-- Profile Picture -->
                        <div class="relative">
                            <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('profile/defaultProfile.png') }}"
                                alt="User Profile"
                                class="w-40 h-40 object-cover rounded-full border-4 border-white shadow-lg ring-4 ring-blue-200/50 transform transition-all hover:scale-105">
                            <span
                                class="absolute bottom-2 right-2 bg-blue-500 text-white rounded-full px-2 py-1 text-xs">
                                {{ $user->role->role }}
                            </span>
                        </div>

                        <!-- Close Button -->
                        <button type="button"
                            onclick="document.getElementById('view-user-modal{{ $user->id }}').classList.toggle('hidden')"
                            class="absolute top-6 right-6 z-10 text-gray-500 hover:text-gray-800 bg-white/50 hover:bg-white/80 rounded-full p-2 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- User Name and Email -->
                        <div class="text-center md:text-left">
                            <h2 class="text-3xl font-bold text-gray-800">
                                {{ $user->first_name }}
                                {{ $user->middle_name ? $user->middle_name . ' ' : '' }}{{ $user->last_name }}
                            </h2>
                            <p class="text-gray-500 text-lg flex items-center justify-center md:justify-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    <!-- User Details Grid -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">First Name</label>
                            <p class="text-gray-800 font-medium">{{ $user->first_name }}</p>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Middle Name</label>
                            <p class="text-gray-800 font-medium">
                                {{ $user->middle_name ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Last Name</label>
                            <p class="text-gray-800 font-medium">{{ $user->last_name }}</p>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Contact Number</label>
                            <p class="text-gray-800 font-medium">{{ $user->contact_number }}</p>
                        </div>

                        <div class=" bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Address</label>
                            <p class="text-gray-800 font-medium">{{ $user->address }}</p>
                        </div>

                        <div class="bg-white/60 border-2 border-gray-200 backdrop-blur-sm rounded-xl p-4 shadow-md">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Username</label>
                            <p class="text-gray-800 font-medium">{{ $user->username }}</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endforeach