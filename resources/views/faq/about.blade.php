@extends('layouts.app')
@section('content')

<main>
  <div class="container py-4">

    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5 h-100  border rounded-3">
        <h1 class="display-5 fw-bold">About</h1>
        <p class="col-md-8 fs-4">This project was made using Laravel. Below you can see all sources I've searched through to make this.</p>
        <a target="_blank" href="https://github.com/snghbeer/laravel_project">Github repository</a>
      </div>
    </div>
    <div class="row align-items-md-stretch">
      <div class="col-md">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h2>Used composer packages</h2>
          <li class="list-group-item active"> <a target="_blank" href="https://packagist.org/packages/laravel/ui">Laravel/UI</a></li>
          <p>Used for integrating a simple authentication system.</p>
        </div>
      </div>
  </div>
  <div class="pt-3 mt-4 text-muted border-top"></div>

    <div class="row align-items-md-stretch">
      <div class="col-md-6">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h2>JQUERY/Ajax</h2>
          <li class="list-group-item active"> <a target="_blank" href="https://www.w3schools.com/jquery/event_click.asp">onClick events</a></li>
          <li class="list-group-item active"> <a target="_blank"href="https://stackoverflow.com/questions/9269265/ajax-jquery-simple-get-request">Http requests</a></li>
          <li class="list-group-item active"> <a target="_blank"href="https://api.jquery.com/append/">Jquery append</a></li>

        </div>
      </div>
      <div class="col-md-6">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h2>Laravel</h2>
          <li class="list-group-item active"> <a target="_blank" href="https://www.youtube.com/watch?v=iGkMzbAm8mg">Upload files</a></li>
          <li class="list-group-item active"> <a target="_blank" href="https://www.youtube.com/watch?v=-9tUWhNmQz4">Admin role</a></li>
          <li class="list-group-item active"> <a target="_blank" href="https://laravel.com/docs/9.x/middleware">Middleware A</a></li>
          <li class="list-group-item active"> <a target="_blank" href="https://www.youtube.com/watch?v=-9tUWhNmQz4">Middleware B</a></li>
          <li class="list-group-item active"> <a target="_blank" href="https://laravel.com/docs/9.x/">Laravel</a></li>
        </div>
      </div>
    </div>
    <div class="pt-3 mt-4 text-muted border-top"></div>
    <div class="row align-items-md-stretch">
      <div class="col-md-6">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h2>Layout/Templates</h2>
          <li class="list-group-item active"> <a target="_blank" href="https://startbootstrap.com/themes">Dashboard/sidebar</a></li>
          <li class="list-group-item active"> <a target="_blank" href="https://bbbootstrap.com/snippets/bootstrap-5-user-social-profile-transition-effect-79746232">Profile</a></li>
          <li class="list-group-item active"> <a target="_blank" href="https://fontawesome.com/icons">Sidebar icons</a></li>

        </div>
      </div>
      <div class="col-md-6">
      <div class="h-100 p-5 text-white bg-dark rounded-3">
        <h2>Laravel Mail</h2>
        <li class="list-group-item active"> <a target="_blank" href="https://serversmtp.com/smtp-hotmail/">Hotmail SMTP config</a></li>
        <li class="list-group-item active"> <a target="_blank" href="https://www.youtube.com/watch?v=xigpoxOW1MY">Configure laravel to send mails</a></li>
      </div>
    </div>
  </div>
  <div class="pt-3 mt-4 text-muted border-top"></div>

  <div class="row align-items-md-stretch">
    <div class="col-md-6">
      <div class="h-100 p-5 text-white bg-dark rounded-3">
        <h2>Who am I?</h2>
        <p>I am a BA2 student in toegepaste informatica studying at the Erasmus Hogeschool of Brussels</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="h-100 p-5 text-white bg-dark rounded-3 ">
        <h2>Any specific questions?</h2>
        <p> Don't hesitate to contact the team through our contact form, we will happily answer your questions! Questions can take up to 48 hours to be answered, you will get an email once it is answered.</p>
        <a class="btn btn-outline-secondary" href="{{route('contactView')}}">Contact us</a>
      </div>
    </div>
  </div>

  </div>
</main>

@endsection