<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-brand-900 overflow-hidden">
        <div class="absolute inset-y-0 w-full h-full bg-brand-900/90 mix-blend-multiply"></div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl text-center">
                Viva experiências incríveis
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-brand-100 text-center">
                Descubra os melhores eventos esportivos, shows e workshops perto de você.
            </p>
            
            <!-- Search Bar -->
            <div class="mt-10 max-w-3xl mx-auto bg-white rounded-lg p-2 shadow-xl">
                <form action="/events" method="GET" class="md:flex md:items-center">
                    <div class="flex-1 min-w-0 px-4 py-2 border-b md:border-b-0 md:border-r border-gray-200">
                        <label for="search" class="sr-only">Buscar</label>
                        <input type="text" name="q" id="search" class="block w-full border-0 focus:ring-0 sm:text-sm p-2" placeholder="O que você procura? (Ex: Corrida, Workshop)">
                    </div>
                    <div class="w-full md:w-48 px-4 py-2 border-b md:border-b-0 md:border-r border-gray-200">
                        <select name="city" class="block w-full border-0 focus:ring-0 sm:text-sm p-2 bg-transparent">
                            <option value="">Todas as Cidades</option>
                            <option value="Sao Paulo">São Paulo</option>
                            <option value="Rio de Janeiro">Rio de Janeiro</option>
                            <option value="Curitiba">Curitiba</option>
                        </select>
                    </div>
                    <div class="w-full md:w-auto p-2">
                        <button type="submit" class="w-full md:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-600 hover:bg-brand-700 md:py-2 md:text-sm md:px-10">
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Featured Events -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Eventos em Destaque</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Loop through events (Placeholder Logic in View for Demo) -->
                @forelse($featuredEvents ?? [] as $event)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group">
                    <div class="relative h-48 bg-gray-200">
                        <img src="{{ $event->coverImage->path ?? 'https://via.placeholder.com/400x200' }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-gray-800">
                            {{ $event->category->name ?? 'Evento' }}
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="text-xs font-semibold text-brand-600 mb-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $event->start_date?->format('d/m/Y') ?? 'Em breve' }}
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 leading-tight">
                            <a href="/events/{{ $event->slug }}" class="hover:text-brand-600">
                                {{ $event->title }}
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-1">
                            {{ $event->city ?? 'Online' }} • {{ $event->state }}
                        </p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-gray-900 font-bold">
                                A partir de R$ {{ number_format(($event->tickets->min('price') ?? 0) / 100, 2, ',', '.') }}
                            </span>
                            <a href="/events/{{ $event->slug }}" class="text-brand-600 hover:text-brand-800 text-sm font-medium">
                                Inscrever-se &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center text-gray-500">
                    Nenhum evento encontrado no momento.
                </div>
                @endforelse
            </div>
            
            <div class="mt-12 text-center">
                <a href="/events" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Ver todos os eventos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
