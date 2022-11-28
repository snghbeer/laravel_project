@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update category name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="modal_update_msgList"></ul>
                    <input type="hidden" id="cat_id" class="cat_id"/>

                    <div class="form-group mb-3">
                        <label for="">New category name</label>
                        <input type="text" id="modal_category_name" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_cat">Update</button>
                </div>

            </div>
        </div>
    </div>
    <!--Section: FAQ-->
    <section>
        <ul id="update_msgList"></ul>
        <p>
            <span class="fw-bold">
                Still have any questions? Contact us to get your answer!</span>
        </p>
        <form method="POST" class="faq-contact-form" action="{{route('admin.ask')}}">
            @csrf
            @method('post')
            <div class="form-outline mb-4">
                <!-- Maybe use ajax for responsivness per category -->
                <select class="form-select cats" aria-label="Default select example" id="category" name="category">
                    <option selected>Select category</option>
                </select>
            </div>

            <!-- Message input -->
            <div class="form-outline mb-4">
                <label class="form-label">Question</label>
                <textarea class="form-control noresiz" id="question" rows="4" name="question" required></textarea>
            </div>
            @auth
            @if (Auth::user()->role === 1)
            <div class="form-outline mb-4">
                <label class="form-label">Answer</label>
                <textarea class="form-control noresiz" id="answer" rows="4" name="answer" required></textarea>
            </div>
            @endif
            @endauth

            <input type="submit" class="btn btn-dark btn-block mb-4 faq-contact-form-submit" value="Ask" />
        </form>

        <!-- ADD NEW CATEGORY -->
        @auth
        @if (Auth::user()->role === 1)
        <form method="POST" class="faq-contact-form">
            @csrf
            @method('post')
            <table class="table" id="usersTable">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Category name</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="form-outline mb-4">
                <label class="col-md-3 control-label">
                    <h6>Add category</h6>
                </label>
                <div class="col-md-8">
                    <input class="form-control" type="text" id="category_name" name="category_name" value="">
                </div>
            </div>
            <input type="submit" class="btn btn-dark btn-block mb-4 faq-contact-form-submit add_cat" value="Add" />
        </form>
        @endif
        @endauth
    </section>
    <script>
        $(document).ready(function() {
            fetchCategories();

            async function fetchCategories() {
                $.ajax({
                    type: "GET",
                    url: "{{route('admin.getCats')}}",
                    dataType: "json",
                    success: function(response) {
                        $('.cats').html("");
                        $('tbody').html("");
                        $('.cats').append("<option selected>Select category</option>")
                        $.each(response.users, function(key, item) {
                            $('.cats').append(
                                `
                                <option value="${item.id}">${item.category_name}</option>
                            `
                            );
                            $('tbody').append(
                                ` <tr scope="row">\
                            <td>  ${key + 1}  </td>\
                            <td class="title">
                              <div class="candidate-list-details">
                                <div class="candidate-list-info">
                                  <div class="candidate-list-title">
                                    <p class="mb-0">${item.category_name}</p>
                                  </div>
                                </div>
                              </div>
                            </td>\
                            <td class="text-right"><button type="button" name="${item.id}" id="${item.id}" value="${item.id}" class="btn btn-primary editBtn btn-sm">Edit</button></td>\

                            <td class="text-right"><button type="button" name="${item.id}" id="${item.id}" value="${item.id}" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
                        \</tr>`
                            );
                        });
                    },
                    error: function(response) {
                        console.log(response)
                    }
                })
            }


            $(document).on('click', '.add_cat', function(e) {
                e.preventDefault();
                $(this).text('Adding..');
                var data = {
                    'category_name': $('#category_name').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{route('admin.addCat')}}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('.add_cat').text('Add');
                        } else {
                            $('#update_msgList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.add_cat').text('Add');
                            fetchCategories();
                        }
                    }
                });
            });

            $(document).on('click', '.deletebtn', function(e) {
                e.preventDefault();
                $(this).text('Deleting..');
                var id = $(this).val();
                var url = '{{ route("admin.deleteCat", ":id") }}';
                url = url.replace(':id', id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('.add_cat').text('Delete');
                        } else {

                            $('.add_cat').text('Delete');
                            fetchCategories();
                        }
                    }
                });
            });

            $(document).on('click', '.editBtn', function(e) {
                e.preventDefault();
                $('#editModal').modal('show');
                var id = $(this).val();
                $('#cat_id').val(id);
            })

            $(document).on('click', '.update_cat', function(e) {
                var id = $('#cat_id').val();
                var url = '{{ route("admin.updateCat", ":id") }}';
                var data = {
                    category_name: $('#modal_category_name').val()
                }
                url = url.replace(':id', id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('.update_cat').text('Updating...');
                $.ajax({
                    type: "PUT",
                    url: url,
                    dataType: "json",
                    data: data,
                    success: async function(response) {
                        if (response.status == 400) {
                            $('.update_cat').text('Update');
                            $('#modal_update_msgList').html('');
                            $('#modal_update_msgList').addClass('alert alert-danger');
                            $('#modal_update_msgList').text(response.errors.category_name[0]);
                        } else {
                            await fetchCategories();
                            $('.update_cat').text('Update');
                            $('#editModal').modal('hide');
                        }
                    }
                });
            })

        })
    </script>
</div>
@endsection