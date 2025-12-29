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
        <div class="grid-4-cols">
            @forelse($events as $event)
                <div class="events-col">
                    <div class="event-card">

                        {{-- 🖼 Слайдер изображений --}}
                        <div class="event-card__carousel position-relative" style="height:180px; overflow:hidden;"
                            x-data="{
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
                        <div class="event-card__header">
                            <div class="event-card__user">
                                <div class="event-card__user-avatar">
                                    <img src="{{ asset($event->user->avatar) }}" alt="{{ $event->user->name }}">
                                </div>
                                <div class="event-card__user-name">
                                    {{ $event->user->name }}
                                </div>
                            </div>
                            <div class="event-card__raiting"><!-- Fake -->
                                <span class="event-card__raiting-star">
                                    <img src="{{ asset('images/raiting-star.svg') }}" alt="">
                                </span>
                                <span class=" event-card__raiting-value">4.2</span>
                                <span class="event-card__raiting-rewievs">(56 отзывов)</span>
                            </div><!--end Fake -->
                        </div>


                        <div class=" event-card__body d-flex flex-column">
                            <h2 class="event-card__title">
                                <a href="{{ route('event.show', $event) }}" wire:navigate class="event-card__link">
                                    {{ $event->name }}
                                </a>
                            </h2>

                            <div class="event-card__start">
                                <div class="event-card__start-date">
                                    {{ $event->date_start->format('d.m.Y') }}
                                </div>
                                <div class="event-card__start-time">
                                    {{ $event->time_start }}
                                </div>
                                <div class="event-card__start-duration">
                                    {{ $event->duration_minutes }} часов
                                </div>
                            </div>

                            <div class="event-card__adress">
                                {{ $event->address }}
                            </div>

                            <div class="event-card__footer">
                                <div class="event-card__footer-col">
                                    <div class="event-card__categories"><!-- Fake -->
                                        <a href="#" class="event-card__category">
                                            <svg width="11" height="11" viewBox="0 0 11 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2.66602 2.66602C2.89703 2.66602 3.10636 2.7282 3.29297 2.85254C3.47953 2.97691 3.61716 3.14621 3.70605 3.35938L5.33301 7.4668H3.7334V10.666H1.59961V7.4668H0L1.62598 3.35938C1.71487 3.1461 1.85341 2.97696 2.04004 2.85254C2.2265 2.72836 2.43523 2.66607 2.66602 2.66602ZM9.66602 2.83301C9.94102 2.83301 10.1772 2.93112 10.373 3.12695C10.5687 3.32272 10.666 3.55816 10.666 3.83301V6.83301H9.66602V10.333H7.66602V6.83301H6.66602V3.83301C6.66602 3.55808 6.76424 3.32275 6.95996 3.12695C7.15572 2.9312 7.39116 2.83309 7.66602 2.83301H9.66602ZM8.66602 0.333008C8.94102 0.333008 9.17721 0.43112 9.37305 0.626953C9.56866 0.822722 9.66602 1.05816 9.66602 1.33301C9.66602 1.60786 9.56866 1.84329 9.37305 2.03906C9.17721 2.2349 8.94102 2.33301 8.66602 2.33301C8.39116 2.33293 8.15572 2.23482 7.95996 2.03906C7.76424 1.84326 7.66602 1.60793 7.66602 1.33301C7.66602 1.05808 7.76424 0.822754 7.95996 0.626953C8.15572 0.431197 8.39116 0.333085 8.66602 0.333008ZM2.66602 0C2.95935 0 3.21103 0.104588 3.41992 0.313477C3.62857 0.522294 3.7334 0.773241 3.7334 1.06641C3.73338 1.35957 3.6286 1.61052 3.41992 1.81934C3.21103 2.02822 2.95935 2.13281 2.66602 2.13281C2.37282 2.13274 2.1219 2.02815 1.91309 1.81934C1.7043 1.61049 1.59962 1.35965 1.59961 1.06641C1.59961 0.773164 1.70433 0.522327 1.91309 0.313477C2.1219 0.104665 2.37282 7.73002e-05 2.66602 0Z" />
                                            </svg>
                                        </a>
                                        <a href="#" class="event-card__category">
                                            <svg width="11" height="10" viewBox="0 0 11 10"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.33333 9.78667L4.56 9.09333C3.66222 8.28445 2.92 7.58667 2.33333 7C1.74667 6.41333 1.28 5.88667 0.933333 5.42C0.586667 4.95333 0.344444 4.52444 0.206667 4.13333C0.0688889 3.74222 0 3.34222 0 2.93333C0 2.09778 0.28 1.4 0.84 0.84C1.4 0.28 2.09778 0 2.93333 0C3.39556 0 3.83556 0.0977778 4.25333 0.293333C4.67111 0.488889 5.03111 0.764445 5.33333 1.12C5.63556 0.764445 5.99556 0.488889 6.41333 0.293333C6.83111 0.0977778 7.27111 0 7.73333 0C8.56889 0 9.26667 0.28 9.82667 0.84C10.3867 1.4 10.6667 2.09778 10.6667 2.93333C10.6667 3.34222 10.5978 3.74222 10.46 4.13333C10.3222 4.52444 10.08 4.95333 9.73333 5.42C9.38667 5.88667 8.92 6.41333 8.33333 7C7.74667 7.58667 7.00444 8.28445 6.10667 9.09333L5.33333 9.78667Z" />
                                            </svg>
                                        </a>
                                        <a href="#" class="event-card__category">
                                            <svg width="15" height="12" viewBox="0 0 15 12"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0 12V4H1.33333V5.33333H2.66667V0H4V1.33333H5.33333V0H6.66667V1.33333H8V0H9.33333V1.33333H10.6667V0H12V5.33333H13.3333V4H14.6667V12H8.66667V10C8.66667 9.63333 8.53611 9.31944 8.275 9.05833C8.01389 8.79722 7.7 8.66667 7.33333 8.66667C6.96667 8.66667 6.65278 8.79722 6.39167 9.05833C6.13056 9.31944 6 9.63333 6 10V12H0ZM1.33333 10.6667H4.66667V10C4.66667 9.26667 4.92778 8.63889 5.45 8.11667C5.97222 7.59444 6.6 7.33333 7.33333 7.33333C8.06667 7.33333 8.69444 7.59444 9.21667 8.11667C9.73889 8.63889 10 9.26667 10 10V10.6667H13.3333V6.66667H10.6667V2.66667H4V6.66667H1.33333V10.6667ZM5.33333 6H6.66667V4H5.33333V6ZM8 6H9.33333V4H8V6Z" />
                                            </svg>
                                        </a>
                                        <!-- {{ $event->category->name }} -->
                                    </div><!--end Fake -->
                                    <div class="event-card__col-wrapper">
                                        <div class="event-card__limit">
                                            до <span class="event-card__limit-value">{{ $event->limit }}</span> человек
                                        </div>
                                        <a href="#" class="event-card__comments"><!-- Fake -->
                                            <div class="event-card__comments-icon">
                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3333 13.3333L10.6667 10.6667H4C3.63333 10.6667 3.31944 10.5361 3.05833 10.275C2.79722 10.0139 2.66667 9.7 2.66667 9.33333V8.66667H10C10.3667 8.66667 10.6806 8.53611 10.9417 8.275C11.2028 8.01389 11.3333 7.7 11.3333 7.33333V2.66667H12C12.3667 2.66667 12.6806 2.79722 12.9417 3.05833C13.2028 3.31944 13.3333 3.63333 13.3333 4V13.3333ZM1.33333 6.78333L2.11667 6H8.66667V1.33333H1.33333V6.78333ZM0 10V1.33333C0 0.966667 0.130556 0.652778 0.391667 0.391667C0.652778 0.130556 0.966667 0 1.33333 0H8.66667C9.03333 0 9.34722 0.130556 9.60833 0.391667C9.86944 0.652778 10 0.966667 10 1.33333V6C10 6.36667 9.86944 6.68056 9.60833 6.94167C9.34722 7.20278 9.03333 7.33333 8.66667 7.33333H2.66667L0 10Z" />
                                                </svg>
                                            </div>
                                            <div class="event-card__comments-value">
                                                120
                                            </div>
                                        </a><!--end Fake -->
                                    </div>
                                </div>
                                <div class=" event-card__footer-col">
                                    <div class="event-card__price">
                                        <span>{{ number_format($event->price, 0, '.', ' ') }}</span> ₽
                                    </div>
                                    <div class="event-card__limit-alert">
                                        осталось 3 места<!-- Fake -->
                                    </div>
                                </div>
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
                <a href="{{ route('event.show', $event) }}" wire:navigate class="text-decoration-none text-dark">
                    <div class="list-group-item mb-3 shadow-sm">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-3">
                                <img src="{{ asset('storage/' . optional($event->images->first())->path) }}"
                                    class="img-fluid rounded" alt="{{ $event->name }}">
                                </span>
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

                                <div>
                                    {{ $event->user->name }}
                                    <img src="{{ asset($event->user->avatar) }}" class="rounded-circle"
                                        style="width:20px; height:20px;">

                                </div>


                                <div>
                                    {{ $event->date_start->format('d.m.Y') }}
                                    {{ $event->time_start }}
                                </div>

                                <div>
                                    {{ $event->duration_minutes }}
                                </div>

                                <div>
                                    {{ $event->address }}
                                </div>

                                <div>
                                    {{ $event->category->name }}
                                </div>

                                <div>
                                    {{ $event->limit }}
                                </div>


                                <div class="fw-bold text-primary">
                                    {{ number_format($event->price, 0, '.', ' ') }} ₽
                                </div>
                            </div>
                        </div>
                </a>
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
