@extends('layouts.app')
@section('content')
<div class="container py-5">
    @auth
    @if (Auth::user()->role === 1)
    <div class="py-3">
        <a class="btn btn-dark" href="{{route('admin.faqForm')}}">Admin</a>
    </div>
    @endif
    @endauth
    <ul class="nav nav-tabs categories" id="categories">
        @foreach ($cats as $key => $cat)
        <li class="nav-item {{ $key == 0 ? 'show' : ''}}" id="{{$cat->id}}">
            <a class="nav-link" href="#">{{$cat->category_name}} </a>
        </li>
        @endforeach
    </ul>
    <div class="questions">
    </div>
    <script>
        getQuestions()

        function getQuestions() {
            var url = '{{ route("getCatQ", ":id") }}';
            url = url.replace(':id', 1);
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
                    //console.log(response.questions)
                    $.each(response.questions, function(key, item) {
                        var editUrl = '{{ route("editFaqView", ":id") }}'
                        editUrl = editUrl.replace(':id', item.id);
                        var deleteUrl = '{{route("admin.deleteQst", ":id")}}'
                        deleteUrl = deleteUrl.replace(':id', item.id);

                        $('.questions').append(`
                                <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-heading_${key}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse_${key}" aria-expanded="${key == 0 ? 'true' : 'false'} aria-controls="panelsStayOpen-collapse_${key}">
                                               ${item.question}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapse_${key}" class="accordion-collapse collapse ${key == 0 ? 'show' : ''}" >
                                            <div class="accordion-body">
                                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                                <div class="p-2 bd-highlight">
                                                <p class="text-muted mb-4">${item.answer}</p>
                                                </div>
                                                @auth
                                                @if (Auth::user()->role === 1)
                                                <div class="p-2 bd-highlight">
                                                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li> <a class="dropdown-item" href= "${editUrl}" >Edit</a></li>
                                                    <form method="POST" action="${deleteUrl}">
                                                    @method('delete')
                                                    @csrf
                                                    <li><button class="dropdown-item" type="submit">Delete</button></li>
                                                    </form>
                                                </ul>
                                                </div>
                                                @endif
                                                @endauth
                                            </div>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </div>
                                `)
                    })
                }
            });
        }

        $(document).on('click', '.nav-item', function(e) {
            var navItems = document.querySelectorAll("#categories")[0];
            for (var i = 0; i < navItems.children.length; i++) {
                var item = navItems.children[i];
                item.classList.remove('show')
            };
            this.classList.add("show");
            //console.log(this.id)

            var url = '{{ route("getCatQ", ":id") }}';
            url = url.replace(':id', this.id);
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
                    //console.log(response.questions)
                    $('.questions').html("");
                    $.each(response.questions, function(key, item) {
                        var editUrl = '{{ route("editFaqView", ":id") }}'
                        editUrl = editUrl.replace(':id', item.id);
                        var deleteUrl = '{{route("admin.deleteQst", ":id")}}'
                        deleteUrl = deleteUrl.replace(':id', item.id);
                        $('.questions').append(`
                                <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-heading_${key}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse_${key}" aria-expanded="${key == 0 ? 'true' : 'false'} aria-controls="panelsStayOpen-collapse_${key}">
                                               ${item.question}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapse_${key}" class="accordion-collapse collapse ${key == 0 ? 'show' : ''}" >
                                            <div class="accordion-body">
                                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                                <div class="p-2 bd-highlight">
                                                <p class="text-muted mb-4">${item.answer}</p>
                                                </div>
                                                @auth
                                                @if (Auth::user()->role === 1)
                                                <div class="p-2 bd-highlight">
                                                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li> <a class="dropdown-item" href="${editUrl}">Edit</a></li>
                                                    <form method="POST" action="${deleteUrl}">
                                                    @method('delete')
                                                    @csrf
                                                    <li><button class="dropdown-item" type="submit">Delete</button></li>
                                                    </form>
                                                </ul>
                                                </div>
                                                @endif
                                                @endauth
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `)
                    })
                }
            });
        });
    </script>
</div>
@endsection