@extends('layouts.app')
@section('content')
<div class="container py-3">
    <div class="alert_container">
    </div>
<form>
    @csrf
    @method('post')
    <div class="mb-3">
        <label class="form-label">Your Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
    </div>
    <div class="mb-3">
        <label class="form-label">Subject</label>
        <input class="form-control" type="text" id="subject" name="subject" value="">
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea class="form-control noresiz" id="content" name="content"  rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-secondary sendComment">Send</button>

</form>
<script>
         $(document).on('click', '.sendComment', function(e) {
            e.preventDefault()
            var data = {
                email: $('#email').val(),
                subject: $('#subject').val(),
                content: $('#content').val()
            }
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            $.ajax({
                    type: "POST",
                    url: "{{route('sendContactForm')}}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.alert_container').html("");
                        $('tbody').html("");
                        $('.alert_container').append(`
                            <div class="alert alert-success" id="succes_alert" role="alert">
                            ${response.message}
                            </div>`)
                    },
                    error: function(response){
                        $('.alert_container').html("");
                        $('tbody').html("");
                        $('.alert_container').append(`
                            <div class="alert alert-danger" id="succes_alert" role="alert">
                            ${response.message}
                            </div>`)
                    }
                })
            console.log(data)
         });
    </script>
</div>
@endsection