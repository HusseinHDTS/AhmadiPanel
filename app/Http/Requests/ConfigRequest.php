<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
      'title' => 'nullable|string|max:255',
      'order' => 'nullable|integer',
      'active' => 'nullable|string',
      'internet_type' => 'nullable|string',
      'assigned_to' => 'nullable|integer|exists:users,id', // Adjust the table name and column if needed
      'config' => 'nullable|string', // Use 'text' if you have custom validation logic or need more control
    ];
  }
}
