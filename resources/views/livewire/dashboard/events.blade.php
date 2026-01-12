<div class="container mt-4">
    <div class="mb-3">
        <a href="{{ route('event.create') }}" class="btn btn-primary">
            Добавить событие
        </a>
    </div>

    <ul class="nav nav-tabs" id="eventsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
                type="button" role="tab">
                Предстоящие события
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button"
                role="tab">
                Завершённые события
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="eventsTabContent">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
            <div class="d-flex flex-column gap-3">
                @forelse ($upcomingEvents as $event)
                    <div class="card w-100">
                        <div class="row g-0">
                            <div class="col-md-3">
                                @if ($event->images && $event->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $event->images->first()->path) }}"
                                        class="img-fluid rounded-start h-100"
                                        style="object-fit: cover; min-height: 150px;" alt="{{ $event->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light h-100"
                                        style="min-height: 150px;">
                                        <span class="text-muted">Нет фото</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <p class="card-text text-secondary">
                                        {{ Str::limit(strip_tags($event->description), 150) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar"></i> {{ $event->starts_at->format('d.m.Y H:i') }}
                                        </small>
                                        <span class="badge bg-info text-dark">{{ $event->category->name ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Предстоящих событий нет</p>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="completed" role="tabpanel">
            <div class="d-flex flex-column gap-3">
                @forelse ($completedEvents as $event)
                    <div class="card border-success w-100 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-md-3 bg-light">
                                @if ($event->images && $event->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $event->images->first()->path) }}"
                                        class="img-fluid h-100"
                                        style="object-fit: cover; min-height: 150px; filter: grayscale(40%);"
                                        alt="{{ $event->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted"
                                        style="min-height: 150px;">
                                        <i class="bi bi-image" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title text-success">{{ $event->name }}</h5>
                                        <span class="badge bg-secondary">Завершено</span>
                                    </div>

                                    <p class="card-text">
                                        {{-- Используем strip_tags, чтобы Trix-теги не ломали верстку в списке --}}
                                        {{ Str::limit(strip_tags($event->description), 150) }}
                                    </p>

                                    <div class="mt-auto">
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar-check"></i> Было:
                                            {{ $event->starts_at->format('d.m.Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted">Завершённых событий нет</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
