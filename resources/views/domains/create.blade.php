@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-fluid bg-dark">
  <div class="container-lg">
    <div class="row">
      <div class="col-12 col-md-10 col-lg-8 mx-auto text-white">
        <h1 class="display-3">Page Analyzer</h1>
        <p class="lead">Check web pages for free</p>
        {{ Form::open([
          'route' => 'domains.index',
          'class' => 'd-flex justify-content-center'])
        }}
          {{ Form::text('domain[name]', $value = null, $attributes = [
            'class' => 'form-control form-control-lg',
            'palceholder' => 'https://www.example.com'])
          }}
          {{ Form::submit('Check', $attributes = ['class' => 'btn btn-lg btn-primary ml-3 px-5 text-uppercase']) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
@endsection