<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    function index(Request $request): JsonResponse{
        $name = $request->name;
            
       $categories =  Category::when($name , function($q , $name) {
            $q->where('name' , 'like' , "%$name%");
       })->withCount('books')->get();
       
       return apiSuccess("كافة الأصناف" , $categories );
    }
    
    function show(category $category): JsonResponse{
        // $category=Category::findOrFail($id);
       return apiSuccess(" بيانات الصنف " , $category );
    }
    
    function store(Request $request): JsonResponse{
         $request->validate([
            'name' => 'required|max:50|unique:categories'
        ]);
        // return $request;
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();  
       return apiSuccess("  تم إضافة السجل بنجاح " , $category , 201);
    }

    function update(Request $request , Category $category):JsonResponse{
        $request->validate([
            'name' => "required|max:50|unique:categories,name,$category->id"
        ]);
        // $category = Category::findOrFail($id);
         $category->name = $request->name;
        $category->description = $request->description;
        $category->save();  
       return apiSuccess("  تم تعديل السجل بنجاح " , $category );
    }

    function destroy(Category $category):JsonResponse{
        // $category = Category::findOrFail($id);
        if ( $category->books()->count())
            return apiFail("لا يمكن محي صنف يتضمن كتب");
        $category->delete();
       return apiSuccess("  تم حذف السجل بنجاح " );
    }
}
