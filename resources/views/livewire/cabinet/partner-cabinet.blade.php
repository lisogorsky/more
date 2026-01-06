<div class="p-4">
    <h1 class="mb-2">Кабинет партнера</h1>
    {{-- Меню --}}
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'my_offers') active @endif"
                wire:click.prevent="setTab('bookings')">Мои предложения</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'statistics') active @endif"
                wire:click.prevent="setTab('bookings')">Статистика</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'statistics') active @endif"
                wire:click.prevent="setTab('bookings')">Предложения и отклики</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'documents') active @endif"
                wire:click.prevent="setTab('documents')">Документы</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'filters') active @endif"
                wire:click.prevent="setTab('reviews')">Отзывы</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'chats') active @endif"
                wire:click.prevent="setTab('chats')">Чаты и уведомления</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($tab === 'employees') active @endif"
                wire:click.prevent="setTab('settings')">Сотрудники</a>
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
