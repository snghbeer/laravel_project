@extends('layouts.app')
@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Latest news</h1>

  @auth
  @if (Auth::user()->role === 1)
  <div class="py-3">
    <a class="btn btn-dark" href="{{ route('admin.addNews')}}">Add news</a>
  </div>
  @endif
  @endauth
  <section style="background-color: #F0F2F5;">
    <div class="container py-5">
      @foreach ($news as $key => $item)
      <div class="main-timeline-2">
        <div class="timeline-2 {{ $key%2 == 0 ? 'left-2' : 'right-2'}}">
          <div class="card">
            <a href="{{route('detailedNews', $item->id)}}">
            <img src="{{Storage::url($item->cover)}}" class="card-img-top" alt="Responsive image">
            </a>
            <div class="card-body p-4">
              <div class="d-flex justify-content-between bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                  <a href="{{route('detailedNews', $item->id)}}">
                  <h4 class="fw-bold mb-4">{{$item->title}}</h4>
                  </a>
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
        </div>
        @endforeach

      </div>
    </div>
  </section>
</div>
@endsection