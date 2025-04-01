@foreach ($staticBlocks as $block)
    <div id="mobile-row-{{ $block->id }}" class="bg-white rounded-lg shadow-md p-4">
        <div class="flex justify-between items-start mb-3">
            <h3 class="text-lg font-semibold text-gray-800">{{ $block->title }}</h3>
            <div class="flex space-x-3">
                <a href="{{ route('admin.page_blocks.edit', $block->id) }}"
                    class="text-blue-500 hover:text-blue-700 transition">
                    <i class="uil uil-edit"></i>
                </a>
                <button type="button" onclick="openDeleteModal({{ $block->id }}, '{{ $block->title }}')"
                    class="text-red-500 hover:text-red-700 transition">
                    <i class="uil uil-trash-alt"></i>
                </button>
            </div>
        </div>
        <div class="text-sm text-gray-600 mb-2">{{ $block->slug }}</div>
        <span
            class="inline-block px-3 py-1 rounded text-white text-sm {{ $block->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
            {{ ucfirst($block->status) }}
        </span>
    </div>
@endforeach
