<div x-data="{ open: false }" @click.away="open = false" class="position-relative">
    <input type="text" class="form-control" wire:model.live.debounce.300ms="query" @focus="open = true"
        @keydown.escape="open = false" autocomplete="off">

    @if (count($results))
        <ul class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000;" x-show="open">
            @foreach ($results as $city)
                <li class="list-group-item list-group-item-action" wire:click="selectCity({{ $city->id }})"
                    @click="open = false">
                    {{ $city->name }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
