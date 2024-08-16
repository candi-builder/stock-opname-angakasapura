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
  </div>
  <form action="{{route('process-add-batasan-stock-station')}}" method="POST" >
    @csrf
    <div class="mb-3">
      <label  class="form-label" for="basic-default-fullname">Station</label>
      <select  class="form-control selectdua" name="userStations">
      <option disabled value="-">Station</option>
        @foreach($userStations as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
      </select>
      @error('userStations')
        <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label  class="form-label" for="basic-default-fullname">Item</label>
      <select  class="form-control selectdua" name="item">
      <option disabled value="-">Item</option>
        @foreach($md as $item)
        <option value="{{$item->id}}">{{$item->no_article}} - {{$item->description}}</option>
        @endforeach
      </select>
      @error('item')
        <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label  class="form-label" for="basic-default-fullname">Batasan Stock</label>
      <input type="text" placeholder="Batasan Stock" class="form-control" name="batasan_stock">
      @error('batasan_stock')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

      <button type="submit" class="btn btn-primary">Kirim</button>
      </form>
      </div>
    </div>
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
