@extends('layouts/contentNavbarLayout')

@section('title', 'data stock')

@section('content')
@php

    // Konversi angka bulan menjadi nama bulan menggunakan Carbon
    $monthName = \Carbon\Carbon::create()->month($tanggal)->monthName;
@endphp
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">detail stock per user pada bulan {{$monthName}}
</h4>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->   
<!-- Responsive Table -->
<div class="card">
  <div class="card-header d-flex justify-content-between">
     <div class="d-flex flex-column">
     <h5 class="">History  stock  </h5>
      <p>no article : {{$itemname->no_article}} </p>
      <p>description : {{$itemname->description}} </p>
      <p>total stock item : {{$jumlah}}</p>
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
          <th>reporter</th>
          <th>station</th>
          <th>region</th>
          <th>jumlah yang dimasukan</th>
          <th>tanggal</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($detailStock as $stock)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $stock->asu}}</td>
          <td>{{ $stock->station}}</td>
          <td>{{ $stock->region}}</td>
          <td>{{ $stock->jumlah}}</td>
          <td>{{ $stock->tanggal}}</td>
          </td>
        </tr>
        @endforeach
    
      </tbody>
    </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
    {{ $detailStock->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  </div>

</div>
<!--/ Responsive Table -->
@endsection
