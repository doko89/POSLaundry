<div id="quickAddCustomerModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Tambah Pelanggan Baru</h3>
            <button onclick="closeQuickAddCustomer()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('worker.customers.quick-store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Nomor HP</label>
                <input type="text" name="phone" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-input" rows="2"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <x-button type="button" variant="secondary" onclick="closeQuickAddCustomer()">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Simpan
                </x-button>
            </div>
        </form>
    </div>
</div>

<script>
    function openQuickAddCustomer() {
        document.getElementById('quickAddCustomerModal').classList.remove('hidden');
    }

    function closeQuickAddCustomer() {
        document.getElementById('quickAddCustomerModal').classList.add('hidden');
    }
</script> 