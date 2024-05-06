<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Product",
 *     required={"name", "description", "price", "stock", "image"},
 *     @OA\Property(property="id", type="integer", example=123),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          description="The name of the product"
 *     ),
 *     @OA\Property(
 *          property="description",
 *          type="string",
 *          description="The description of the product"
 *     ),
 *     @OA\Property(
 *          property="price",
 *          type="number",
 *          format="float",
 *          description="The price of the product"
 *     ),
 *     @OA\Property(
 *          property="stock",
 *          type="integer",
 *          description="The stock of the product"
 *     ),
 *     @OA\Property(
 *          property="image",
 *          type="string",
 *          example="images/uploads/2024/05/02/image.jpg",
 *          description="The image URL of the user"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-05-06T12:34:56Z",
 *         description="The timestamp when the user was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-05-06T12:34:56Z",
 *         description="The timestamp when the user was last updated"
 *     ),
 *     @OA\Property(
 *         property="categories",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Category")
 *     )
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
    ];

    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(Category::class)->withTimestamps();
    }
}
