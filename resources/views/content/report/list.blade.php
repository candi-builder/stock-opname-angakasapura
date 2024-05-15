  @extends('layouts/contentNavbarLayout')

  @section('title', 'Tables - Basic Tables')

  @section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Buat Report
  </h4>

  <!-- Basic Bootstrap Table -->

  <!--/ Table within card -->

  <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Catat Stock</h5> <small class="text-muted float-end">item</small>
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
        <form action="{{route('process-add-report')}}" method="POST" >
        @csrf
          <div class="mb-3">
            <label  class="form-label" for="basic-default-fullname">Item</label>
            <select  class="form-control selectdua" name="item">
            <option disabled value="-">Item</option>
              @foreach($md as $item)
              <option value="{{$item->id}}">{{$item->no_article}} - {{$item->description}}</option>
              @endforeach
            </select>
            @error('uom')
              <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="description">jumlah</label>
            <input type="number" class="form-control" name="jumlah" placeholder="jumlah" />
            @error('jumlah')
             <div class="text-danger">{{ $message }}</div>
           @enderror
          </div>
         
          
          <!-- <a href="{{route('get-list-item')}}" class="btn btn-outline-primary">Batal</a> -->
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
            <th>tanggal pelaporan</th>
            <th>jumlah</th>
            <th>reporter</th>
            <th>station</th>
            <th>region</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($dataReport as $report)
          <tr>
            <td>{{ ++$i}}</td>
            <td>{{ $report->no_article}}</td>
            <td>{{ $report->mgname}}</td>
            <td>{{ $report->description}}</td>
            <td>{{ $report->uomname}}</td>
            <td>{{ $report->reporting_date}}</td>
            <td>{{ $report->jumlah}}</td>
            <td>{{ $report->username}}</td>
            <td>{{ $stationUser->name}}</td>
            <td>{{ $regionUser->name}}</td>
          </tr>
          @endforeach
      
        </tbody>
      </table>
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
      {{ $dataReport->onEachSide(1)->links('pagination::bootstrap-5') }}
  </div>

    </div>

  </div>
  <!--/ Responsive Table -->
  @endsection
