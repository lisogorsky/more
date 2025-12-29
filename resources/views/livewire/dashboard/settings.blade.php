<div>
    <p class="mb-2">
        Ваша роль:
        @forelse(auth()->user()->roles as $role)
            <span class="badge bg-primary me-1">
                {{ $role->name }}
                <button wire:click="removeRole({{ $role->id }})" class="btn btn-sm btn-link text-white p-0 ms-1">
                    ✕
                </button>
            </span>
        @empty
            <span>Ролей нет</span>
        @endforelse
    </p>

    <div class="d-flex gap-2 mt-3">
        <select wire:model="roleId" class="form-select w-auto">
            <option value="">Выберите роль</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>

        <button wire:click="addRole" class="btn btn-success btn-sm">
            ➕ Добавить роль
        </button>
    </div>
</div>
