<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

//use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \DateTime|string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \DateTime|string $created_at
 * @property \DateTime|string|null $updated_at
 * @property-read Collection<Genre>|Genre[] $genres
 * @property-read Collection<Movie>|Movie[] $movies
 */
class User extends Authenticatable
{
    use //HasApiTokens,
        HasFactory,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Genres created by the user.
     */
    public function genres(): HasMany
    {
        return $this->hasMany(Genre::class);
    }

    /**
     * Movies created by the user.
     */
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}
