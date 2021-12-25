<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user', 'category','tags')->orderByDesc('created_at')->paginate(20);
        return view('backEnd.pages.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCategories = Category::all();
        $allTags = Tag::all();
        return view('backEnd.pages.post.create', compact('allTags', 'allCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'title' => 'required | max:255 | unique:posts,title',
                'image' => 'required | image',
                'category_id' => 'required',
                'description' => 'required',
            ],
            [
                'title.required' => "Please enter post name",
                'title.unique' => "Title name must be unique"
            ]
        );

        DB::beginTransaction();
        try {
            $post =  Post::create([
                'title' => $request->title,
                'slug' =>  Str::of($request->title)->slug('-'),
                'description' => $request->description,
                'image' => 'dummy.png',
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
                'published_at' => Carbon::now(),
            ]);

            if ($request->file('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->storeAs('images', $imageName, 'public');
                $post->image = $imageName;
                $post->save();

                $post->tags()->attach($request->tags);
                // dd($imageName);
            }
            // dd('dont have');

        } catch (\Throwable $th) {
            // dd('error');
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
        DB::commit();
        return redirect()->route('post.index')->with(['success' => 'Post created ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('tags','category','user');
        // dd($post);
        return view('backEnd.pages.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $allCategories = Category::all();
        $allTags = Tag::all();
        return view('backEnd.pages.post.edit', compact('post', 'allCategories','allTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // dd($request->all());
        $request->validate(
            [
                'title' => 'required | max:255 | unique:posts,title,' . $post->id,
                'category_id' => 'required',
                'description' => 'required',
            ],
            [
                'title.required' => "Please enter post name",
                'title.unique' => "Title name must be unique"
            ]
        );

        DB::beginTransaction();
        try {

            if ($request->file('image')) {
                if (Storage::disk('public')->exists('/images/' . $post->image)) {

                    Storage::disk("public")->delete('/images/' . $post->image);
                }

                $imageName = time() . '.' . $request->image->extension();
                $request->image->storeAs('images', $imageName, 'public');
                $post->image = $imageName;
            }
            $post->title = $request->title;
            $post->slug = Str::of($request->title)->slug('-');
            $post->description = $request->description;
            $post->image = $post->image;
            $post->category_id = $request->category_id;
            $post->save();

            $post->tags()->sync($request->tags);
        } catch (\Throwable $th) {
            // dd('error');
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
        DB::commit();
        return redirect()->route('post.index')->with(['success' => 'Post updated ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();

        try {

            if (Storage::disk('public')->exists('/images/' . $post->image)) {
                Storage::disk("public")->delete('/images/' . $post->image);
            }

            $post->delete();

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }

        DB::commit();
        return redirect()->route('post.index')->with(['success' => 'Post deleted ']);

    }
}
