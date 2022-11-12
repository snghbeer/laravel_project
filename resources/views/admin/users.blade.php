@extends('layouts.app')
@section('content')
<div class="container mt-3 mb-4">
  {{-- Edit Modal --}}
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit & Update Student Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <ul id="update_msgList"></ul>

          <input type="hidden" id="user_id" />

          <div class="form-group mb-3">
            <label for="">Username</label>
            <input type="text" id="name" required class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="text" id="email" required class="form-control">
          </div>
          <div class="form-group mb-3">
            <select class="form-select" aria-label="Default select example" id="roles" name="roles">
              <option selected>Permissions</option>
              <option value="0">User</option>
              <option value="1">Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary update_user">Update</button>
        </div>

      </div>
    </div>
  </div>

  {{-- Reply Modal --}}
  <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="replyModalLabel">Reply contact form</h5>
          <button type="button" class="btn-close close-reply" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <input type="hidden" id="user_mail"  value="{{Auth::user()->email}}"/>
        <div class="modal-body contact-form">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary replyMsg">Reply</button>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-lg-9 mt-4 mt-lg-0">
    <div class="row">
      <div class="col-md-12">
        <h3>Users</h3>
        <div class="user-dashboard-info-box table-responsive mb-0 bg-white p-4 shadow-sm">
          <table class="table manage-candidates-top mb-0" id="usersTable">
            <thead>
              <tr>
                <th></th>
                <th>Username</th>
                <th class="text-center">Mail</th>
                <th class="text-center">Role</th>
                <th class="text-center">Edit</th>
              </tr>
            </thead>
            <tbody class="users_body">

            </tbody>
          </table>
        </div>
        </br>
        </br>
          <h3>Messages</h3>
          <div class="user-dashboard-info-box table-responsive mb-0 bg-white p-4 shadow-sm">
            <table class="table manage-candidates-top mb-0" id="usersTable">
              <thead>
                <tr>
                  <th></th>
                  <th>From</th>
                  <th class="text-center">Subject</th>
                  <th class="text-center">Answered</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody class="mailBox">
              @foreach ($msg as $key => $item)
              <tr class="candidates-list">
                 <td id="reply_id"> {{$key + 1 }} </td>
                <td id="reply_from"> {{$item->author}} </td>
                <td id="reply_subject" class="text-center"> {{$item->subject}} </td>
                <td id="reply_answered" class="text-center"> {{$item->answered == 1 ? 'Yes' : 'No'}} </td>
                <td class="text-center"><button type="button" value="{{$item->id}}" class="btn btn-secondary replyBtn btn-sm">Reply</button></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      fetchUsers();

      function fetchUsers() {
        $.ajax({
          type: "GET",
          url: "/admin/users",
          dataType: "json",
          success: function(response) {
            //console.log(response);
            $('.users_body').html("");
            $.each(response.users, function(key, item) {
              $('.users_body').append(
                ` <tr class="candidates-list">\
                            <td>  ${key + 1}  </td>\
                            <td class="title">
                              <div class="candidate-list-details">
                                <div class="candidate-list-info">
                                  <div class="candidate-list-title">
                                    <h5 class="mb-0">${item.name}</h5>
                                  </div>
                                </div>
                              </div>
                            </td>\
                            <td class="candidate-list-favourite-time text-center">
                              <span class="candidate-list-time order-1">${item.email}</span>
                            </td>\
                            <td class="candidate-list-favourite-time text-center">
                              <span class="candidate-list-time order-1">
                                ${checkAdmin(item.role)}
                              </span>
                            </td>\
                            <td class="text-center"><button type="button" value=" ${item.id} " class="btn btn-secondary editbtn btn-sm">Edit</button></td>\
                        \</tr>`
              );
            });
          }
        });
      }

      function checkAdmin(role) {
        if (role === 0) return "User"
        else return "Admin"
      }

      $(document).on('click', '.update_user', function(e) {
        e.preventDefault();

        $(this).text('Updating..');
        var id = $('#user_id').val();
        // alert(id);

        var data = {
          'name': $('#name').val(),
          'email': $('#email').val(),
          'role': $('#roles').val(),
        }

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: "PUT",
          url: "/admin/update-user/" + id,
          data: data,
          dataType: "json",
          success: function(response) {
            // console.log(response);
            if (response.status == 400) {
              $('#update_msgList').html("");
              $('#update_msgList').addClass('alert alert-danger');
              $.each(response.errors, function(key, err_value) {
                $('#update_msgList').append('<li>' + err_value +
                  '</li>');
              });
              $('.update_student').text('Update');
            } else {
              $('#update_msgList').html("");

              $('#success_message').addClass('alert alert-success');
              $('#success_message').text(response.message);
              $('#editModal').find('input').val('');
              $('.update_student').text('Update');
              $('#editModal').modal('hide');
              fetchstudent();
            }
          }
        });

      });

      $(document).on('click', '.editbtn', function(e) {
        e.preventDefault();
        var userId = $(this).val();
        var url = `/admin/user/edit/${userId}`;
        //console.log(url)
        // alert(stud_id);
        $('#editModal').modal('show');
        $.ajax({
          type: "GET",
          url: url,
          success: function(response) {
            //console.log(response)
            if (response.status == 404) {
              $('#success_message').addClass('alert alert-success');
              $('#success_message').text(response.message);
              $('#editModal').modal('hide');
            } else {
              // console.log(response.student.name);
              $('#name').val(response.user.name);
              $('#email').val(response.user.email);
              $('#user_id').val(userId);
            }
          }
        });
        $('.btn-close').find('input').val('');

      });

      $(document).on('click', '.replyBtn', function(e) {
        e.preventDefault();
      //  console.log($(this).val())
        var url = '{{ route("admin.getMsg", ":id") }}';
        url = url.replace(':id', $(this).val());
        console.log($("#user_mail").val())
        $('#replyModal').modal('show');

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        $.ajax({
          type: "GET",
          url: url,
          success: function(response) {
            //console.log(response)
            if (response.status == 404) {
              $('#success_message').addClass('alert alert-success');
              $('#success_message').text(response.message);
              $('#replyModal').modal('hide');
            } else {
              var item = response.item;
              $('.contact-form').html("")
              $('.contact-form').append(`

              <input type="hidden" id="item_id"  value="${item.id}"/>
              <div class="form-group">
              <label for="disabledTextInput">From</label>
               <input class="form-control" id="from" type="text" value="${item.author}" disabled>
             </div>
             <div class="form-group">
              <label for="disabledTextInput">Subject</label>
               <input class="form-control" id="subject" type="text" value="${item.subject}" disabled>
             </div>
             <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control noresiz" id="form_content" name="form_content"  rows="3" disabled>${item.content}</textarea>
            </div>

             <div class="mb-3">
                <label class="form-label">Answer</label>
                <textarea class="form-control noresiz" id="answer" name="answer"  rows="3"></textarea>
            </div>
            `)
            }
          }
        })
        $('.close-reply').find('input').val('');
      });

      $(document).on('click', '.replyMsg', function(e) {
        e.preventDefault();
      //  console.log($(this).val())
        var url = '{{ route("admin.sendMail") }}';
        var data = {
          id: $('#item_id').val(),
          from: $('#user_mail').val(),
          to: $('#from').val(),
          subject: "RE: " +  $('#subject').val(),
          reply: $('#answer').val(),
        }

       // console.log(data)
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response) {
            $('#replyModal').modal('hide');
            //console.log(response)
          }
        })
      });

    })
  </script>
</div>
@endsection