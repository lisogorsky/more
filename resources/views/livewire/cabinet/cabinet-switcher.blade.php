<div class="cabinet-container">
    <div class="user__info-wrap">
        <span class="user__name">{{ Auth::user()->name }}</span>

        <div class="user__discr">
            {{ $cabinets->firstWhere('id', $activeCabinet)?->name ?? 'Роль не определена' }}
        </div>

        <select wire:model.live="activeCabinet" wire:change="switchCabinet($event.target.value)">
            @forelse($cabinets as $cabinet)
                <option value="{{ $cabinet->id }}">{{ $cabinet->name }}</option>
            @empty
                <option value="">Нет доступных кабинетов</option>
            @endforelse
        </select>

        <p>Активный кабинет:
            <strong>{{ $cabinets->firstWhere('id', $activeCabinet)?->name ?? 'Не выбран' }}</strong>
        </p>
    </div>
</div>
