<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    function index(){
       $categories =  Category::all();
       
       return ResponseHelper::success("كافة الأصناف" , $categories );
    }
    
    function show($id){
        $category=Category::find($id);
       return ResponseHelper::success(" بيانات الصنف " , $category );
    }
    
    function store(Request $request){
        // return $request;
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();  
       return ResponseHelper::success("  تم إضافة السجل بنجاح " , $category , 201);
    }

    function update(Request $request , $id){
        $category = Category::find($id);
         $category->name = $request->name;
        $category->description = $request->description;
        $category->save();  
       return ResponseHelper::success("  تم تعديل السجل بنجاح " , $category , 201);
    }

    function destroy($id){
        $category = Category::find($id);
        $category->delete();
       return ResponseHelper::success("  تم حذف السجل بنجاح " );
    }


}
