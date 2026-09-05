<?php

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Jobs\SendInquiryNotification;

class PropertyInquiryForm extends Component
{
    public Property $property;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public bool $submitted = false;

    public function mount(Property $property): void
    {
        $this->property = $property;

        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone ?? '';
        }

        $this->message = "Hi, I am interested in '{$property->title}' (₹" . number_format($property->price) . "). Please share more details and schedule a walkthrough.";
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|min:10|max:20',
            'message' => 'required|string|min:10|max:1000',
        ];
    }

    public function submitInquiry(): void
    {
        $validated = $this->validate();

        $inquiry = Inquiry::create([
            'property_id' => $this->property->id,
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        SendInquiryNotification::dispatch($inquiry);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.property-inquiry-form');
    }
}
