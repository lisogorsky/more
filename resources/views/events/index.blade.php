@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Все события</h1>

    <livewire:event.event-grid />
    <div class="mt-5">
        <livewire:event-organizers.event-organizers-grid wire:key="organizers-grid" />
    </div>
@endsection
