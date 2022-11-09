@extends('layouts.app')
@section('content')
<div class="container py-5">
    <!--Section: FAQ-->
    <section>
        <h3>Update question</h3>
    <ul id="update_msgList"></ul>
        <form method="POST" class="faq-contact-form" action="{{route('updateQuestion', $item->id)}}">
            @csrf
            @method('put')
            <input type="hidden" id="item_id" name="item_id" value="{{$item->id}}" />
            <div class="form-outline mb-4">
                <!-- Maybe use ajax for responsivness per category -->
                <select class="form-select cats" aria-label="Default select example" id="category" name="category">
                    <option selected>Update category</option>
                </select>
            </div>

            <!-- Message input -->
            <div class="form-outline mb-4">
                <label class="form-label">Question</label>
                <textarea class="form-control" id="question" rows="4" name="question" required>{{$item->question}}</textarea>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label">Answer</label>
                <textarea class="form-control" id="answer" rows="4" name="answer" required>{{$item->answer}}</textarea>
            </div>
            <input type="submit" class="btn btn-dark btn-block mb-4 faq-contact-form-submit" value="Update" />
        </form>
    </section>
    <script>
         fetchCategories()
        function fetchCategories() {
                $.ajax({
                    type: "GET",
                    url: "{{route('admin.getCats')}}",
                    dataType: "json",
                    success: function(response) {
                        $('.cats').html("");
                        $('tbody').html("");
                        $('.cats').append("<option >Update category</option>")
                        $.each(response.users, function(key, item) {
                            //console.log((item.id + " and " + '{{$item->category_id}}'))
                            if(item.id == '{{$item->category_id}}'){
                                $('.cats').append(`
                                <option selected value="${item.id}">${item.category_name}</option>
                            `);
                            } else{
                                $('.cats').append(`
                                <option value="${item.id}">${item.category_name}</option>
                            `);
                            }

                        });
                    },
                    error: function(response){
                        console.log(response)
                    }
                })
            }
    </script>
</div>
@endsection