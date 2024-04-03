@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">uom /</span> Item
</h4>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->

<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Tambah Data uom</h5> <small class="text-muted float-end">item</small>
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
    <form action="{{route('process-add-uom')}}" method="POST" >
    @csrf
      <div class="mb-3">
        <label class="form-label" for="name">Name uom</label>
        <input type="text" class="form-control" name="name" placeholder="Nama uom" value="" />
        @error('name')
        <div class="text-danger">{{ $message }}</div>
@enderror
      </div>
      <a href="{{route('get-list-uom')}}" class="btn btn-outline-primary">Batal</a>
      <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
  </div>
</div>

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
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>No</th>
          <th>name</th>
          <th>aksi</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($uom as $item)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $item->name}}</td>
          <td class="d-flex gap-2">
          <a href="{{ route('edit-uom', $item->id) }}">
              <button type="submit" class="btn btn-success">Ubah</button>
          </a>
          <form method="POST" action="{{ route('delete-uom', $item->id) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger">Hapus</button>
          </form>
          </td>
        </tr>
        @endforeach
    
      </tbody>
    </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
    {{ $uom->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  </div>

</div>
<!--/ Responsive Table -->
@endsection