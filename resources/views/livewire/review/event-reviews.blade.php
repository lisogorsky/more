<div>
    <h3 class="text-lg font-semibold mb-4">Отзывы</h3>

    @forelse($reviews as $review)
        <div class="mb-4 border-b pb-2">
            <div class="font-medium">{{ $review->author_name }}</div>
            <div class="text-sm text-gray-500">
                {{ $review->created_at->format('d.m.Y') }}
            </div>
            <p class="mt-1">{{ $review->review }}</p>

            @if ($review->images->isNotEmpty())
                <div class="mt-2">
                    @foreach ($review->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" class="w-24 h-24 object-cover" alt="">
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <p class="text-gray-500">Отзывов пока нет</p>
    @endforelse

</div>
