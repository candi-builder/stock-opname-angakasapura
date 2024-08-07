@extends('layouts/contentNavbarLayout')

@section('title', ' Tambah Batasan Stock Item')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5 class="">Batasan Stock Station</h5>
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
    <a href="{{route('add-report-batasan-stock-station')}}">
      <button class="btn btn-primary">Tambah Batasan Stock</button>
    </a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>No</th>
          <th>Station</th>
          <th>Item</th>
          <th>Batasan</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($showDataBatasanStockStation as $report)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $report->name}}</td>
          <td>{{ $report->description}}</td>
          <td>{{ $report->batasan}}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
    {{-- {{ $showDataReport->onEachSide(1)->links('pagination::bootstrap-5') }} --}}
</div>

  </div>

</div>
@endsection
