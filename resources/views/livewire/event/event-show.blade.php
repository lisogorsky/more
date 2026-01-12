<div class="container py-4">

    {{-- Назад --}}
    <a href="{{ url()->previous() }}" wire:navigate class="text-muted mb-3 d-inline-block">
        ← Назад
    </a>

    <h1 class="mb-3">{{ $event->name }}</h1>

    {{-- Галерея --}}
    <div class="row mb-4">
        @foreach ($event->images as $image)
            <div class="col-md-3 mb-2">
                <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded">
            </div>
        @endforeach
    </div>

    <p class="lead">{{ $event->description }}</p>


    <div>
        <strong>Адрес:</strong> {{ $event->address }}
    </div>
    <div>
        <strong>Категория:</strong> {{ optional($event->category)->name ?? 'Без категории' }}
        <strong>Подкатегория:</strong> {{ optional($event->subcategory)->name ?? 'Без подкатегории' }}
    </div>






    <hr>

    <div class="row g-3">
        <div class="col-md-4">
            <strong>Дата:</strong>
            {{ $event->date_start->format('d.m.Y') }}
        </div>

        <div class="col-md-4">
            <strong>Время:</strong>
            {{ $event->time_start }}
        </div>

        <div class="col-md-4">
            <strong>Цена:</strong>
            {{ number_format($event->price, 0, '.', ' ') }} ₽
        </div>
    </div>

</div>
