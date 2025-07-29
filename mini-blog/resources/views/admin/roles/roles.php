<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-pink-800 leading-tight">
                🛡️ Role Management
            </h2>
            <a href="{{ route('dashboard') }}" class="text-pink-600 hover:text-pink-800">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Simple tabs using Alpine.js -->
            <div x-data="{ activeTab: 0 }" class="w-full">
                <!-- Tab Navigation -->
                <div class="flex space-x-1 rounded-xl bg-pink-100 p-1 mb-6">
                    <button @click="activeTab = 0" 
                            :class="{ 'bg-white shadow text-pink-800': activeTab === 0, 'text-pink-600 hover:bg-white/50': activeTab !== 0 }"
                            class="w-full rounded-lg py-2.5 text-sm font-medium transition">
                        Roles
                    </button>
                    <button @click="activeTab = 1" 
                            :class="{ 'bg-white shadow text-pink-800': activeTab === 1, 'text-pink-600 hover:bg-white/50': activeTab !== 1 }"
                            class="w-full rounded-lg py-2.5 text-sm font-medium transition">
                        Permissions
                    </button>
                    <button @click="activeTab = 2" 
                            :class="{ 'bg-white shadow text-pink-800': activeTab === 2, 'text-pink-600 hover:bg-white/50': activeTab !== 2 }"
                            class="w-full rounded-lg py-2.5 text-sm font-medium transition">
                        User Roles
                    </button>
                </div>

                <!-- Roles Tab -->
                <div x-show="activeTab === 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Manage Roles</h3>
                            <button @click="$dispatch('open-modal', 'create-role')"
                                    class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700 transition">
                                Create Role
                            </button>
                        </div>

                        <!-- Roles Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($roles as $role)
                            <div class="border border-pink-200 rounded-lg p-4 bg-pink-50">
                                <h4 class="font-semibold text-pink-800">{{ ucfirst($role->name) }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $role->description ?? 'No description' }}</p>
                                <div class="mt-3 flex flex-wrap gap-1">
                                    @forelse($role->permissions as $permission)
                                        <span class="text-xs bg-pink-100 px-2 py-1 rounded">{{ $permission->name }}</span>
                                    @empty
                                        <span class="text-xs text-gray-400">No permissions</span>
                                    @endforelse
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <button @click="$dispatch('open-modal', 'edit-role-{{ $role->id }}')" 
                                            class="text-pink-600 text-sm hover:underline">Edit</button>
                                    @if($role->name !== 'admin')
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this role?')"
                                                class="text-red-600 text-sm hover:underline">Delete</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">No roles found. Create your first role!</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Permissions Tab -->
                <div x-show="activeTab === 1" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Available Permissions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($permissions as $permission)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900">{{ $permission->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $permission->description ?? 'No description available' }}</p>
                            </div>
                            @empty
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">No permissions found.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- User Roles Tab -->
                <div x-show="activeTab === 2" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">User Role Assignment</h3>
                        
                        <div class="space-y-4">
                            @forelse($users as $user)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400">No roles</span>
                                    @endforelse
                                </div>
                                <button @click="$dispatch('open-modal', 'assign-role-{{ $user->id }}')"
                                        class="text-pink-600 hover:text-pink-800 text-sm">Manage</button>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center">No users found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Role Modal -->
    <x-modal name="create-role" max-width="md">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Role</h3>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role Name</label>
                        <input type="text" name="name" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                        <div class="space-y-2">
                            @foreach($permissions as $permission)
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                       class="rounded border-gray-300 text-pink-600">
                                <span class="ml-2 text-sm">{{ $permission->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="$dispatch('close-modal', 'create-role')"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700">
                        Create Role
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>