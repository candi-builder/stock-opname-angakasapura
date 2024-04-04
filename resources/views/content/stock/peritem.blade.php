@extends('layouts/contentNavbarLayout')

@section('title', 'data stock')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Data stock
</h4>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->   
<!-- Responsive Table -->
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5 class="">data stock setiap item nya </h5>

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
    <!-- <a href="{{route('add-item')}}">
      <button class="btn btn-primary">Tambah Item</button>
    </a> -->
    <div></div>
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
          <th>stock</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($shosStockPerItem as $stock)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $stock->no_article}}</td>
          <td>{{ $stock->material_group}}</td>
          <td>{{ $stock->description}}</td>
          <td>{{ $stock->uom}}</td>
          <td>{{ $stock->stock}}</td>
        </tr>
        @endforeach
    
      </tbody>
    </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
    {{ $shosStockPerItem->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  </div>

</div>
<!--/ Responsive Table -->
@endsection
