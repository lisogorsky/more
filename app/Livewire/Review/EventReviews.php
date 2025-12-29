<?php

namespace App\Livewire\Review;


use Livewire\Component;
use App\Models\Review;

class EventReviews extends Component
{
    public ?int $eventId = null;
    public int $perPage = 5;

    public function mount(?int $eventId = null): void
    {
        $this->eventId = $eventId;
    }

    public function render()
    {
        $query = Review::query();

        if ($this->eventId !== null) {
            $query->where('event_id', $this->eventId);
        }

        $reviews = $query
            ->latest()
            ->take($this->perPage)
            ->limit(3)
            ->get();

        $total = $query->count();

        return view('livewire.review.event-reviews', [
            'reviews' => $reviews,
            'total' => $total,
        ]);
    }
}
