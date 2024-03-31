@extends('layouts/blankLayout')

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

<!-- /Logo -->
<h4 class="mb-2">Buat Password Baru 🚀</h4>
@if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
<form id="formAuthentication" class="mb-3" action="{{route('process-changepw')}}" method="POST">
@csrf
<div class="mb-3 form-password-toggle">
  <label class="form-label" for="password">Password</label>
  <div class="input-group input-group-merge">
    <input type="password" id="password" class="form-control" name="password"
      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
      aria-describedby="password" />
    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
  </div>
  @error('password')
    <div class="text-danger">{{ $message }}</div>
  @enderror
</div>
<div class="mb-3 form-password-toggle">
  <label class="form-label" for="password">Konfirmasi Password</label>
  <div class="input-group input-group-merge">
    <input type="password" id="password" class="form-control" name="confirmpw"
      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
      aria-describedby="password" />
    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
  </div>
  @error('confirmpw')
    <div class="text-danger">{{ $message }}</div>
  @enderror
</div>

<div class="d-flex gap-2">
<a href="{{route('dashboard')}}"  class="btn btn-outline-danger d-grid w-100">
  batal 
</a>
<button type="submit" class="btn btn-primary d-grid w-100">
  Ganti Password 
</button>

</div>
</form>
</div>
</div>
<!-- Register Card -->
</div>
</div>
</div>
@endsection