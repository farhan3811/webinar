<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex mb-4">
                        <input type="text" id="search" class="form-input w-1/3" placeholder="Cari Mahasiswa..." />
                        <form action="{{ route('admin.exportExcel') }}" method="GET" class="ml-4 inline">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Export Excel</button>
                        </form>
                        <a href="{{ route('admin.scanQr') }}" class="ml-4 px-4 py-2 bg-rose-500 text-white rounded">
                            Scan QR
                        </a>
                        <button onclick="approveSelected()" class="px-4 py-2 bg-green-500 text-white rounded ml-4">Approve All</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse table-auto">
                            <thead>
                                <tr class="bg-sky-800 text-white font-medium">
                                    <th class="px-4 py-2 border-b">
                                        <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th class="px-4 py-2 border-b">Kode Unik</th>
                                    <th class="px-4 py-2 border-b">Nama</th>
                                    <th class="px-4 py-2 border-b">Email</th>
                                    <th class="px-4 py-2 border-b">NIM</th>
                                    <th class="px-4 py-2 border-b">Program Studi</th>
                                    <th class="px-4 py-2 border-b">Kehadiran</th>
                                    <th class="px-4 py-2 border-b">Status</th>
                                    <th class="px-4 py-2 border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach($registrations as $index => $registration)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sky-100' }}">
                                        <td class="px-4 py-2 border-b">
                                            <input type="checkbox" class="select-checkbox" value="{{ $registration->id }}" />
                                        </td>
                                        <td class="px-4 py-2 border-b">{{ $registration->kode_unik }}</td>
                                        <td class="px-4 py-2 border-b">{{ $registration->name }}</td>
                                        <td class="px-4 py-2 border-b">{{ $registration->email }}</td>
                                        <td class="px-4 py-2 border-b">{{ $registration->nim }}</td>
                                        <td class="px-4 py-2 border-b">{{ $registration->program_studi }}</td>
                                        <td class="px-4 py-2 border-b">{{ $registration->graduation_type }}</td>
                                        <td class="px-4 py-2 border-b">
                                            <span class="inline-block px-2 py-1 text-sm font-semibold rounded-full 
                                                {{ $registration->status == 'approved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        </td>
                                        <td class="flex px-4 py-2 border-b">
                                            <form action="{{ route('admin.approve', $registration->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status" value="approved" class="px-4 py-2 bg-green-500 text-white rounded">Approve</button>
                                            </form>
                                            <a href="{{ route('admin.details', $registration->id) }}" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Detail</a>
                                            <a href="{{ route('admin.details', $registration->id) }}" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Edit</a>
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

    <script>
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
        document.addEventListener("DOMContentLoaded", function() {
            const selectedIds = JSON.parse(localStorage.getItem('selected_ids')) || [];
            const checkboxes = document.querySelectorAll('.select-checkbox');
            checkboxes.forEach(checkbox => {
                if (selectedIds.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
                checkbox.addEventListener('change', function() {
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
                if (confirm('Are you sure you want to approve the selected registrations?')) {
                    fetch("{{ route('admin.bulkApprove') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Selected registrations have been approved!');
                            location.reload();
                        } else {
                            alert('Error occurred while approving selected registrations.');
                        }
                    });
                }
            } else {
                alert('No registrations selected.');
            }
        }
    </script>
</x-app-layout>
