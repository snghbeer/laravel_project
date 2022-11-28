@extends('layouts.app')
@section('content')
<div class="container bootstrap snippets bootdey">
    <!-- left column -->
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{route('admin.news.post')}}">
        @csrf
        @method('post')
        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            <h3>Add news</h3>
            <input type="hidden" id="author" name="author" value="{{Auth::user()->name}}" />
            <div class="form-group">
                <label class="col-lg-3 control-label">
                    <h6>Title</h6>
                </label>
                <div class="col-lg-8">
                    <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" value="">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <br />
            <div class="col-md-3">
                <h6>Upload a cover image</h6>
                <input type="file" id="cover" name="cover" class="form-control @error('cover') is-invalid @enderror">
                @error('cover')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
            <br />
            <div class="form-group">
                <label for="exampleFormControlTextarea1">
                    <h6>Content</h6>
                </label>
                <textarea class="form-control @error('content') is-invalid @enderror noresiz" id="content" name="content" rows="3"></textarea>
                @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
            <br />
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
</div>
@endsection