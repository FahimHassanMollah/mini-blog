<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderByDesc('created_at')->paginate(20);
        return view('backEnd.pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required | max:255 | unique:categories,name'
            ],
            [
                'name.required' => "Please enter category name",
                'name.unique' => "Category name must be unique"
            ]
        );

        DB::beginTransaction();
        try {
            $category =  Category::create([
                'name' => $request->name,
                'slug' =>  Str::of($request->name)->slug('-'),
                'description' => $request->description
            ]);
        } catch (\Throwable $th) {
            // dd('error');
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
        DB::commit();
        return redirect()->route('category.index')->with(['success' => 'Category created ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('backEnd.pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        // dd($request->all());

        $request->validate(
            [
                'name' => "required | max:255 | unique:categories,name,". $category->id
            ],
            [
                'name.required' => "Please enter category name",
                'name.unique' => "Category name must be unique"
            ]
        );

        DB::beginTransaction();
        try {
            $category->name = $request->name;
            $category->slug = Str::of($request->name)->slug('-');
            $category->description = $request->description;
            $category->save();
        } catch (\Throwable $th) {
            // dd('error');
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
        DB::commit();
        return redirect()->route('category.index')->with(['success' => 'Category updated ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
           $category->delete();
        } catch (\Throwable $th) {
            // dd('error');
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
        DB::commit();
        return redirect()->route('category.index')->with(['success' => 'Category deleted ']);

    }
}
