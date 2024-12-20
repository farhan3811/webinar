<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex mb-4">
                        <form method="GET" action="{{ route('datamahasiswa') }}">
                            <div class="flex items-center">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari berdasarkan Nama, NIM, atau Kode Unik"
                                    class="w-full p-2 border border-gray-300 rounded" />
                                <button type="submit"
                                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Cari
                                </button>
                            </div>
                        </form>
                        <form action="{{ route('admin.exportExcel') }}" method="GET" class="ml-4 inline">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Export Excel</button>
                        </form>
                        <div class="py-4">
                            @if (session('success'))
                                <div class="bg-green-100 text-green-800 p-4 rounded">
                                    {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div class="bg-red-100 text-red-800 p-4 rounded">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>

                        <button onclick="approveSelected()"
                            class="px-4 py-2 bg-green-500 text-white rounded ml-4">Approve All</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse table-auto">
                            <thead>
                                <tr class="bg-sky-800 text-white font-medium">
                                    <th class="px-4 py-2 border-b">
                                        <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th class="px-4 py-2 border-b">Nama</th>
                                    <th class="px-4 py-2 border-b">Email</th>
                                    <th class="px-4 py-2 border-b">Status</th>
                                    <th class="px-4 py-2 border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach($registrations as $index => $registration)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sky-100' }}">
                                        <!-- Checkbox -->
                                        <td class="px-4 py-2 border-b">
                                            <input type="checkbox" class="select-checkbox"
                                                value="{{ $registration->id }}" />
                                        </td>

                                        <!-- Data fields -->
                                        <td class="px-4 py-2 border-b">{{ $registration->name }}</td>
                                        <td class="px-4 py-2 border-b">{{ $registration->email }}</td>

                                        <!-- Status -->
                                        <td class="px-4 py-2 border-b text-center">
                                            <span
                                                class="inline-block px-2 py-1 text-sm font-semibold rounded-full 
                                                    {{ $registration->status == 'approved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="flex items-center justify-center px-4 py-2 text-center">
                                            <form action="{{ route('admin.approve', $registration->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status" value="approved"
                                                    class="px-4 py-2 bg-green-500 text-white rounded"><svg width="21"
                                                        height="16" viewBox="0 0 21 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M20.0459 5.0625C20.1709 5.1875 20.1709 5.375 20.0459 5.5L15.9834 9.59375C15.8584 9.71875 15.6396 9.71875 15.5146 9.59375L13.2334 7.25C13.1084 7.125 13.1084 6.9375 13.2334 6.8125L13.8271 6.1875C13.9521 6.0625 14.1396 6.0625 14.2646 6.1875L15.7646 7.6875L18.9834 4.4375C19.1084 4.3125 19.2959 4.3125 19.4209 4.4375L20.0459 5.0625ZM7.13965 9C4.63965 9 2.63965 7 2.63965 4.5C2.63965 2.03125 4.63965 0 7.13965 0C9.6084 0 11.6396 2.03125 11.6396 4.5C11.6396 7 9.6084 9 7.13965 9ZM7.13965 1.5C5.4834 1.5 4.13965 2.875 4.13965 4.5C4.13965 6.15625 5.4834 7.5 7.13965 7.5C8.76465 7.5 10.1396 6.15625 10.1396 4.5C10.1396 2.875 8.76465 1.5 7.13965 1.5ZM9.9209 9.5C12.2334 9.5 14.1396 11.4062 14.1396 13.7188V14.5C14.1396 15.3438 13.4521 16 12.6396 16H1.63965C0.795898 16 0.139648 15.3438 0.139648 14.5V13.7188C0.139648 11.4062 2.01465 9.5 4.32715 9.5C5.2334 9.5 5.63965 10 7.13965 10C8.6084 10 9.01465 9.5 9.9209 9.5ZM12.6396 14.5V13.7188C12.6396 12.2188 11.4209 11 9.9209 11C9.45215 11 8.7334 11.5 7.13965 11.5C5.51465 11.5 4.7959 11 4.32715 11C2.82715 11 1.63965 12.2188 1.63965 13.7188V14.5H12.6396Z"
                                                            fill="white" />
                                                    </svg></button>
                                            </form>
                                            <a href="{{ route('admin.details', $registration->id) }}"
                                                class="ml-2 px-4 py-2 bg-sky-800 text-white rounded"><svg width="19"
                                                    height="12" viewBox="0 0 19 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.13965 2.5C8.7959 2.53125 8.45215 2.5625 8.13965 2.65625C8.2959 2.90625 8.3584 3.21875 8.38965 3.5C8.38965 4.46875 7.57715 5.25 6.63965 5.25C6.32715 5.25 6.01465 5.1875 5.7959 5.03125C5.70215 5.34375 5.63965 5.65625 5.63965 6C5.63965 7.9375 7.20215 9.5 9.13965 9.5C11.0771 9.5 12.6396 7.9375 12.6396 6C12.6396 4.09375 11.0771 2.53125 9.13965 2.53125V2.5ZM18.0146 5.5625C16.3271 2.25 12.9521 0 9.13965 0C5.2959 0 1.9209 2.25 0.233398 5.5625C0.170898 5.6875 0.139648 5.84375 0.139648 6C0.139648 6.1875 0.170898 6.34375 0.233398 6.46875C1.9209 9.78125 5.2959 12 9.13965 12C12.9521 12 16.3271 9.78125 18.0146 6.46875C18.0771 6.34375 18.1084 6.1875 18.1084 6.03125C18.1084 5.84375 18.0771 5.6875 18.0146 5.5625ZM9.13965 10.5C6.0459 10.5 3.20215 8.78125 1.70215 6C3.20215 3.21875 6.0459 1.5 9.13965 1.5C12.2021 1.5 15.0459 3.21875 16.5459 6C15.0459 8.78125 12.2021 10.5 9.13965 10.5Z"
                                                        fill="white" />
                                                </svg>
                                            </a>
                                            <a onclick="openEditModal({{ json_encode($registration) }})"
                                                class="ml-2 px-4 py-2 bg-cyan-500 text-white rounded pointer"><svg
                                                    width="19" height="17" viewBox="0 0 19 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.7021 11.7812L13.7021 10.7812C13.8584 10.625 14.1396 10.75 14.1396 10.9688V15.5C14.1396 16.3438 13.4521 17 12.6396 17H1.63965C0.795898 17 0.139648 16.3438 0.139648 15.5V4.5C0.139648 3.6875 0.795898 3 1.63965 3H10.1709C10.3896 3 10.5146 3.28125 10.3584 3.4375L9.3584 4.4375C9.2959 4.5 9.2334 4.5 9.1709 4.5H1.63965V15.5H12.6396V11.9688C12.6396 11.9062 12.6396 11.8438 12.7021 11.7812ZM17.5771 5.5L9.38965 13.6875L6.5459 14C5.7334 14.0938 5.0459 13.4062 5.13965 12.5938L5.45215 9.75L13.6396 1.5625C14.3584 0.84375 15.5146 0.84375 16.2334 1.5625L17.5771 2.90625C18.2959 3.625 18.2959 4.78125 17.5771 5.5ZM14.5146 6.4375L12.7021 4.625L6.88965 10.4375L6.63965 12.5L8.70215 12.25L14.5146 6.4375ZM16.5146 3.96875L15.1709 2.625C15.0459 2.46875 14.8271 2.46875 14.7021 2.625L13.7646 3.5625L15.5771 5.40625L16.5459 4.4375C16.6709 4.28125 16.6709 4.09375 16.5146 3.96875Z"
                                                        fill="white" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="mt-4">
                        {{ $registrations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="editModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-2xl mx-auto sm:w-3/4 lg:w-1/2 max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-white text-center">
                Edit Data Mahasiswa
            </h2>
            <form id="editForm" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id">

                <!-- Nama -->
                <div>
                    <label for="edit-name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input type="text" id="edit-name" name="name"
                        class="form-input w-full border-gray-300 dark:border-gray-600 rounded-md focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-gray-200">
                </div>


                <!-- Email -->
                <div>
                    <label for="edit-email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" id="edit-email" name="email"
                        class="form-input w-full border-gray-300 dark:border-gray-600 rounded-md focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-gray-200">
                </div>
                >
                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-sky-800 text-white rounded-md hover:bg-sky-900">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(data) {
            document.getElementById('edit-id').value = data.id;
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-email').value = data.email;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('editForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('edit-id').value;
            const formData = new FormData(this);

            fetch(`/admin/registrations/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Data berhasil diperbarui.');
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan saat memperbarui data.');
                    }
                });
        });
        function toggleSelectAll(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('.select-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                if (selectAllCheckbox.checked) {
                    addToSelectedIds(checkbox.value);
                } else {
                    removeFromSelectedIds(checkbox.value);
                }
            });
        }
        function addToSelectedIds(id) {
            let selectedIds = JSON.parse(localStorage.getItem('selected_ids')) || [];
            if (!selectedIds.includes(id)) {
                selectedIds.push(id);
                localStorage.setItem('selected_ids', JSON.stringify(selectedIds));
            }
        }
        function removeFromSelectedIds(id) {
            let selectedIds = JSON.parse(localStorage.getItem('selected_ids')) || [];
            selectedIds = selectedIds.filter(selectedId => selectedId !== id);
            localStorage.setItem('selected_ids', JSON.stringify(selectedIds));
        }
        document.addEventListener("DOMContentLoaded", function () {
            const selectedIds = JSON.parse(localStorage.getItem('selected_ids')) || [];
            const checkboxes = document.querySelectorAll('.select-checkbox');
            checkboxes.forEach(checkbox => {
                if (selectedIds.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
                checkbox.addEventListener('change', function () {
                    if (checkbox.checked) {
                        addToSelectedIds(checkbox.value);
                    } else {
                        removeFromSelectedIds(checkbox.value);
                    }
                });
            });
            const allChecked = checkboxes.length === selectedIds.length;
            document.getElementById('select-all').checked = allChecked;
        });
        function approveSelected() {
            const selectedIds = JSON.parse(localStorage.getItem('selected_ids')) || [];
            if (selectedIds.length > 0) {
                if (confirm('Apakah Anda yakin ingin menyetujui pendaftaran yang dipilih?')) {
                    fetch("{{ route('admin.bulkApprove') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ ids: selectedIds }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Pendaftaran yang dipilih telah disetujui dan email telah dikirim!');
                                localStorage.removeItem('selected_ids');
                                location.reload();
                            } else {
                                alert('An error occurred while processing approvals.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An unexpected error occurred.');
                        });
                }
            } else {
                alert('Tidak ada data yang dipilih.');
            }
        }
    </script>
</x-app-layout>