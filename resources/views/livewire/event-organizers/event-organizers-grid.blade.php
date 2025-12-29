<div class="organizers">
    <div class="section-header">
        <h2 class="section-title">
            Организаторы
        </h2>
        <a href="#">
            Показать ещё 
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 0L6.59 1.41L12.17 7H0V9H12.17L6.59 14.59L8 16L16 8L8 0Z" fill="#0B6FF6" />
            </svg>
        </a>
    </div>

    @if ($organizers->isEmpty())
    <p class="text-gray-500">Организаторы не найдены</p>
    @else
    <div class="grid-4-cols">
        @foreach ($organizers as $organizer)
        <div class="organizers-card">
            <div class="organizers-card__avatar">
                <img src="{{ $organizer->avatar ?? '/img/avatar.png' }}" class="organizers-card__avatar-image" alt="">
            </div>
            <div class="organizers-card__content">
                <div class="organizers-card__name">
                    <a href="#">{{ $organizer->name }}</a>
                </div>
                <div class="organizers-card__category">
                    Велотуры и велопоходы
                    <!-- {{ $organizer->email }} -->
                </div>
                <div class="organizers-card__footer">
                    <div class="raiting">
                        <div class="raiting-stars">
                            <img src="{{ asset('images/raiting_star-yellow.svg') }}" alt="">
                            <img src="{{ asset('images/raiting_star-yellow.svg') }}" alt="">
                            <img src="{{ asset('images/raiting_star-yellow.svg') }}" alt="">
                            <img src="{{ asset('images/raiting-star.svg') }}" alt="">
                            <img src="{{ asset('images/raiting_star-grey.svg') }}" alt="">
                        </div>
                        <div class="raiting-stars__value">
                            4,2
                        </div>
                    </div>
                    <div class="organizers-card__comments">
                        <a href="#">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.71667 8.16667L6.66667 6.98333L8.61667 8.16667L8.1 5.95L9.83333 4.45L7.55 4.26667L6.66667 2.16667L5.78333 4.26667L3.5 4.45L5.23333 5.95L4.71667 8.16667ZM0 13.3333V1.33333C0 0.966667 0.130556 0.652778 0.391667 0.391667C0.652778 0.130556 0.966667 0 1.33333 0H12C12.3667 0 12.6806 0.130556 12.9417 0.391667C13.2028 0.652778 13.3333 0.966667 13.3333 1.33333V9.33333C13.3333 9.7 13.2028 10.0139 12.9417 10.275C12.6806 10.5361 12.3667 10.6667 12 10.6667H2.66667L0 13.3333ZM2.1 9.33333H12V1.33333H1.33333V10.0833L2.1 9.33333Z" fill="#0B6FF6" />
                            </svg>
                        </a>
                        <div class="organizers-card__value">
                            128
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>