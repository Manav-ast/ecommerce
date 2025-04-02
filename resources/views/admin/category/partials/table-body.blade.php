@foreach ($categories as $category)
    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
        <td class="px-3 md:px-6 py-2 md:py-3 relative">
            <div class="w-8 h-8 md:w-10 md:h-10 overflow-hidden">
                <img src="{{ asset('storage/' . $category->image) }}"
                    class="w-8 h-8 md:w-10 md:h-10 object-cover rounded transition-transform duration-300 transform hover:scale-150 hover:absolute hover:top-0 hover:left-0 hover:w-20 hover:h-20 md:hover:w-24 md:hover:h-24 hover:shadow-lg">
            </div>
        </td>
        <td class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-800 max-w-[100px] md:max-w-none truncate">
            {{ $category->name }}</td>
        <td class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-600 truncate">
            {{ $category->slug }}</td>
        <td class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-600">
            {{ \Illuminate\Support\Str::limit($category->description, 50) }}</td>
        <td class="px-3 md:px-6 py-2 md:py-3 flex space-x-2 md:space-x-4">
            <!-- Edit Button -->
            <a href="{{ route('admin.categories.edit', $category->id) }}"
                class="text-blue-500 hover:text-blue-700 transition p-1">
                <i class="uil uil-edit"></i>
            </a>

            <!-- Delete Button (Triggers SweetAlert2) -->
            <button type="button" onclick="openDeleteModal({{ $category->id }}, '{{ $category->name }}')"
                class="text-red-500 hover:text-red-700 transition p-1">
                <i class="uil uil-trash-alt"></i>
            </button>
        </td>
    </tr>
@endforeach
