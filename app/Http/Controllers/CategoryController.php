<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    function index(): JsonResponse{
       $categories =  Category::all();
       
       return ResponseHelper::success("كافة الأصناف" , $categories );
    }
    
    function show(category $category): JsonResponse{
        // $category=Category::findOrFail($id);
       return ResponseHelper::success(" بيانات الصنف " , $category );
    }
    
    function store(Request $request): JsonResponse{
        // return $request;
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();  
       return ResponseHelper::success("  تم إضافة السجل بنجاح " , $category , 201);
    }

    function update(Request $request , category $category):JsonResponse{
        // $category = Category::findOrFail($id);
         $category->name = $request->name;
        $category->description = $request->description;
        $category->save();  
       return ResponseHelper::success("  تم تعديل السجل بنجاح " , $category , 201);
    }

    function destroy(category $category):JsonResponse{
        // $category = Category::findOrFail($id);
        $category->delete();
       return ResponseHelper::success("  تم حذف السجل بنجاح " );
    }
}
