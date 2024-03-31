@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Master Data /</span> Item
</h4>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->

<hr class="my-5">

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
    <a href="{{route('add-new-user')}}">
      <button class="btn btn-primary">Tambah Item</button>
    </a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>No</th>
          <th>no article</th>
          <th>material group</th>
          <th>new description</th>
          <th>UOM</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($dataItems as $item)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $item->no_article}}</td>
          <td>{{ $item->material_group}}</td>
          <td>{{ $item->description}}</td>
          <td>{{ $item->uom}}</td>
          <td class="d-flex gap-2">
          <a href="{{ route('edit-item', $item->id) }}">
              <button type="submit" class="btn btn-success">Ubah</button>
          </a>
          <form method="POST" action="{{ route('delete-item', $item->id) }}">
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
    {{ $dataItems->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  </div>

</div>
<!--/ Responsive Table -->
@endsection
