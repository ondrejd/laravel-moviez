<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
{
    /**
     * Vytvoření filmu je dostupné pro každého platného uživatele.
     */
    public function authorize(): bool
    {
        if (! $this->user()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var int[] */
        $genreIds = \App\Models\Genre::all()->pluck('id')->toArray();

        return [
            'Name' => ['string', 'required', 'min:1'],
            'Description' => ['string', 'nullable'],
            'Genres' => ['array'],
            'Genres.*' => [
                'integer',
                function (string $attribute, mixed $value, \Closure $fail) use ($genreIds): void {
                    if (! in_array($value, $genreIds, true)) {
                        $fail('Filmový žánr dle ID nebyl nalezen.');
                    }
                },
            ],
            'Csfd' => ['url:https', 'nullable'],
            'Imdb' => ['url:https', 'nullable'],
        ];
    }
}
