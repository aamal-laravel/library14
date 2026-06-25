<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\book_stock_operation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class book_stock_operationController extends Controller
{
    public function index(): JsonResponse
    {
        return apiSuccess("Remove_Frome_remaining ", book_stock_operation::all(), 200);
    }
    public function store(Request $request)
    {
        if (Auth::user()->can('create', book_stock_operation::class)) {
            $data = $request->validated();
            book_stock_operation::create($data);
            return apiSuccess('Operation created successfully', null, 201);
        }
        return apiFail("ليس لديك صلاحيات", code: 403);
    }


    function theOperationAdd()
    {
        $author = book_stock_operation::all()->where('type', "LIKE", "add")->sum('quantity');
        return $author;
    }
}
