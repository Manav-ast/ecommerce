@foreach ($staticBlocks as $block)
    <div id="mobile-row-{{ $block->id }}" class="bg-white rounded-lg shadow-md p-4">
        <div class="flex justify-between items-start mb-3">
            <h3 class="text-lg font-semibold text-gray-800">{{ $block->title }}</h3>
            <span
                class="px-3 py-1 rounded text-white text-sm {{ $block->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                {{ ucfirst($block->status) }}
            </span>
        </div>
        <p class="text-gray-600 text-sm mb-4">{{ $block->slug }}</p>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.static_blocks.edit', $block->id) }}"
                class="text-blue-500 hover:text-blue-700 transition">
                <i class="uil uil-edit"></i>
            </a>
            <button type="button" onclick="openDeleteModal({{ $block->id }}, '{{ $block->title }}')"
                class="text-red-500 hover:text-red-700 transition">
                <i class="uil uil-trash-alt"></i>
            </button>
        </div>
    </div>
@endforeach
