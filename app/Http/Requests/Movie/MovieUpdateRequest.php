<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class MovieUpdateRequest extends FormRequest
{
    /**
     * Upravení filmu je možné jen pro uživatele, který ho vytvořil.
     *
     *
     * @todo Dokončit !!!
     */
    public function authorize(): bool
    {
        // if (! $this->user) {
        //    return false;
        //}

        // /** @var Movie $movie */
        // $movie = $this->route('movie');

        // if ($this->user->id !== $movie->user_id) {
        //     return false;
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
