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
            <input class="form-control" type="text" id="username" name="username" value="{{ Auth::user()->name }}">
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
            <input class="form-control" type="text" id="email" name="email" value="{{ Auth::user()->email }}">
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
    /*        $(document).on('click', '.update_profile', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
            var id = $('#user_id').val();

            var data = {
                'avatar': $('#avatar').val(),
                'name': $('#username').val(),
                'email': $('#email').val(),
                'bdate': $('#bday').val(),
                'about': $('#about').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "{{route('updateProfile', Auth::user()->id)}}",
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 400) {
                        $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_msgList').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_profile').text('Updating...');
                    } else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_profile').text('Update');
                    }
                }
            });

        }); */
  </script>
</div>
<hr>
@endsection