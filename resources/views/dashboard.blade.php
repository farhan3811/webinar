<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="card bg-base-100 w-full shadow-xl">
                    <div class="flex w-full gap-4 p-8">
                        <div class="card-body shadow-xl rounded-lg w-full h-40 bg-gradient-to-r from-green-400 to-blue-500 text-white">
                            <h2 class="flex justify-center text-6xl font-bold">{{ $totalPendaftar }}</h2>
                            <p class="flex justify-end text-lg font-medium">Pendaftar</p>
                        </div>
                        <div class="card-body shadow-xl rounded-lg w-full h-40 bg-gradient-to-r from-purple-500 to-indigo-500 text-white">
                            <h2 class="flex justify-center text-6xl font-bold">{{ $totalApproved }}</h2>
                            <p class="flex justify-end text-lg font-medium">Approved</p>
                        </div>
                        <div class="card-body shadow-xl rounded-lg w-full h-40 bg-gradient-to-r from-yellow-400 to-orange-500 text-white">
                            <h2 class="flex justify-center text-6xl font-bold">{{ $totalCheckIn }}</h2>
                            <p class="flex justify-end text-lg font-medium">Check In</p>
                        </div>
                    </div>
                    <div class="p-8">
                        <canvas id="myBarChart" class="w-full h-96"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pendaftar', 'Approved', 'Check In'], 
                datasets: [{
                    label: 'Jumlah Data',
                    data: [{{ $totalPendaftar }}, {{ $totalApproved }}, {{ $totalCheckIn }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
