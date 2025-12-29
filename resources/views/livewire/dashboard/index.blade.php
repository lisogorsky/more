<div class="p-4">
    <h1 class="mb-2">Личный кабинет</h1>
    {{-- Меню --}}
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'bookings') active @endif"
                wire:click.prevent="setTab('bookings')">Мои брони</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'filters') active @endif"
                wire:click.prevent="setTab('filters')">Сохранённые фильтры</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'media') active @endif"
                wire:click.prevent="setTab('media')">Медиа</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'favorites') active @endif"
                wire:click.prevent="setTab('favorites')">Избранное</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'partners') active @endif"
                wire:click.prevent="setTab('partners')">Мои партнёры</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'chats') active @endif"
                wire:click.prevent="setTab('chats')">Чаты и уведомления</a>
        </li>
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
