@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah User - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}"> 
@endsection
@section('content') <div
  class="container-xxl"> <div class="authentication-wrapper authentication-basic container-p-y"> <div
  class="authentication-inner"> <!-- Register
  Card -->
  <div class="card">
  <div class="card-body">
  <!-- Logo -->
  <div class="app-brand justify-content-center">
  <a href="{{url('/')}}" class="app-brand-link gap-2">
  <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
  <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span>
  </a>
</div>
<!-- /Logo -->
<h4 class="mb-2">Tambah User Baru 🚀</h4>

<form id="formAuthentication" class="mb-3" action="{{url('/')}}" method="GET">
<div class="mb-3">
  <label  class="form-label" for="basic-default-fullname">Station</label>
  <select  class="form-control selectdua" name="jnsTagihan">
  <option disabled value="-">Pilih Station</option>
    @foreach($stations as $station)
    <option value="{{$station->id}}">{{$station->name}}</option>
    @endforeach
  </select>
</div>
<div class="mb-3">
  <label class="form-label" for="basic-default-fullname">Region</label>
  <select  class="form-control selectdua" name="jnsTagihan">
  <option disabled value="-">Pilih Region</option>
    @foreach($regions as $region)
    <option value="{{$region->id}}">{{$region->name}}</option>
    @endforeach
  </select>
</div>
<div class="mb-3">
  <label for="username" class="form-label">Username</label>
  <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus>
</div>
<div class="mb-3 form-password-toggle">
  <label class="form-label" for="password">Password</label>
  <div class="input-group input-group-merge">
    <input type="password" id="password" class="form-control" name="password"
      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
      aria-describedby="password" />
    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
  </div>
</div>

<button class="btn btn-primary d-grid w-100">
  Sign up
</button>
</form>
</div>
</div>
<!-- Register Card -->
</div>
</div>
</div>
@endsection