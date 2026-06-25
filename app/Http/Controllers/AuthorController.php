<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{
   
    public function index():JsonResponse
    {
     $author=Cache::remember("authors",3600,fn()=>Author::all());
        return apiSuccess("All Author", $author,200);
    }

   
    public function store(AuthorRequest $request):JsonResponse
    {
      $data=$request->validated();
      $author=Author::create($data);
      return apiSuccess("Author Created",$author,201);  
    }

    public function show(Author $author):JsonResponse
    {
     return apiSuccess("Author get",$author,200);
    }

    public function update(AuthorRequest $request,Author $author):JsonResponse
    {
       $data=$request->validated();
       $author->update($data);
       return apiSuccess("Author Updated",$author,200);   
    }

   
    public function destroy(Author $author):JsonResponse
    {
        $author->delete();
         return apiSuccess("Author Deleted",200);     
    }


    public function AuthorCount(){
        $author = Author::count();
        return $author;
    }
    public function HasNoBook(){
    $author=Author::has('books',"=",0)->count();
    return $author;
    }

    public function DeleteManyAuthor(Request $request): JsonResponse {
        $ids=$request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:authors,id'
        ]);  
        
        Author::whereIn('id', $ids)->delete();
        
        return apiSuccess("تم الحذف بنجاح", code: 200); 
    }
   
}
