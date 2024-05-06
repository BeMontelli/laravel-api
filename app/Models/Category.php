<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Category",
 *     required={"title","description"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the category"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the category"
 *     ),
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'title',
        'description',
    ];

    public function products(): BelongsToMany
    {
        return $this->BelongsToMany(Product::class)->withTimestamps();
    }
}
