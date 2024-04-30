<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::create($request->all());

        return response()->json([
            'message' => 'Category created successfully',
            'status' => 'success',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = Category::with('products')->find($category->id);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::find($category->id);

        if (!$category) {
            return response()->json(['message' => 'Category not found', 'status' => 'error'], 404);
        }

        $category->update($request->all());

        return response()->json([
            'message' => 'Category updated successfully',
            'status' => 'success',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category = Category::find($category->id);

        if (!$category) return response()->json(['message' => 'Resource not found', 'status' => 'error'], 404);

        $category->delete();

        return response()->json(['message' => 'Resource deleted successfully', 'status' => 'success'], 200);
    }
}
