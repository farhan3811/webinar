<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-full border">
                        <thead>
                            <tr class="bg-sky-800 text-white font-medium">
                                <th class="border px-4 py-2">Waktu</th>
                                <th class="border px-4 py-2">Penerima</th>
                                <th class="border px-4 py-2">Subjek</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Pesan Error</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td class="border px-4 py-2">{{ $log->created_at }}</td>
                                    <td class="border px-4 py-2">{{ $log->recipient }}</td>
                                    <td class="border px-4 py-2">{{ $log->subject }}</td>
                                    <td class="border px-4 py-2">
                                        <span class="{{ $log->status === 'Sukses' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $log->status }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2">{{ $log->error_message ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center border px-4 py-2">Belum ada log email</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
