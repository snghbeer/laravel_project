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
                    <option selected >Permissions</option>
                    <option  value="0">User</option> 
                    <option  value="1">Admin</option>
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
    <div class="col-lg-9 mt-4 mt-lg-0">
        <div class="row">
          <div class="col-md-12">
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
                <tbody>

                </tbody>
              </table>
              <!--
              <div class="text-center mt-3 mt-sm-3">
                <ul class="pagination justify-content-center mb-0">
                  <li class="page-item disabled"> <span class="page-link">Prev</span> </li>
                  <li class="page-item active" aria-current="page"><span class="page-link">1 </span> <span class="sr-only">(current)</span></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">...</a></li>
                  <li class="page-item"><a class="page-link" href="#">25</a></li>
                  <li class="page-item"> <a class="page-link" href="#">Next</a> </li>
                </ul>
              </div> -->
            </div>
          </div>
        </div>
      </div>
      <script>
          $(document).ready(function(){
            fetchstudent();

            function fetchstudent() {
            $.ajax({
                type: "GET",
                url: "/admin/users",
                dataType: "json",
                success: function (response) {
                     //console.log(response);
                    $('tbody').html("");
                    $.each(response.users, function (key, item) {
                        $('tbody').append(
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
                            <td class="text-right"><button type="button" value=" ${item.id} " class="btn btn-primary editbtn btn-sm">Edit</button></td>\
                        \</tr>`
                        );
                    });
                }
            });
        }

        function checkAdmin(role){
          if (role === 0) return "User"
          else return "Admin"
        }

        $(document).on('click', '.update_user', function (e) {
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
                success: function (response) {
                    // console.log(response);
                    if (response.status == 400) {
                        $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
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

        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var userId = $(this).val();
            var url = `/admin/user/edit/${userId}`;
            //console.log(url)
            // alert(stud_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
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
    
          })
      </script>
</div>
@endsection