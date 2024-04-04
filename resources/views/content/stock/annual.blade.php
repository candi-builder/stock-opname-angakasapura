@extends('layouts/contentNavbarLayout')

@section('title', 'data stock')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Data stock
</h4>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->   
<!-- Responsive Table -->

@php
    // Ambil nilai bulan dari sesi
    $monthNumber = Session::get('monthlyHistory');
    // Konversi angka bulan menjadi nama bulan menggunakan Carbon
    $monthName = \Carbon\Carbon::create()->month($monthNumber)->monthName;
@endphp

<div class="card">
<div class="p-2">

<form class="d-flex align-items-center gap-4" action="{{ route('filter-data-stock') }}" method="POST">
    @csrf
    <div class="">
      <input type="hidden" class="form-control" name="month" value="0" placeholder="tahun" />
      </div>
    <div class="">
      <input type="number" class="form-control" name="year" value="{{$year}}" placeholder="tahun" />
      </div>
      <button type="submit" class="btn btn-primary">Filter</button>
      @error('year')
              <div class="text-danger">{{ $message }}</div>
      @enderror
    </form>
</div>
  <div class="card-header d-flex justify-content-between">
    <div class="d-flex flex-column">
      
      <h5 class="">histori stock tahun {{Session::get('annualHistory') }}</h5>
      <p>total stok pada tahun ini :  {{$totalStock}}</p>
    </div>
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
        @if(count($showDataStock) === 0)
        <tr>
            <td class="text-center" colspan="8">tidak ada histori stock pada tahun {{Session::get('annualHistory') }} </td>
        </tr>
        @else
        @foreach($showDataStock as $stock)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $stock->no_article}}</td>
          <td>{{ $stock->mgname}}</td>
          <td>{{ $stock->description}}</td>
          <td>{{ $stock->uomname}}</td>
          <td>{{ $stock->qty}}</td>
          <td>{{ $stock->tanggal}}</td>
          <td>
            <a href="{{ route('detail-stock-today',  ['id' => $stock->mdid, 'tanggal' => $stock->tanggal,'jumlah' => $stock->stock]) }}">
                <button type="submit" class="btn btn-info">Detail</button>
            </a>
          </td>
        </tr>
        @endforeach
        @endif
    
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
