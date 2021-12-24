<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderByDesc('created_at')->paginate(20);
        return view('backEnd.pages.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.pages.tag.create');
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
                'name' => 'required | max:255 | unique:tags,name'
            ],
            [
                'name.required' => "Please enter tag name",
                'name.unique' => "Tag name must be unique"
            ]
        );

        DB::beginTransaction();
        try {
            $tag =  Tag::create([
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
        return redirect()->route('tag.index')->with(['success' => 'Tag created ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('backEnd.pages.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        DB::beginTransaction();
        try {
            $tag->delete();
        } catch (\Throwable $th) {
            // dd('error');
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
        DB::commit();
        return redirect()->route('tag.index')->with(['success' => 'Tag deleted ']);
    }
}
