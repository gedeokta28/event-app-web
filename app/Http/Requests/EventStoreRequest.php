<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set to true if you want to allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_name'         => 'required|string|max:100',
            'event_start_date'   => 'required|date',
            'event_end_date'     => 'required|date',
            'event_location'     => 'required|string|max:150',
            'event_time'         => 'nullable|string|max:100',
            'logo_file'          => 'nullable|image',
            'intro_file'         => 'nullable|image',
            'event_description'  => 'nullable|string|max:1000',
            'event_active'       => 'nullable|boolean',
            'event_max_pax'      => 'required|integer',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Optional: Modify or set additional data before validation if needed
    }
}
