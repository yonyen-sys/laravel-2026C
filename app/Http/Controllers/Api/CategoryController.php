<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    #[OA\Get(
        path: '/api/categories',
        operationId: 'getCategories',
        tags: ['Categories'],
        summary: 'Get all categories',
        description: 'Returns a list of categories',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Category')
                        ),
                    ]
                )
            ),
        ]
    )]
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'data'    => $categories
        ], Response::HTTP_OK);
    }
    #[OA\Post(
        path: '/api/categories',
        operationId: 'storeCategory',
        tags: ['Categories'],
        summary: 'Create a category',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'dec'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Electronics'),
                    new OA\Property(property: 'dec', type: 'string', example: 'Electronic products'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Category created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Category created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Category'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation failed'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
        ]
    )]
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'dec' => 'required|string',
            'is_active'   => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category = Category::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data'    => $category
        ], Response::HTTP_CREATED);
    }
    #[OA\Get(
        path: '/api/categories/{id}',
        operationId: 'showCategory',
        tags: ['Categories'],
        summary: 'Get category by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Category ID',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Category found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Category'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Category not found'
            ),
        ]
    )]
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'success' => true,
            'data'    => $category
        ], Response::HTTP_OK);
    }
    #[OA\Put(
        path: '/api/categories/{id}',
        operationId: 'updateCategory',
        tags: ['Categories'],
        summary: 'Update category',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Category ID',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'dec'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Electronics'),
                    new OA\Property(property: 'dec', type: 'string', example: 'Updated description'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Category updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Category updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Category'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation failed'
            ),
            new OA\Response(
                response: 404,
                description: 'Category not found'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
        ]
    )]
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'dec' => 'required|string',
            'is_active'   => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data'    => $category
        ], Response::HTTP_OK);
    }
    #[OA\Delete(
        path: '/api/categories/{id}',
        operationId: 'deleteCategory',
        tags: ['Categories'],
        summary: 'Delete category',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Category ID',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Category deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Category deleted successfully.'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Category not found'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
        ]
    )]
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'This category not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ], Response::HTTP_OK);
    }
}
