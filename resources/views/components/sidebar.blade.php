<aside class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-center h-16 bg-primary-600">
            <span class="text-white text-lg font-bold">Smart Laundry</span>
        </div>

        <!-- Sidebar Content -->
        <div class="flex-1 flex flex-col bg-primary-500">
            <nav class="flex-1 px-2 py-4 space-y-1">
                @if(auth()->user()->role === 'admin')
                    <x-nav-link 
                        href="{{ route('admin.dashboard') }}" 
                        :active="request()->routeIs('admin.dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link 
                        href="{{ route('kios.index') }}" 
                        :active="request()->routeIs('kios.*')">
                        Manajemen Kios
                    </x-nav-link>
                    <!-- Admin Menu Items -->
                @elseif(auth()->user()->role === 'owner')
                    <x-nav-link 
                        href="{{ route('owner.dashboard') }}" 
                        :active="request()->routeIs('owner.dashboard')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </x-nav-link>

                    <x-nav-link 
                        href="{{ route('owner.workers.index') }}" 
                        :active="request()->routeIs('owner.workers.*')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Pekerja
                    </x-nav-link>

                    <x-nav-link 
                        href="{{ route('owner.reports.index') }}" 
                        :active="request()->routeIs('owner.reports.*')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Laporan
                    </x-nav-link>

                    <x-nav-link 
                        href="{{ route('owner.services.index') }}" 
                        :active="request()->routeIs('owner.services.*')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2M7 7h10"/>
                        </svg>
                        Layanan
                    </x-nav-link>

                    <x-nav-link 
                        href="{{ route('owner.whatsapp.scan') }}" 
                        :active="request()->routeIs('owner.whatsapp.*')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        WhatsApp
                    </x-nav-link>
                    <!-- Owner Menu Items -->
                @elseif(auth()->user()->role === 'worker')
                    <!-- Worker Profile -->
                    <div class="flex items-center space-x-4 mb-6">
                        <img class="h-12 w-12 rounded-full" 
                            src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
                            alt="{{ auth()->user()->name }}">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</h3>
                            <p class="text-xs text-gray-500">Worker</p>
                        </div>
                    </div>

                    <!-- Worker Navigation -->
                    <nav class="space-y-1">
                        <x-nav-link href="{{ route('worker.dashboard') }}" :active="request()->routeIs('worker.dashboard')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </x-nav-link>

                        <x-nav-link href="{{ route('worker.orders.index') }}" :active="request()->routeIs('worker.orders.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Manajemen Order
                        </x-nav-link>

                        <x-nav-link href="{{ route('worker.customers.index') }}" :active="request()->routeIs('worker.customers.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Manajemen Pelanggan
                        </x-nav-link>

                        <x-nav-link href="{{ route('worker.status.index') }}" :active="request()->routeIs('worker.status.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Status Worker
                        </x-nav-link>

                        <x-nav-link href="{{ route('worker.profile.index') }}" :active="request()->routeIs('worker.profile.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </x-nav-link>
                    </nav>

                    <!-- Worker Status Indicator -->
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full {{ auth()->user()->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-2"></span>
                                <span class="text-sm text-gray-600">{{ auth()->user()->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                            @if(auth()->user()->is_active)
                            <form action="{{ route('worker.status.end') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                    Akhiri Shift
                                </button>
                            </form>
                            @else
                            <form action="{{ route('worker.status.start') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-green-600 hover:text-green-800">
                                    Mulai Shift
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @else
                    <x-nav-link 
                        href="{{ route('worker.dashboard') }}" 
                        :active="request()->routeIs('worker.dashboard')">
                        Dashboard
                    </x-nav-link>
                    <!-- Worker Menu Items -->
                @endif
            </nav>
        </div>
    </div>
</aside> 