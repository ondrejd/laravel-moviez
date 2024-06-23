<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class MovieListRequest extends FormRequest
{
    /**
     * Prohlížení filmů je dostupné pro každého platného uživatele.
     *
     *
     * @todo Dokončit !!!
     */
    public function authorize(): bool
    {
        // if (! $this->user) {
        //    return false;
        // }

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
            //
        ];
    }
}
