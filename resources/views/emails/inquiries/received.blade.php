<x-mail::message>
    # 🏢 New Property Inquiry Received

    You have received a new inquiry for your listing:
    **{{ $inquiry->property->title }}**.

    <x-mail::panel>
        ### Client Details
        - **Name:** {{ $inquiry->name }}
        - **Email:** {{ $inquiry->email }}
        - **Phone:** {{ $inquiry->phone }}
        - **Locality:** {{ $inquiry->property->locality }},
        {{ $inquiry->property->city }}
        - **Listing Price:**
        {{ $inquiry->property->formatted_price }}
    </x-mail::panel>

    ### Message from Client:
    > "{{ $inquiry->message }}"

    <x-mail::button :url="route(
        'properties.show',
        $inquiry->property->slug,
    )">
        View Property Listing
    </x-mail::button>

    Thanks,<br>
    **Gujarat Premier Realty Team**
</x-mail::message>
