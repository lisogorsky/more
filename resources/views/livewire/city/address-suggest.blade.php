<div x-data="{ open: false }" @click.away="open = false" class="position-relative">
    <input type="text" class="form-control" wire:model.live.debounce.500ms="query" @focus="open = true"
        @keydown.escape="open = false" placeholder="Улица, дом" {{ !$cityId ? 'disabled' : '' }} autocomplete="off">

    @if (count($suggestions))
        <ul class="list-group position-absolute w-100 shadow-sm" style="z-index:1000;" x-show="open">
            @foreach ($suggestions as $item)
                <li class="list-group-item list-group-item-action" wire:click="select('{{ $item['value'] }}')"
                    @click="open = false">
                    {{ $item['value'] }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
