@extends('layouts.app')
@section('content')
<div class="container bootstrap snippets bootdey">
  <div id="success_message"></div>
  <h1 class="text-primary">Edit Profile</h1>
  <hr>
  <div class="row">
    <!-- left column -->
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{route('updateProfile', Auth::user()->id)}}">
      @csrf
      @method('put')
      <div class="col-md-3">
        <div class="text-center">
          @if (!is_null(Auth::user()->avatar))
          <img src="{{ Storage::url(Auth::user()->avatar) }}" class="avatar img-circle img-thumbnail" alt="avatar">
          @else
          <img src="{{ Storage::url('avatars/null.jpg') }}" class="avatar img-circle img-thumbnail" alt="avatar">
          @endif
          <h6>Upload a different photo...</h6>

          <input type="file" id="avatar" name="avatar" class="form-control">
        </div>
      </div>

      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <h3>User info</h3>
        <input type="hidden" id="user_id" value="{{Auth::user()->id}}" />
        <div class="form-group">
          <label class="col-lg-3 control-label">
            <h6>Username</h6>
          </label>
          <div class="col-lg-8">
            <input class="form-control  @error('username') is-invalid @enderror" type="text" id="username" name="username" value="{{ Auth::user()->name }}">
            @error('username')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <br />
        <input type="date" id="bday" name="bday" required pattern="\d{2}-\d{2}-\d{4}" value="{{ Auth::user()->bdate }}">
        <br />
        <div class="form-group">
          <label class="col-lg-3 control-label">
            <h6>Email</h6>
          </label>
          <div class="col-lg-8">
            <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" name="email" value="{{ Auth::user()->email }}">
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <br />
        <div class="form-group">
          <label for="exampleFormControlTextarea1">
            <h6>About me</h6>
          </label>
          <textarea class="form-control noresiz" id="about" name="about" rows="3">{{Auth::user()->aboutme}}</textarea>
        </div>
        <br />
        <button type="submit" class="btn btn-primary update_profile">Save</button>
      </div>
    </form>
  </div>
  <script>
  </script>
</div>
<hr>
@endsection