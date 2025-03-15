<x-admin-layout>
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-4">Categories</h2>
        
        <!-- Search and Filter Section -->
        <div class="flex justify-end bg-white p-4 rounded-lg shadow-md">
            {{-- <input type="text" placeholder="Search Products" class="border p-2 rounded-md w-1/3"> --}}
            <button class="bg-green-600 text-white px-4 py-2 rounded-md">Add Catagories</button>
        </div>
        
        <!-- Products Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">Icon</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2">
                                <img src="{{ $category->icon }}" class="h-8 w-8" alt="Icon">
                            </td>
                            <td class="px-4 py-2">{{ $category->name }}</td>
                            <td class="px-4 py-2">{{ $category->type }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-sm rounded {{ $category->status == 'Published' ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                    {{ $category->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <button class="text-gray-600 hover:text-gray-900">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
