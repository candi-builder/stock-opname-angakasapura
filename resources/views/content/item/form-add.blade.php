@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Item</h5> <small class="text-muted float-end">item</small>
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
        <form>
          <div class="mb-3">
            <label class="form-label" for="no_article">no article</label>
            <input type="text" class="form-control" name="no_article" placeholder="ACSS" value="ACSS" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="descirption">new description</label>
            <input type="text" class="form-control" name="descirption" placeholder="nama item" />
          </div>
          <div class="mb-3">
            <label  class="form-label" for="mg">Material Group</label>
            <select  class="form-control selectdua" name="mg">
            <option disabled value="-">Pilih Material Group</option>
              @foreach($mg as $item)
              <option value="{{$item->id}}">{{$item->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label  class="form-label" for="basic-default-fullname">Station</label>
            <select  class="form-control selectdua" name="station">
            <option disabled value="-">Pilih Station</option>
              @foreach($uoms as $uom)
              <option value="{{$uom->id}}">{{$uom->name}}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection