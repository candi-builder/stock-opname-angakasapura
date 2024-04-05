  @extends('layouts/contentNavbarLayout')

  @section('title', 'Tables - Basic Tables')

  @section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Master Data /</span> Item
  </h4>

  <!-- Basic Bootstrap Table -->

  <!--/ Table within card -->
   @if(session('userSession')->role == 'superadmin')
  <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Item</h5> <small class="text-muted float-end">item</small>
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
        <form action="{{route('process-add-item')}}" method="POST" >
        @csrf
          <div class="mb-3">
            <label class="form-label" for="no_article">no article</label>
            <input type="text" class="form-control" name="no_article" placeholder="ACSS" value="ACSS" />
            @error('no_article')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="description">new description</label>
            <input type="text" class="form-control" name="description" placeholder="nama item" />
            @error('description')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <div class="mb-3">
            <label  class="form-label" for="mg">Material Group</label>
            <select  class="form-control selectdua" name="mg">
            <option disabled value="-">Pilih Material Group</option>
              @foreach($mg as $item)
              <option value="{{$item->id}}">{{$item->name}}</option>
              @endforeach
            </select>
            @error('mg')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <div class="mb-3">
            <label  class="form-label" for="basic-default-fullname">Station</label>
            <select  class="form-control selectdua" name="uom">
            <option disabled value="-">Pilih UOM</option>
              @foreach($uoms as $uom)
              <option value="{{$uom->id}}">{{$uom->name}}</option>
              @endforeach
            </select>
            @error('uom')
            <div class="text-danger">{{ $message }}</div>
  @enderror
          </div>
          <!-- <a href="{{route('get-list-item')}}" class="btn btn-outline-primary">Batal</a> -->
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
    @endif
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
      <div><form action="{{route('get-list-region')}}" method="GET" >
        @csrf
          <div class="input-group">
            <input type="text" class="form-control" name="cari" placeholder="Cari disini" value="" />
            <button type="submit" class="btn btn-primary">
              Cari
            </button>
          </div>
        </form></div>
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
            <td>{{ $item->mgname}}</td>
            <td>{{ $item->description}}</td>
            <td>{{ $item->uom_name}}</td>
            @if(session('userSession')->role == 'superadmin')
            <td class="d-flex gap-2">
            <a href="{{ route('edit-item', $item->no_article) }}">
                <button type="submit" class="btn btn-success">Ubah</button>
            </a>
            <form method="POST" action="{{ route('delete-item', $item->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Hapus</button>
            </form>
            </td>
            @endif
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
