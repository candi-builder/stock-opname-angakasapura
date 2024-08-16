@extends('layouts/contentNavbarLayout')

@section('title', ' Tambah Batasan Stock Item')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Batasan Stock/</span> Item</h4>

<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Batas Stock Item</h5>
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
        <form action="{{route('process-add-batasan-stock-station')}}" method="POST" >
        @csrf
        <div class="mb-3">
          <label  class="form-label" for="basic-default-fullname">User berdasarkan Station</label>
          <select  class="form-control selectdua" name="station">
          <option disabled value="-">Station</option>
            {{-- @foreach($station as $item)
            <option value="{{$item->id}}">{{$item->no_article}} - {{$item->description}}</option>
            @endforeach --}}
          </select>
          {{-- @error('uom')
            <div class="text-danger">{{ $message }}</div>
          @enderror --}}
        </div>
        <div class="mb-3">
          <label  class="form-label" for="basic-default-fullname">Item</label>
          <select  class="form-control selectdua" name="item">
          <option disabled value="-">Item</option>
            {{-- @foreach($md as $item)
            <option value="{{$item->id}}">{{$item->no_article}} - {{$item->description}}</option>
            @endforeach --}}
          </select>
          {{-- @error('uom')
            <div class="text-danger">{{ $message }}</div>
          @enderror --}}
        </div>
        <div class="mb-3">
          <label  class="form-label" for="basic-default-fullname">Batasan Stock</label>
          <input type="text" placeholder="Batasan Stock" class="form-control" name="batasan_stock">
          {{-- @error('uom')
            <div class="text-danger">{{ $message }}</div>
          @enderror --}}
        </div>
          <a href="{{route('list-batasan-stock-station')}}" class="btn btn-outline-primary">Batal</a>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection
