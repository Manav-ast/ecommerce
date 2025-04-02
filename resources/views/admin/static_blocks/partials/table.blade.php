@foreach ($staticBlocks as $block)
    <tr id="row-{{ $block->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
        <td class="px-6 py-3 text-gray-800">{{ $block->title }}</td>
        <td class="px-6 py-3 text-gray-600">{{ $block->slug }}</td>
        <td class="px-6 py-3">
            <span class="px-3 py-1 rounded text-white text-sm {{ $block->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                {{ ucfirst($block->status) }}
            </span>
        </td>
        <td class="px-6 py-3 flex space-x-4">
            <a href="{{ route('admin.static-blocks.edit', $block->id) }}"
                class="text-blue-500 hover:text-blue-700 transition">
                <i class="uil uil-edit"></i>
            </a>

            <!-- Delete Button -->
            <button type="button" onclick="openDeleteModal({{ $block->id }}, '{{ $block->title }}')"
                class="text-red-500 hover:text-red-700 transition">
                <i class="uil uil-trash-alt"></i>
            </button>
        </td>
    </tr>
@endforeach
