@props(['items' => []])

<nav class="mb-4">
    <ol class="flex items-center space-x-2 text-sm text-gray-500">
        <li>
            <a href="{{ route(auth()->user()->role.'.dashboard') }}" class="hover:text-primary-600">
                Dashboard
            </a>
        </li>
        @foreach($items as $item)
            <li class="flex items-center space-x-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                @if(isset($item['route']))
                    <a href="{{ route($item['route']) }}" class="hover:text-primary-600">
                        {{ $item['name'] }}
                    </a>
                @else
                    <span>{{ $item['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav> 