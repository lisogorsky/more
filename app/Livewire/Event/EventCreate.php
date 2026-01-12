<?php

namespace App\Livewire\Event;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Event;
use App\Models\Video;
use App\Models\CategoryPartner;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

class EventCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $description = '';

    public $start_at;
    public $end_at;

    public $price;
    public $price_from = false;
    public $has_discount = false;
    public $discount_type = 'percent';
    public $discount_value;

    public $categories = [];
    public $subcategory_id;

    public $city_id;
    public $address;

    public $max_participants = 0;

    public array $partner_categories = [];
    public Collection $partnerCategories;

    public $showCategories = false;
    public $openCategoryId = null;

    public $media = [];   // TemporaryUploadedFile для изображений
    public array $videos = [];  // Ссылки на видео

    protected $rules = [
        'title' => 'required|string|max:255',
        'start_at' => 'required|date',
        'end_at' => 'required|date|after_or_equal:start_at',
        'date' => 'required|date',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:sub_categories,id',
        'media.*' => 'image|max:10240',
        'videos.*' => 'url',
    ];

    public function mount()
    {
        $this->categories = Category::with('subcategories')->get();
        $this->partnerCategories = CategoryPartner::all();
        $this->description = '';
    }

    public function toggleCategories()
    {
        $this->showCategories = !$this->showCategories;
    }

    public function toggleCategory($id)
    {
        $this->openCategoryId = $this->openCategoryId === $id ? null : $id;
        $this->subcategory_id = null;
    }

    #[On('citySelected')]
    public function updateCity($cityId)
    {
        $this->city_id = $cityId;
    }

    #[On('addressUpdated')]
    public function updateAddress($address)
    {
        $this->address = $address;
    }

    public function save()
    {
        // 1. Валидация (добавлены новые поля)
        $this->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required',
            'end_at' => 'required',
            'description' => 'required|string',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'price' => 'required|numeric|min:0',
            'media.*' => 'image|max:10240',
        ]);

        // 2. Определяем category_id на основе выбранной подкатегории, 
        // если она еще не установлена
        $category = \App\Models\SubCategory::find($this->subcategory_id);

        // 3. Создаём событие (сопоставление с миграцией)
        $event = Event::create([
            'name'             => $this->title,          // В миграции 'name'
            'description'      => $this->description,
            'slug'             => \Illuminate\Support\Str::slug($this->title) . '-' . uniqid(),
            'address'          => $this->address,
            'city_id'          => $this->city_id,

            // Даты (в миграции date_start/date_end и time_start/time_end)
            'date_start'       => date('Y-m-d', strtotime($this->start_at)),
            'date_end'         => date('Y-m-d', strtotime($this->end_at)),
            'time_start'       => date('H:i', strtotime($this->start_at)),
            'time_end'         => date('H:i', strtotime($this->end_at)),

            'price'            => $this->price,
            'price_from'       => $this->price_from,
            'has_discount'     => $this->has_discount,
            'discount_type'    => $this->discount_type,
            'discount_value'   => $this->discount_value,

            'max_participants'            => $this->max_participants,

            'category_id'      => $category->category_id,
            'sub_category_id'  => $this->subcategory_id,
            'organizer_id' => auth()->user()->organizer->id,
        ]);

        // 4. Сохраняем изображения
        if ($this->media) {
            foreach ($this->media as $file) {
                $path = $file->store('events', 'public');
                $event->images()->create([
                    'path' => $path,
                    'alt' => $this->title,
                    'title' => $this->title,
                ]);
            }
        }

        // 5. Сохраняем видео
        foreach ($this->videos as $url) {
            Video::create([
                'event_id' => $event->id,
                'url' => $url,
            ]);
        }

        // 6. Категории партнёров
        if (!empty($this->partner_categories)) {
            $event->partnerCategories()->sync($this->partner_categories);
        }

        session()->flash('success', 'Событие успешно создано!');

        return redirect()->route('cabinet.organizer');
    }

    public function render()
    {
        return view('livewire.event.event-create')->layout('layouts.app');
    }
}
