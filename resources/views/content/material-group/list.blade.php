@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Material Group /</span> Item
</h4>

<!-- Basic Bootstrap Table -->
@if(session('userSession')->role == 'superadmin')
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Tambah Data Material Group</h5> <small class="text-muted float-end">item</small>
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
    <form action="{{route('process-add-material-group')}}" method="POST" >
    @csrf
      <div class="mb-3">
        <label class="form-label" for="name">Nama Material Group</label>
        <input type="text" class="form-control" name="name" placeholder="Nama Material Group" value="" />
        @error('name')
        <div class="text-danger">{{ $message }}</div>
@enderror
      </div>
      {{-- <a href="{{route('get-list-material-group')}}" class="btn btn-outline-primary">Batal</a> --}}
      <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
  </div>
</div>
@endif

<!-- Responsive Table -->
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5 class="">item</h5>
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
                    {{-- Search --}}
  <form action="{{route('get-list-material-group')}}" method="GET" >
  @csrf
    <div class="input-group">
      <input type="text" class="form-control" name="cari" placeholder="Cari disini" value="" />
      <button type="submit" class="btn btn-primary">
        Cari
      </button>
    </div>
  </form>
{{-- end search --}}
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>No</th>
          <th>name</th>
          @if(session('userSession')->role == 'superadmin')
          <th>aksi</th>
          @endif
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($searchMaterialGroup as $item)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $item->name}}</td>
          @if(session('userSession')->role == 'superadmin')
          <td class="d-flex gap-2">
          <a href="{{ route('edit-material-group', $item->id) }}">
              <button type="submit" class="btn btn-success">Ubah</button>
          </a>
          <form method="POST" action="{{ route('delete-material-group', $item->id) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger">Hapus</button>
          </form>
          </td>
          @endif
        </tr>
        @endforeach
    
      </tbody>
    </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
    {{ $searchMaterialGroup->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  </div>

</div>
<!--/ Responsive Table -->
@endsection