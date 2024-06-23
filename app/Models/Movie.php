<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string|null $csfd Csfd Url
 * @property string|null $imdb ImDb Url
 * @property string|\DateTime $created_at
 * @property string|\DateTime|null $updated_at
 * @property-read User|null $user
 * @property-read Collection<Genre>|Genre[] $genres
 */
class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'csfd',
        'imdb',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['genres', 'user'];

    /**
     * User that created this genre.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Movies that has the genre attached.
     *
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * Model as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'Id' => $this->id,
            'Name' => $this->name,
            'Description' => $this->description,
            'Genres' => $this->genres,
            'Csfd' => $this->csfd,
            'Imdb' => $this->imdb,
        ];
    }
}
