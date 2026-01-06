<div class="p-4">
    <h1 class="mb-2">Кабинет организатора</h1>
    {{-- Меню --}}
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'my_events') active @endif"
                wire:click.prevent="setTab('bookings')">Мои события</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'statistics') active @endif"
                wire:click.prevent="setTab('bookings')">Статистика</a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if ($tab === 'filters') active @endif"
                wire:click.prevent="setTab('reviews')">Отзывы</a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if ($tab === 'filters') active @endif"
                wire:click.prevent="setTab('partners')">Мои партнеры</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'filters') active @endif"
                wire:click.prevent="setTab('partners')">Мои приглашения</a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if ($tab === 'chats') active @endif"
                wire:click.prevent="setTab('chats')">Чаты и уведомления</a>
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

            @case('chats')
                <livewire:dashboard.chats />
            @break
        @endswitch
    </div>
</div>
