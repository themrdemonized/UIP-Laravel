<?php

/*
 *  Удалить этот контроллер, нигде не используется???
 */

namespace App\Http\Controllers;

use App\DocCategory;
use App\Document;
use Illuminate\Http\Request;
use Validator;

class DocCategoryController extends Controller
{
    public function getDocCategories(){
        $categories = DocCategory::get();

        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function edit(){
        $category = DocCategory::find(request()->categoryId);

        return response()->json([
            'category' => $category
        ], 200);
    }

    public function update(Request $request){
        if ($request->has('categoryId')){
            $v = Validator::make($request->all(), [
                'categoryName' => 'required',
            ]);

            if ($v->fails()) {
                return response()->json([
                    'errors' => $v->errors()
                ], 422);
            }

            $category = DocCategory::find($request->categoryId);

            $category->update([
                'name' => $request->categoryName,
            ]);

            return response()->json([
                'categories' => DocCategory::all(),
                'msg' => 'Данные категории были успешно обновлены!'
            ], 200);
        }
        else{
            return response()->json([
                'msg' => 'Что то пошло не так =('
            ], 422);
        }
    }

    public function create(Request $request){
        $v = Validator::make($request->all(), [
            'categoryName' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors()
            ], 422);
        }

        DocCategory::create([
            'name' => $request->categoryName,
        ]);

        return response()->json([
            'categories' => DocCategory::all(),
            'msg' => 'Категория была успешно добавлена!'
        ], 200);
    }

    public function delete(){
        if (request()->has('categoryId')){
            $category = DocCategory::find(request()->categoryId);

            $category->delete();

            return response()->json([
                'categories' => DocCategory::all(),
                'msg' => 'Выбранная категория был удалена!'
            ], 200);
        }
        else{
            return response()->json([
                'msg' => 'Что то пошло не так =('
            ], 422);
        }
    }

    public function index(){
        $categories = DocCategory::with('docs')->get();
//        $category = DocCategory::with('docs')->where('id', request()->categoryId)->first()->with('file')->get();
        $docs = Document::with('file')->where('category_id', \request()->categoryId)->get();
//        $docs = $category->docs->with('file')->get();

//        dd($docs);

        return response()->json([
            'categories' => $categories,
            'docs' => $docs
        ], 200);
    }
}
