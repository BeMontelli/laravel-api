<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Product",
 *     description="Product model",
 *     required={"name", "description", "price", "image", "stock"},
 *     @OA\Xml(
 *         name="Product"
 *     )
 * )
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @var string
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Product name",
     *     example="Laptop"
     * )
     */
    protected $name;

    /**
     * @var string
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Product description",
     *     example="A powerful laptop with high-end specifications."
     * )
     */
    protected $description;

    /**
     * @var float
     * @OA\Property(
     *     property="price",
     *     type="number",
     *     format="float",
     *     description="Product price",
     *     example=999.99
     * )
     */
    protected $price;

    /**
     * @var string
     * @OA\Property(
     *     property="image",
     *     type="string",
     *     format="uri",
     *     description="URL of the product image",
     *     example="images/uploads/product.jpg"
     * )
     */
    protected $image;

    /**
     * @var integer
     * @OA\Property(
     *     property="stock",
     *     type="integer",
     *     description="Product stock quantity",
     *     example=100
     * )
     */
    protected $stock;

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
