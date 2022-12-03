@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="alert_container">
    </div>
    <div class="card">
        <img src="{{Storage::url($item->cover)}}" class="card-img-top" alt="Responsive image">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <h4 class="fw-bold mb-4">{{$item->title}}</h4>
                </div>
                @auth
                @if (Auth::user()->role === 1)
                <div class="btn-group p-2 bd-highlight">
                    <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    </button>
                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="{{ route('editNewsView', $item->id)}}">Edit</a></li>
                        <form method="POST" action="{{ route('deleteItem', $item->id)}}">
                            @method('delete')
                            @csrf
                            <li><button class="dropdown-item" type="submit">Delete</button></li>
                        </form>
                    </ul>
                </div>
                @endif
                @endauth
            </div>
            <p class="mb-0">{{$item->content}}</p>
            <p>
                <a class="comments" id="comments" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Show comments
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div id="comments_container" class="d-grid gap-1">
                </div>
                <br />
                @auth
                <form>
                    <input type="hidden" id="author" name="author" value="{{Auth::user()->name}}" />
                    <input type="hidden" id="news_id" name="news_id" value="{{$item->id}}" />

                    <div class="form-group">
                        <textarea class="form-control noresiz" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary sendComment">Send</button>
                </form>
                @endif
                @guest
                <p>Sign in if you want to comment & see comments</p>
                @endguest
            </div>
            <div class="d-flex justify-content-between bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> {{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y h:i')}}</p>
                </div>
                <div class="p-2 bd-highlight">
                    <b><i>By {{$item->author}}</i></b>
                </div>
            </div>
        </div>
    </div>
    <script>
        getComments()

        function getComments() {
            var url = '{{ route("getComments", ":id") }}';
            url = url.replace(':id', $('#news_id').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    //console.log(response.comments)
                    $.each(response.comments, function(key, item) {
                        $('#comments_container').append(`
                        <div class="card card-body p-2 ">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary fw-bold mb-0">
                                    ${item.author}
                                    <span class="text-dark ms-2"> ${item.content}</span>
                                </h6>
                            </div>
                        </div>
                        `)
                    })
                }
            });
        }


        $(document).on('click', '.comments', function(e) {
            var collapse = $(this).attr('aria-expanded');
            if (collapse == "false") {
                $(this).text('Show comments');
            } else {
                $(this).text('Hide comments');
            }
            //console.log(typeof collapse)
        });

        $(document).on('click', '.sendComment', function(e) {
            e.preventDefault()
            var data = {
                author: $('#author').val(),
                comment: $('#comment').val(),
                news_id: $('#news_id').val()
            }
            //console.log(data)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{route('addComment')}}",
                data: data,
                dataType: "json",
                success: function(response) {
                    $('.alert_container').html("");
                    $('#comments_container').append(`
                            <div class="card card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary fw-bold mb-0">
                                    ${response.comment.author}
                                    <span class="text-dark ms-2"> ${response.comment.content}</span>
                                </h6>
                            </div>

                            </div>`)
                    $('#comment').val("")
                },
                error: function(response) {
                    $('.alert_container').html("");
                    $('.alert_container').append(`
                            <div class="alert alert-danger" id="succes_alert" role="alert">
                            ${response.message}
                            </div>`)
                }
            })
        });
    </script>
</div>
@endsection