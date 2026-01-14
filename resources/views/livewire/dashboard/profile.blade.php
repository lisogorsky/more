<div class="container my-4 p-4 bg-white rounded shadow-sm">
    <form wire:submit.prevent="save">

        {{-- Контейнер: аватар слева, поля справа --}}
        <div class="row g-3 align-items-start">

            {{-- Фото --}}
            <div class="col-auto text-center">
                <div class="mb-2" style="width: 100px; height: 100px;">
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}"
                            class="img-fluid rounded border w-100 h-100 object-fit-cover">
                    @else
                        @php
                            $currentImage = $profile['logo'] ?? ($profile['avatar'] ?? null);
                        @endphp
                        @if ($currentImage)
                            <img src="{{ asset('storage/' . $currentImage) }}"
                                class="img-fluid rounded border w-100 h-100 object-fit-cover">
                        @else
                            <img src="{{ asset('images/default-placeholder.png') }}"
                                class="img-fluid rounded border w-100 h-100 object-fit-cover">
                        @endif
                    @endif
                </div>

                <input type="file" wire:model="photo" class="form-control form-control-sm">
                <div wire:loading wire:target="photo" class="text-muted small mt-1">Загрузка...</div>
                @error('photo')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            {{-- Поля --}}
            <div class="col">
                {{-- Динамические поля профиля --}}
                @if ($activeRole === 3)
                    <h5>Данные партнера</h5>
                    <div class="mb-3">
                        <input type="text" wire:model="profile.company_name" placeholder="Название компании"
                            class="form-control">
                    </div>
                @elseif ($activeRole === 2)
                    <h5>Данные организатора</h5>

                    <div class="mb-3">
                        <label class="form-label">Название организации</label>
                        <input type="text" wire:model="profile.name" placeholder="Введите название"
                            class="form-control">
                        @error('profile.name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea wire:model="profile.description" rows="3" placeholder="Расскажите о себе или организации"
                            class="form-control"></textarea>
                        @error('profile.description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Публичный адрес (Slug)</label>
                        <input type="text" wire:model="profile.public_slug" placeholder="my-org-name"
                            class="form-control">
                        @error('profile.public_slug')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                @elseif ($activeRole === 1)
                    <h5>Данные участника</h5>
                    <div class="mb-3">
                        <input type="text" wire:model="profile.bio" placeholder="О себе" class="form-control">
                    </div>
                @endif
            </div>

        </div>

        <div class="mt-4">
            <h5>Мои языки</h5>
            <div class="d-flex flex-wrap gap-2 mb-3">
                @forelse($myLanguages as $lang)
                    <span class="badge bg-primary d-flex align-items-center p-2">
                        {{ $lang->name }}
                        {{-- Кнопка удаления просто убирает ID из массива --}}
                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.5rem"
                            wire:click="$set('profile.selected_languages', {{ collect($this->profile['selected_languages'])->reject(fn($id) => $id == $lang->id)->values() }})">
                        </button>
                    </span>
                @empty
                    <span class="text-muted">Вы еще не выбрали языки</span>
                @endforelse
            </div>

            <h5>Доступные языки</h5>
            <div class="row row-cols-2 row-cols-md-4 g-2">
                @foreach ($availableLanguages as $lang)
                    <div class="col">
                        <div class="form-check border rounded p-2">
                            {{-- При клике ID добавится в массив, и в следующем цикле render язык исчезнет отсюда --}}
                            <input class="form-check-input ms-0 me-2" type="checkbox" value="{{ $lang->id }}"
                                wire:model="profile.selected_languages" id="lang_{{ $lang->id }}">
                            <label class="form-check-label" for="lang_{{ $lang->id }}">
                                {{ $lang->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="my-4">


        {{-- Категории --}}
        <div class="categories-selection">
            <label class="font-bold mb-2 block">Выберите категории:</label>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 border p-4 rounded-lg bg-gray-50">
                @foreach ($availableCategories as $category)
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="cat-{{ $category->id }}" value="{{ $category->id }}"
                            wire:model.live="profile.selected_categories"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="cat-{{ $category->id }}" class="text-sm cursor-pointer select-none">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            @if (!empty($profile['selected_categories']))
                <div class="mt-4">
                    <label class="text-xs text-gray-500 uppercase">Выбрано:</label>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach ($myCategories as $category)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $category->name }}
                                <button type="button" wire:click="removeCategory({{ $category->id }})"
                                    class="ml-2 inline-flex items-center justify-center text-blue-400 hover:text-blue-600 focus:outline-none">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Кнопка --}}
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary me-3">Сохранить изменения</button>
            <div wire:loading wire:target="save" class="text-muted small">Сохранение...</div>
        </div>

    </form>
</div>
