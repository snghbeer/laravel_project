@extends('layouts.app')
@section('content')
<div class="container py-5">
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
                <textarea class="form-control" id="question" rows="4" name="question" required></textarea>
            </div>
            @auth
            @if (Auth::user()->role === 1)
            <div class="form-outline mb-4">
                <label class="form-label">Answer</label>
                <textarea class="form-control" id="answer" rows="4" name="answer" required></textarea>
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

            function fetchCategories() {
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
                    error: function(response){
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
           
        })
    </script>
</div>
@endsection