<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('DataMahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex mb-4">
                        <input type="text" id="search" class="form-input w-1/3" placeholder="Cari Mahasiswa..." />
                        <form action="{{ route('admin.exportExcel') }}" method="GET" class="ml-4 inline">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-black rounded">Export Excel</button>
                        </form>
                        <a href="{{ route('admin.scanQr') }}" class="ml-4 px-4 py-2 bg-indigo-500 text-black rounded">
                            Scan QR
                        </a>
                    </div>

                    <table class="min-w-full border-collapse table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Nama</th>
                                <th class="px-4 py-2 border-b">Email</th>
                                <th class="px-4 py-2 border-b">NIM</th>
                                <th class="px-4 py-2 border-b">Program Studi</th>
                                <th class="px-4 py-2 border-b">Kehadiran</th>
                                <th class="px-4 py-2 border-b">Status</th>
                                <th class="px-4 py-2 border-b">Status</th>
                                <th class="px-4 py-2 border-b">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach($registrations as $registration)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $registration->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $registration->email }}</td>
                                    <td class="px-4 py-2 border-b">{{ $registration->nim }}</td>
                                    <td class="px-4 py-2 border-b">{{ $registration->program_studi }}</td>
                                    <td class="px-4 py-2 border-b">{{ $registration->attendance_type }}</td>
                                    <td class="px-4 py-2 border-b">{{ $registration->checked_in }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <span class="inline-block px-2 py-1 text-sm font-semibold rounded-full 
                                            {{ $registration->status == 'approved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2 border-b">
                                        <form action="{{ route('admin.approve', $registration->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="approved" class="px-4 py-2 bg-green-500 text-black rounded">Approve</button>
                                        </form>
                                        <a href="{{ route('admin.details', $registration->id) }}" class="ml-2 px-4 py-2 bg-blue text-black rounded">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $registrations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            let searchQuery = this.value.toLowerCase();
            let rows = document.querySelectorAll('#table-body tr');
            rows.forEach(function(row) {
                let name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                let email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                let nim = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (name.includes(searchQuery) || email.includes(searchQuery) || nim.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function filterByStatus(status) {
            let url = new URL(window.location.href);
            url.searchParams.set('status', status);
            window.location.href = url.href;
        }
    </script>
</x-app-layout>
