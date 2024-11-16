<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('data-checkin') }}" class="mb-4">
                        <div class="flex items-center">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari berdasarkan Nama, NIM, atau Kode Unik"
                                class="w-full p-2 border border-gray-300 rounded"
                            />
                            <button
                                type="submit"
                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                            >
                                Cari
                            </button>
                        </div>
                    </form>
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-sky-800 text-white font-medium">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Kode Unik</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">NIM</th>
                                <th class="border px-4 py-2">Prodi</th>
                                <th class="border px-4 py-2">Waktu Check-In</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkIns as $index => $checkIn)
                                <tr>
                                    <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $checkIn->kode_unik }}</td>
                                    <td class="border px-4 py-2">{{ $checkIn->name }}</td>
                                    <td class="border px-4 py-2">{{ $checkIn->nim }}</td>
                                    <td class="border px-4 py-2">{{ $checkIn->program_studi }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $checkIn->check_in_date ? $checkIn->check_in_date->format('d-m-Y H:i:s') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Jika Data Kosong -->
                    @if ($checkIns->isEmpty())
                        <p class="mt-4 text-gray-500 text-center">Belum ada data check-in.</p>
                    @endif

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $checkIns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
