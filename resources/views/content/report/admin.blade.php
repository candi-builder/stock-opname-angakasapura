@extends('layouts/contentNavbarLayout')

@section('title', 'data report')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Data Report
</h4>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->   
<!-- Responsive Table -->
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5 class="">histori report</h5>
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
          <th>user</th>
          <th>grand total</th>
          <th>tanggal</th>
          <th>aksi</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($showDataReport as $report)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $report->no_article}}</td>
          <td>{{ $report->mgname}}</td>
          <td>{{ $report->description}}</td>
          <td>{{ $report->uomname}}</td>
          <td>{{ $report->username}}</td>
          <td>{{ $report->jumlah}}</td>
          <td>{{ $report->reporting_date}}</td>

          </td>
        </tr>
        @endforeach
    
      </tbody>
    </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
    {{ $showDataReport->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  </div>

</div>
<!--/ Responsive Table -->
@endsection
