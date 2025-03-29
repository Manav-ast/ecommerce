<!-- Delete Confirmation Modal -->
<div id="deleteCartItemModal"
    class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold text-gray-800">Confirm Deletion</h2>
        <p class="text-gray-600 mt-2">Are you sure you want to remove this item from your cart?</p>

        <div class="mt-4 flex justify-end space-x-2">
            <button type="button" onclick="closeDeleteModal()"
                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-all duration-200">
                Cancel
            </button>
            <button type="button" id="confirmDeleteBtn"
                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-all duration-200">
                Delete
            </button>
        </div>
    </div>
</div>
