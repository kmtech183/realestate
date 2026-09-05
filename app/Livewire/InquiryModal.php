<?php

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InquiryModal extends Component
{
    public ?Property $property = null;
    public bool $isOpen = false;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public bool $submitted = false;

    protected $listeners = ['openInquiryModal'];

    public function openInquiryModal(int $propertyId): void
    {
        $this->property = Property::find($propertyId);
        $this->isOpen = true;
        $this->submitted = false;

        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone ?? '';
        }

        if ($this->property) {
            $this->message = "Hello, I would like to schedule a private visit for '{$this->property->title}'.";
        }
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|min:10|max:20',
            'message' => 'required|string|min:10|max:1000',
        ]);

        if ($this->property) {
            Inquiry::create([
                'property_id' => $this->property->id,
                'user_id' => Auth::id(),
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'message' => $this->message,
                'status' => 'new',
            ]);

            $this->submitted = true;
        }
    }

    public function render()
    {
        return view('livewire.inquiry-modal');
    }
}
