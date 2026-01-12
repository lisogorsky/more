<div class="container mt-4" x-data="eventForm()" x-cloak>

    <!-- Заголовок -->
    <div class="d-flex align-items-center gap-2 mb-3">
        <a href="/cabinet/organizer" class="text-decoration-none text-dark">←</a>
        <h1 class="mb-0">Новое событие</h1>
    </div>

    <form wire:submit.prevent="save">

        <!-- Название -->
        <div class="mb-3">
            <label class="form-label">Название события</label>
            <input type="text" class="form-control" wire:model.defer="title">
            @error('title')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Дата и время начала и окончания -->
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label">Дата и время начала</label>
                <input type="datetime-local" class="form-control" wire:model.defer="start_at">
                @error('start_at')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Дата и время окончания</label>
                <input type="datetime-local" class="form-control" wire:model.defer="end_at">
                @error('end_at')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Описание -->
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <div wire:ignore x-data="{ content: @entangle('description') }" x-on:trix-change="content = $event.target.value">
                <input id="x" type="hidden" :value="content">
                <trix-editor input="x" class="form-control" style="min-height: 200px;"></trix-editor>
            </div>
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Стоимость и скидка -->
        <div class="row mb-3" x-data="{
            hasDiscount: @entangle('has_discount'),
            discountType: @entangle('discount_type')
        }">
            <div class="col-md-6 mb-3">
                <label class="form-label">Стоимость</label>
                <div class="input-group">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" type="checkbox" wire:model="price_from" id="price_from">
                        <label class="form-check-label ms-2" for="price_from">от</label>
                    </div>
                    <input type="number" class="form-control" placeholder="0" wire:model="price">
                    <span class="input-group-text">₽</span>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label d-block">Скидка</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" role="switch" x-model="hasDiscount">
                    <label class="form-check-label">Установить скидку</label>
                </div>

                <div class="mt-2" x-show="hasDiscount" x-transition>
                    <div class="input-group">
                        <select class="form-select" style="max-width: 100px;" x-model="discountType">
                            <option value="percent">%</option>
                            <option value="amount">Сумма</option>
                        </select>
                        <input type="number" class="form-control"
                            :placeholder="discountType === 'percent' ? '%' : '₽'" wire:model="discount_value">
                    </div>
                </div>
            </div>
        </div>

        <!-- Максимальное количество участников -->
        <div class="mb-3" x-data="{ count: @entangle('max_participants') }">
            <label class="form-label">Максимальное количество участников</label>
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-outline-secondary" @click="if(count > 0) count--">-</button>

                <input type="number" class="form-control text-center" style="max-width: 100px;" x-model="count"
                    readonly>

                <button type="button" class="btn btn-outline-secondary" @click="count++">+</button>
            </div>
        </div>

        <!-- Выбор локации -->
        <div class="mb-3">
            <label class="form-label">Город</label>
            @livewire('city.city-select', key('city-select'))
            @error('city')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Адрес</label>
            @livewire('city.address-suggest', ['wire:model' => 'address'], key('address-suggest'))
            @error('address')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Категории -->
        <div class="mb-3">
            <label class="form-label">Категория/подкатегория</label>
            <div wire:click="toggleCategories"
                class="d-flex justify-content-between align-items-center p-2 border rounded" style="cursor:pointer;">
                <span>Выберите из списка</span>
                <span>
                    @if ($showCategories)
                        ▼
                    @else
                        ▶
                    @endif
                </span>
            </div>

            @if ($showCategories)
                <ul class="list-group mt-2">
                    @foreach ($categories as $category)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center"
                                wire:click="toggleCategory({{ $category->id }})" style="cursor:pointer;">
                                {{ $category->name }}
                                <span>
                                    @if ($openCategoryId === $category->id)
                                        ▼
                                    @else
                                        ▶
                                    @endif
                                </span>
                            </div>
                            @if ($openCategoryId === $category->id && $category->subcategories->count())
                                <ul class="list-group mt-2">
                                    @foreach ($category->subcategories as $sub)
                                        <li class="list-group-item ps-4">
                                            <input type="radio" wire:model="subcategory_id"
                                                value="{{ $sub->id }}">
                                            {{ $sub->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
            @error('subcategory_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Загрузка файлов -->
        <div class="mb-3" x-data>
            <label class="form-label">Фото и видео</label>
            <div class="border border-secondary rounded p-4 text-center" x-on:click="$refs.mediaInput.click()"
                x-on:dragover.prevent x-on:drop.prevent="handleFiles($event.dataTransfer.files)">
                <p class="mb-0 text-muted">Перетащите файлы сюда или кликните, чтобы выбрать</p>

                <input type="file" x-ref="mediaInput" multiple style="display:none" wire:model="media"
                    x-on:change="handleFiles($event.target.files)">
            </div>

            <!-- Превью -->
            <div class="mt-2 row g-2">
                <template x-for="(file, index) in files" :key="index">
                    <div class="col-3 text-center position-relative">
                        <template x-if="file.type.startsWith('image')">
                            <img :src="file.url" class="img-fluid rounded" style="max-height:100px;">
                        </template>
                        <template x-if="!file.type.startsWith('image')">
                            <div class="border rounded p-2">
                                <i class="bi bi-file-earmark-video"></i>
                                <div class="small" x-text="file.name"></div>
                            </div>
                        </template>
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                            x-on:click="remove(index)" style="font-size:0.7rem;">✕</button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Ссылки на видео -->
        <div class="mb-3" x-data="videoForm()" x-cloak>
            <label class="form-label">Ссылки на видео</label>
            <div class="d-flex mb-2">
                <input type="text" class="form-control me-2" placeholder="Вставьте ссылку на видео"
                    x-model="newVideo" @keydown.enter.prevent="addVideo()">
                <button type="button" class="btn btn-primary" @click="addVideo()">Добавить</button>
            </div>

            <template x-for="(video, index) in videos" :key="index">
                <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                    <span x-text="video"></span>
                    <button type="button" class="btn btn-sm btn-danger" @click="removeVideo(index)">✕</button>
                </div>
            </template>

            <!-- Связываем с Livewire -->
            <input type="hidden" name="videos" :value="videos.join(',')" wire:model.defer="videos">
        </div>

        <!-- Партнеры -->
        <div class="mb-3" x-data="{ receiveOffers: false }">
            <h3>Приглашенные партнеры</h3>
            <label class="form-label">
                После публикации события вы сможете пригласить к участию партнёров — музыкантов,
                исполнителей, фотографов, поставщиков услуг и т.д.
                Привлекайте больше участников и вносите разнообразие в свои мероприятия с помощью коллабораций!
            </label>

            <!-- Рычажок -->
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" role="switch" id="receiveOffers"
                    x-model="receiveOffers" wire:model.defer="receive_offers">
                <label class="form-check-label" for="receiveOffers">Получать предложения от партнеров</label>
            </div>

            <!-- Раскрывающаяся секция -->
            <div class="mt-3 border rounded p-3" x-show="receiveOffers" x-transition>
                <label class="form-label">Какие предложения вы хотите получать?</label>
                <p class="text-muted small">Выберите категории партнёров / предложений:</p>

                @foreach ($partnerCategories as $category)
                    <div class="form-check" wire:key="partner-category-{{ $category->id }}">
                        <input class="form-check-input" type="checkbox" value="{{ $category->id }}"
                            id="partnerCategory{{ $category->id }}" wire:model.defer="partner_categories">
                        <label class="form-check-label" for="partnerCategory{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Кнопки -->
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="/cabinet/organizer" class="btn btn-secondary">Отмена</a>
        </div>

    </form>

    <!-- Скрипты Alpine.js -->
    <script>
        function eventForm() {
            return {
                files: [],

                handleFiles(fileList) {
                    const newFiles = Array.from(fileList);
                    const uniqueFiles = newFiles.filter(f => !this.files.some(file => file.name === f.name && file.size ===
                        f.size));

                    uniqueFiles.forEach(f => {
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.files.push({
                                name: f.name,
                                type: f.type,
                                url: e.target.result,
                                file: f
                            });
                        };
                        reader.readAsDataURL(f);
                    });

                    // Обновляем Livewire input
                    const dt = new DataTransfer();
                    uniqueFiles.forEach(f => dt.items.add(f));
                    this.$refs.mediaInput.files = dt.files;
                },

                remove(index) {
                    this.files.splice(index, 1);
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f.file));
                    this.$refs.mediaInput.files = dt.files;
                }
            }
        }

        function videoForm() {
            return {
                videos: @entangle('videos'),
                newVideo: '',

                addVideo() {
                    if (this.newVideo.trim()) {
                        this.videos.push(this.newVideo.trim());
                        this.newVideo = '';
                    }
                },

                removeVideo(index) {
                    this.videos.splice(index, 1);
                }
            }
        }
    </script>

    <style>
        trix-toolbar .trix-button-group--file-tools {
            display: none !important;
        }

        /* Для всех браузеров */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
            /* Firefox */
        }
    </style>
</div>
