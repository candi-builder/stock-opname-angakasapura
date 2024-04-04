@extends('layouts/contentNavbarLayout')

@section('title', ' Tambah Item')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Material Group/</span> Item</h4>

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
        <form action="{{route('process-edit-material-group')}}" method="POST" >
            <input type="hidden" class="form-control" name="id" value="{{$materialGroup->id}}" />
            @csrf
          <div class="mb-3">
            <label class="form-label" for="name">Nama Material Group</label>
            <input type="text" class="form-control" name="name"  placeholder="Nama Material Group" value="{{$materialGroup->name}}" />
            @error('name')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <a href="{{route('get-list-material-group')}}" class="btn btn-outline-primary">Batal</a>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection