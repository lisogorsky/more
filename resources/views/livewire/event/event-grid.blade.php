<div x-data="{ loading: false }"
    x-on:scroll.window.throttle.200ms="
        if (loading) return; 

        const scrollPosition = window.scrollY + window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;

        if (scrollPosition > documentHeight - 300) {
            loading = true;
            $wire.call('loadMore'); // Вызов метода Livewire
        }
    "
    x-on:loaded.window="loading = false">

    {{-- 🔁 Переключатель --}}
    <div class="d-flex justify-content-end mb-4">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary {{ $view === 'grid' ? 'active' : '' }}"
                wire:click="changeView('grid')">
                ⬛ Сетка
            </button>
            <button type="button" class="btn btn-outline-secondary {{ $view === 'list' ? 'active' : '' }}"
                wire:click="changeView('list')">
                ☰ Список
            </button>
        </div>
    </div>

    {{-- 🟦 СЕТКА --}}
    @if ($view === 'grid')
        <div class="row">
            @forelse($events as $event)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">

                        {{-- 🖼 Слайдер изображений --}}
                        <div class="position-relative" style="height:180px; overflow:hidden;" x-data="{
                            index: 0,
                            images: @js($event->images->pluck('path')),
                            next() {
                                this.index = (this.index + 1) % this.images.length
                            },
                            prev() {
                                this.index = (this.index - 1 + this.images.length) % this.images.length
                            }
                        }">

                            {{-- Картинка --}}
                            <img :src="images.length ?
                                '{{ asset('storage') }}/' + images[index] :
                                '{{ asset('images/no-image.jpg') }}'"
                                class="card-img-top" style="height:180px; object-fit:cover;" alt="{{ $event->name }}">

                            {{-- Кнопки --}}
                            <template x-if="images.length > 1">
                                <button @click.stop="prev"
                                    class="btn btn-dark btn-sm position-absolute top-50 translate-middle-y opacity-75"
                                    style="left: 8px;">
                                    ‹
                                </button>
                            </template>
                            <template x-if="images.length > 1">
                                <button @click.stop="next"
                                    class="btn btn-dark btn-sm position-absolute top-50 translate-middle-y opacity-75"
                                    style="right: 8px;"> ›
                                </button>
                            </template>

                            {{-- Точки --}}
                            <template x-if="images.length > 1">
                                <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 d-flex gap-1">
                                    <template x-for="(img, i) in images" :key="i">
                                        <button @click.stop="index = i" class="rounded-circle border-0"
                                            :class="index === i ? 'bg-white' : 'bg-secondary'"
                                            style="width:8px;height:8px;">
                                        </button>
                                    </template>
                                </div>
                            </template>

                        </div>

                        {{-- 📦 Контент карточки --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $event->name }}</h5>

                            <small class="text-muted">
                                {{ optional($event->category)->name ?? 'Без категории' }} /
                                {{ optional($event->subCategory)->name ?? 'Без подкатегории' }}
                            </small>

                            <p class="mt-2 text-muted">
                                {{ Str::limit($event->description, 60) }}
                            </p>

                            <div class="mt-auto">
                                <div class="fw-bold text-primary">
                                    {{ number_format($event->price, 0, '.', ' ') }} ₽
                                </div>
                                <small class="text-muted">
                                    {{ $event->date_start->format('d.m.Y') }}
                                </small>
                            </div>

                            <div>
                                {{ $event->user->name }}
                                <img src="{{ asset($event->user->avatar) }}" class="rounded-circle"
                                    style="width:20px; height:20px;">

                            </div>

                            <div>
                                {{ $event->address }}
                            </div>

                            <div>
                                {{ $event->time_start }}
                            </div>

                            <div>
                                {{ $event->category->name }}
                            </div>

                            <div>
                                {{ $event->duration_minutes }}
                            </div>

                        </div>

                    </div>
                </div>
            @empty
                <p class="text-muted">События не найдены</p>
            @endforelse
        </div>
    @endif


    {{-- 📄 СПИСОК --}}
    @if ($view === 'list')
        <div class="list-group">
            @forelse($events as $event)
                <div class="list-group-item mb-3 shadow-sm">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-md-3">
                            <img src="{{ asset('storage/' . optional($event->images->first())->path) }}"
                                class="img-fluid rounded" alt="{{ $event->name }}">
                        </div>
                        <div class="col">
                            <h5 class="mb-1">{{ $event->name }}</h5>
                            <small class="text-muted">
                                {{ optional($event->category)->name ?? 'Без категории' }} /
                                {{ optional($event->subCategory)->name ?? 'Без подкатегории' }}
                            </small>
                            <p class="mt-2 mb-1">{{ Str::limit($event->description, 140) }}</p>
                        </div>
                        <div class="col-12 col-md-2 text-md-end fw-bold text-primary">
                            {{ number_format($event->price, 0, '.', ' ') }} ₽
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">События не найдены</p>
            @endforelse
        </div>
    @endif

    {{-- Лоадер --}}
    <div class="text-center my-3" x-show="loading">
        Загрузка...
    </div>
</div>
