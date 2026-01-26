<div>
    <div x-data="{ open: false }" class="position-relative">
        <button @click="open = !open" class="btn btn-primary d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid"
                viewBox="0 0 16 16">
                <path
                    d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
            </svg>
            Каталог
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100" @click.away="open = false"
            class="position-absolute start-0 bg-white shadow-lg border rounded-3 p-4"
            style="z-index: 9999; width: 95vw; max-width: 1200px; top: 110%; left: 0;">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 overflow-auto"
                style="max-height: 70vh;">
                @foreach ($categories as $category)
                    <div class="col">
                        <h6 class="fw-bold text-uppercase mb-2 pb-1 border-bottom d-flex align-items-center"
                            style="color: #333; cursor: pointer;"
                            @click="$wire.toggleCategory({{ $category->id }}); open = false;">
                            @if ($category->icon_svg)
                                <span class="me-2 d-inline-block" style="width: 20px;">{!! $category->icon_svg !!}</span>
                            @endif
                            {{ $category->name }}
                        </h6>

                        <ul class="list-unstyled">
                            @foreach ($category->subcategories as $sub)
                                <li class="mb-1">
                                    <a href="#" class="text-decoration-none text-secondary small hover-blue"
                                        @click.prevent="
                                        $wire.selectSubcategory({{ $sub->id }});
                                        Livewire.dispatch('subcategorySelected', { subcategoryId: {{ $sub->id }} });
                                        open = false;
                                   ">
                                        {{ $sub->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            .hover-blue:hover {
                color: #0d6efd !important;
                text-decoration: underline !important;
            }
        </style>
    </div>
</div>
