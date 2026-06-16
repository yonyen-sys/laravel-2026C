<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd("mix prolong msel minh");
        $products = Product::with('category')->get();
        return response()->json([
            'success' => true,
            'data'    => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Requirement C: Explicit Input Validation Matrix via Validator::make()
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price'       => 'required|numeric|min:0',
            'qty'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);
        // Graceful error pipeline triggering a 422 standard response structure
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation parameters failed.',
                'errors'  => $validator->errors()
            ], 422);
        }
        $validated = $validator->validated();
        $validated['is_active'] = $request->boolean('is_active', true);
        // File Upload Pipeline
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }
        $product = Product::create($validated);
        $product->load('category');
        return response()->json([
            'success' => true,
            'data'    => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->find($id);
        return response()->json([
            'success' => true,
            'data'    => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $product = Product::find($id);
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price'       => 'required|numeric|min:0',
            'qty'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation parameters failed.',
                'errors'  => $validator->errors()
            ], 422);
        }
        $validated = $validator->validated();
        $validated['is_active'] = $request->boolean('is_active', $product->is_active);
        // File Replacement Pipeline
        if ($request->hasFile('image')) {
            // Delete old file asset from storage disk if a replacement exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }
        $product->update($validated);
        $product->load('category');
        return response()->json([
            'success' => true,
            'data'    => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product and linked assets successfully removed.'
        ], 200);
    }
}
