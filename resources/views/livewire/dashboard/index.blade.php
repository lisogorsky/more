<div class="p-4">
    <h1 class="mb-2">Настройки профиля</h1>
    {{-- Меню --}}
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'settings') active @endif"
                wire:click.prevent="setTab('settings')">Настройки</a>
        </li>
    </ul>

    {{-- Контент --}}
    <div class="card p-3">
        @switch($tab)
            @case('bookings')
                <livewire:dashboard.bookings />
            @break

            @case('filters')
                <livewire:dashboard.saved-filters />
            @break

            @case('media')
                <livewire:dashboard.media />
            @break

            @case('favorites')
                <livewire:dashboard.favorites />
            @break

            @case('partners')
                <livewire:dashboard.partners />
            @break

            @case('chats')
                <livewire:dashboard.chats />
            @break

            @case('settings')
                <livewire:dashboard.settings />
            @break
        @endswitch
    </div>
</div>
