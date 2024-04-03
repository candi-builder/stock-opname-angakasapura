@extends('layouts/contentNavbarLayout')

@section('title', ' Tambah Item')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Station/</span> Item</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Item</h5> <small class="text-muted float-end">item</small>
      </div>

      <div class="card-body">
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
        <form action="{{route('process-edit-station')}}" method="POST" >
            <input type="hidden" class="form-control" name="id" value="{{$station->id}}" />
            @csrf
          <div class="mb-3">
            <label class="form-label" for="name">name station</label>
            <input type="text" class="form-control" name="name"  placeholder="name station" value="{{$station->name}}" />
            @error('name')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <a href="{{route('get-list-station')}}" class="btn btn-outline-primary">Batal</a>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection