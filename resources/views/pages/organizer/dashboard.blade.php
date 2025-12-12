<x-organizer-layout>
    @section('header', 'Visão Geral')

    <div class="mt-4">
        <!-- KPI Cards -->
        <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
            <div class="w-full px-6 py-5 bg-white rounded-lg shadow-md flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Receita Total</p>
                    <p class="text-2xl font-bold text-gray-700">R$ 124.500,00</p>
                </div>
            </div>

            <div class="w-full px-6 py-5 bg-white rounded-lg shadow-md flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Ingressos Vendidos</p>
                    <p class="text-2xl font-bold text-gray-700">1,240</p>
                </div>
            </div>

            <div class="w-full px-6 py-5 bg-white rounded-lg shadow-md flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <svg class="h-4 w-4 absolute ml-4 -mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Visitas na Página</p>
                    <p class="text-2xl font-bold text-gray-700">45.2k</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Vendas (Últimos 30 dias)</h3>
                <canvas id="salesChart"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Ingressos por Modalidade</h3>
                <canvas id="modalityChart"></canvas>
            </div>
        </div>
        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['01/01', '05/01', '10/01', '15/01', '20/01', '25/01'], // Mock dates
                    datasets: [{
                        label: 'Receita (R$)',
                        data: [1200, 1900, 3000, 5000, 2000, 3000],
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.1)',
                        fill: true,
                    }]
                },
                options: { responsive: true, interaction: { intersect: false, mode: 'index' } }
            });

            // Modality Chart
            const ctx2 = document.getElementById('modalityChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Corrida 5K', 'Corrida 10K', 'Caminhada', 'Kids'],
                    datasets: [{
                        data: [40, 30, 20, 10],
                        backgroundColor: ['#0ea5e9', '#0284c7', '#0369a1', '#cbd5e1']
                    }]
                }
            });
        });
    </script>
</x-organizer-layout>
