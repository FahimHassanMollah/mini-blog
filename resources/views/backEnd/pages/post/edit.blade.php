@extends('layouts.backEnd')
@section('backendContent')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Post Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('frontEnd.home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('post.index') }}">Post list</a> </li>
                        <li class="breadcrumb-item active">Edit post </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-8 mx-auto">
                    <div class="card ">
                        @if (session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('post.update', ['post' => $post->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Post Tite</label>
                                    <input type="text" name="title" class="form-control" id="exampleInputEmail1"
                                        placeholder="Enter post title" value="{{ $post->title }}">
                                    <div>
                                        @error('title')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Post Category</label>
                                    <select class="form-control" name="category_id" id="">
                                        <option>Select </option>
                                        @foreach ($allCategories as $category)
                                            <option {{ $category->id === $post->category_id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('category_id')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Post Tags</label>
                                    @foreach ($allTags as $tag)
                                        <div class="form-group form-check">
                                            <input @foreach ($post->tags as $prevTag) {{ $prevTag->id === $tag->id ? 'checked' : '' }}   @endforeach type="checkbox"  name="tags[]" class="form-check-input"  id="tag{{ $tag->id }}"
                                                    value="{{ $tag->id }}">
                                            <label class="form-check-label" for="tag{{ $tag->id }}"> {{ $tag->name }} </label>
                                        </div>
                                    @endforeach
                                   
                                    {{-- <div>
                                        @error('category_id')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                </div>
                                <div class="form-group d-flex ">
                                    <div>
                                        <label for="postImage">Post Image</label>
                                        <input oninput="newImage.src=window.URL.createObjectURL(this.files[0])" type="file"
                                            name="image" class="form-control" id="postImage">
                                    </div>
                                    <div class="ml-2">
                                        <img id="newImage" src="{{ asset('storage/images/' . $post->image) }}"
                                            style="height: 100px" alt="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="postDescription">Description</label>
                                    <textarea name="description" class="form-control" id="postDescription"
                                        placeholder="Enter description" rows="10">{{ $post->description }}</textarea>

                                    <div>
                                        @error('description')
                                            <div class="alert-default-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
