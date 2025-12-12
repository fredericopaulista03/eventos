<x-app-layout>
    <!-- Event Header -->
    <div class="relative bg-gray-900 h-96">
        <img src="https://via.placeholder.com/1920x600" alt="Event Cover" class="w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
                <span class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-white uppercase bg-brand-600 rounded-full">
                    Esporte
                </span>
                <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl">
                    Maratona de São Paulo 2025
                </h1>
                <div class="mt-4 flex flex-wrap items-center text-gray-200">
                    <div class="flex items-center mr-6 mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        15 de Outubro, 2025
                    </div>
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        Parque Ibirapuera, SP
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Sobre o Evento</h2>
                    <div class="prose max-w-none text-gray-500">
                        <p>Prepare-se para o maior desafio do ano! A Maratona de SP reúne atletas de todo o mundo. Percurso plano, hidratação a cada 3km e kit premium.</p>
                        <p class="mt-4">Retirada de Kit no Ginásio do Ibirapuera nos dias 13 e 14.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Selecione seus Ingressos</h2>
                    
                    <div class="space-y-4">
                        <!-- Ticket Item -->
                        <div class="border rounded-lg p-4 flex justify-between items-center hover:border-brand-500 transition-colors">
                            <div>
                                <h3 class="font-bold text-lg">Kit Básico - 5km</h3>
                                <p class="text-sm text-gray-500">Camiseta, número de peito e medalha.</p>
                                <p class="text-brand-600 font-bold mt-2">R$ 89,90</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:bg-gray-100">-</button>
                                <span class="font-bold w-4 text-center">0</span>
                                <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:bg-gray-100">+</button>
                            </div>
                        </div>

                        <!-- Ticket Item -->
                        <div class="border rounded-lg p-4 flex justify-between items-center hover:border-brand-500 transition-colors">
                            <div>
                                <h3 class="font-bold text-lg">Kit Premium - 21km</h3>
                                <p class="text-sm text-gray-500">Camiseta manga longa, viseira, pochete.</p>
                                <p class="text-brand-600 font-bold mt-2">R$ 149,90</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:bg-gray-100">-</button>
                                <span class="font-bold w-4 text-center">0</span>
                                <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:bg-gray-100">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6 flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Total</p>
                            <p class="text-2xl font-bold text-gray-900">R$ 0,00</p>
                        </div>
                        <button class="px-8 py-3 bg-brand-600 text-white font-bold rounded-lg hover:bg-brand-700 shadow-lg transform transition hover:-translate-y-0.5">
                            Realizar Inscrição
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 mt-8 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h3 class="font-bold text-gray-900 mb-4">Organizadores</h3>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">
                            TS
                        </div>
                        <div class="ml-4">
                            <p class="font-bold">TicketSports BR</p>
                            <a href="#" class="text-brand-600 text-sm">Ver perfil</a>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <p class="font-bold text-gray-900 mb-2">Localização</p>
                        <div class="bg-gray-100 h-48 rounded-lg mb-2 flex items-center justify-center text-gray-400">
                            Mapa
                        </div>
                        <p class="text-sm text-gray-600">Av. Pedro Álvares Cabral - Vila Mariana, São Paulo - SP</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
