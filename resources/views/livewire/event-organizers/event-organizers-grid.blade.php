<div>
    <h3 class="text-lg font-semibold mb-4">
        Организаторы
    </h3>

    @if ($organizers->isEmpty())
        <p class="text-gray-500">Организаторы не найдены</p>
    @else
        <ul class="space-y-3">
            @foreach ($organizers as $organizer)
                <li class="flex items-center gap-3">
                    <img src="{{ $organizer->avatar ?? '/img/avatar.png' }}" class="w-10 h-10 rounded-full" alt="">

                    <div>
                        <div class="font-medium">
                            {{ $organizer->name }}
                        </div>

                        <div class="text-sm text-gray-500">
                            {{ $organizer->email }}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
