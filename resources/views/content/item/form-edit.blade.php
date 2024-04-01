@extends('layouts/contentNavbarLayout')

@section('title', ' Tambah Item')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Master Data/</span> Item</h4>

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
        <form action="{{route('process-edit-item')}}" method="POST" >
        @csrf
          <div class="mb-3">
            <label class="form-label" for="no_article">no article</label>
            <input type="text" class="form-control" name="no_article" placeholder="ACSS" value="{{$dataItem->no_article}}" />
            @error('no_article')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="description">new description</label>
            <input type="text" class="form-control" name="description" placeholder="nama item" value="{{$dataItem->description}}" />
            @error('description')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <div class="mb-3">
            <label  class="form-label" for="mg">Material Group</label>
            <select  class="form-control selectdua" name="mg">
            <option disabled value="{{$dataItem->mg_id }}">{{$dataItem->mgname}}</option>
              @foreach($mg as $item)
              <option value="{{$item->id}}">{{$item->name}}</option>
              @endforeach
            </select>
            @error('mg')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <div class="mb-3">
            <label  class="form-label" for="basic-default-fullname">Station</label>
            <select  class="form-control selectdua" name="uom">
            <option disabled value="{{$dataItem->uoms_id }}">{{$dataItem->uom_name}}</option>
              @foreach($uoms as $uom)
              <option value="{{$uom->id}}">{{$uom->name}}</option>
              @endforeach
            </select>
            @error('uom')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <a href="{{route('get-list-item')}}" class="btn btn-outline-primary">Batal</a>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection