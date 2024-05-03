<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/v1/products",
     *     summary="Get all products",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function index()
    {
//        $products = Product::all();
//        $products->load(['categories' => function ($query) {
//            $query->select('categories.id', 'categories.title', 'categories.description');
//        }]);
        $products = Product::with('categories')->get();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/v1/products",
     *     summary="Create a new product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function store(Request $request)
    {
        if(!empty($request->categories) && !is_array($request->categories)) {
            $request->merge(['categories' => json_decode($request->categories)]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|decimal:2|min:0',
            'stock' => 'required|integer|min:0',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
            'imagefile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $folders = 'images/uploads/'.date("Y/m/d");
        $extension = $request->imagefile->extension();
        $imageName = time().'-'.Str::slug(basename($request->imagefile->getClientOriginalName(), ".".$extension), '-').'.'.$extension;
        $request->imagefile->move(public_path($folders), $imageName);
        $request->request->add(['image' => $folders.'/'.$imageName]);

        $product = Product::create($request->all());

        $product->categories()->attach($request->categories);
        $product = Product::with('categories')->find($product->id);

        return response()->json([
            'message' => 'Product created successfully',
            'status' => 'success',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/v1/products/{product}",
     *     summary="Get a specific product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function show(Product $product)
    {
        $product = Product::with('categories')->find($product->id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/v1/products/{product}",
     *     summary="Update a specific product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function update(Request $request, Product $product)
    {
        if(!empty($request->categories) && !is_array($request->categories)) {
            $request->merge(['categories' => json_decode($request->categories)]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|decimal:2|min:0',
            'stock' => 'required|integer|min:0',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
            'imagefile' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($product->id);

        if (!$product) {
            return response()->json(['message' => 'Product not found', 'status' => 'error'], 404);
        }

        if($request->imagefile) {
            $folders = 'images/uploads/'.date("Y/m/d");
            $extension = $request->imagefile->extension();
            $imageName = time().'-'.Str::slug(basename($request->imagefile->getClientOriginalName(), ".".$extension), '-').'.'.$extension;
            $request->imagefile->move(public_path($folders), $imageName);
            $request->request->add(['image' => $folders.'/'.$imageName]);
        }

        $product->update($request->all());

        $product->categories()->sync($request->categories);
        $product = Product::with('categories')->find($product->id);

        return response()->json([
            'message' => 'Product updated successfully',
            'status' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/v1/products/{product}",
     *     summary="Delete a specific product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product deleted successfully"
     *     )
     * )
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);

        if (!$product) return response()->json(['message' => 'Resource not found', 'status' => 'error'], 404);

        $product->delete();

        return response()->json(['message' => 'Resource deleted successfully', 'status' => 'success'], 200);
    }
}
