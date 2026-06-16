<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        $authors = Author::latest()->paginate(10);

        return apiSuccess(
            "تم جلب المؤلفين بنجاح",
            AuthorResource::collection($authors)
        );
    }

    public function store(AuthorRequest $request): JsonResponse
    {
        $author = Author::create($request->validated());

        return apiSuccess(
            "تم إنشاء المؤلف بنجاح",
            new AuthorResource($author),
            201
        );
    }

    public function show(Author $author): JsonResponse
    {
        return apiSuccess(
            "تم جلب بيانات المؤلف بنجاح",
            new AuthorResource($author)
        );
    }

    public function update(AuthorRequest $request, Author $author): JsonResponse
    {
        $author->update($request->validated());

        return apiSuccess(
            "تم تحديث بيانات المؤلف بنجاح",
            new AuthorResource($author)
        );
    }

    public function destroy(Author $author): JsonResponse
    {
        $author->delete();

        return apiSuccess(
            "تم حذف المؤلف بنجاح"
        );
    }
}