<?php

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;

class GenreListRequest extends FormRequest
{
    /**
     * Prohlížení filmových žánrů je dostupné pro každého platného uživatele.
     * 
     * @return boolean
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
