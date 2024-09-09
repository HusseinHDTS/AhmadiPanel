<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceListRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'owner_id' => 'nullable|string|max:255',
      'action_owner_id' => 'nullable|numeric',
      'recipt_date' => 'nullable|string|max:255',
      'customer_name' => 'nullable|string|max:255',
      'customer_phone' => 'nullable|string|max:255',
      'customer_postcode' => 'nullable|string|max:255',
      'customer_city' => 'nullable|string|max:255',
      'customer_address' => 'nullable|string|max:255',
      'way_to_know' => 'nullable|string|max:255',
      'way_to_know_name' => 'nullable|string|max:255',
      'order_type' => 'nullable|string|max:255',
      'order_type_name' => 'nullable|string|max:255',
      'way_to_send' => 'nullable|string|max:255',
      'way_to_send_name' => 'nullable|string|max:255',
      'payment_type' => 'nullable|string|max:255',
      'description' => 'nullable|string|max:255',
      'status' => 'nullable|string|max:255',
      'status_name' => 'nullable|string|max:255',
      'status_code' => 'nullable|string|max:255',
      'payment_type_name' => 'nullable|string|max:255',
      'payment_bank_name' => 'nullable|string|max:255',
      'payment_date' => 'nullable|string|max:255',
      'invoice_details' => 'nullable|array',
      'full_price' => [
        'nullable',
        function ($attribute, $value, $fail) {
          // Remove commas from the value before validating
          $cleanedValue = str_replace(',', '', $value);

          // Validate the cleaned value as numeric
          if (!is_numeric($cleanedValue)) {
            $fail("The $attribute must be a valid numeric value.");
          }
        },
      ],
      'price_off' => [
        'nullable',
        function ($attribute, $value, $fail) {
          // Remove commas from the value before validating
          $cleanedValue = str_replace(',', '', $value);

          // Validate the cleaned value as numeric
          if (!is_numeric($cleanedValue)) {
            $fail("The $attribute must be a valid numeric value.");
          }
        },
      ],
      'price_paying' => [
        'nullable',
        function ($attribute, $value, $fail) {
          // Remove commas from the value before validating
          $cleanedValue = str_replace(',', '', $value);

          // Validate the cleaned value as numeric
          if (!is_numeric($cleanedValue)) {
            $fail("The $attribute must be a valid numeric value.");
          }
        },
      ],
      'price_remaining' => [
        'nullable',
        function ($attribute, $value, $fail) {
          // Remove commas from the value before validating
          $cleanedValue = str_replace(',', '', $value);

          // Validate the cleaned value as numeric
          if (!is_numeric($cleanedValue)) {
            $fail("The $attribute must be a valid numeric value.");
          }
        },
      ],
    ];
  }
}
