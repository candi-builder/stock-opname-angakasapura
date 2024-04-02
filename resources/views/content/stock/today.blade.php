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
    <h5 class="">histori stock hari ini</h5>
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
          <th>grand total</th>
          <th>tanggal</th>
          <th>aksi</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($showDataStock as $stock)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $stock->no_article}}</td>
          <td>{{ $stock->mgname}}</td>
          <td>{{ $stock->description}}</td>
          <td>{{ $stock->uomname}}</td>
          <td>{{ $stock->stock}}</td>
          <td>{{ $stock->tanggal}}</td>
          </td>
        </tr>
        @endforeach
    
      </tbody>
    </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
    {{ $showDataStock->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  </div>

</div>
<!--/ Responsive Table -->
@endsection
