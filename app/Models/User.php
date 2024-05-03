<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * @var string
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="User's name",
     *     example="John Doe"
     * )
     */
    protected $name;

    /**
     * @var string
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     format="email",
     *     description="User's email address",
     *     example="john@example.com"
     * )
     */
    protected $email;

    /**
     * @var string
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     format="password",
     *     description="User's password",
     *     example="password123"
     * )
     */
    protected $password;

    /**
     * @var string
     * @OA\Property(
     *     property="profile_photo_url",
     *     type="string",
     *     format="uri",
     *     description="URL of the user's profile photo",
     *     example="https://example.com/profile.jpg"
     * )
     */
    private $profile_photo_url;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
}
