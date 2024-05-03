<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Category",
 *     description="Category model",
 *     required={"title"},
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category extends Model
{
    use HasFactory;

    /**
     * @var string
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     description="Category title",
     *     example="Electronics"
     * )
     */
    protected $title;

    /**
     * @var string|null
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Category description",
     *     example="A category for electronic products."
     * )
     */

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
