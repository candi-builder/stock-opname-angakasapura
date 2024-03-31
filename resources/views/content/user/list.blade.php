@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">User /</span> List User
</h4>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->

<hr class="my-5">

<!-- Responsive Table -->
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5 class="">List User</h5>
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
      <button class="btn btn-primary">Tambah User</button>
    </a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>No</th>
          <th>username</th>
          <th>station</th>
          <th>region</th>
          <th>action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($users as $user)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $user->username}}</td>
          <td>{{ $user->station}}</td>
          <td>{{ $user->region}}</td>
          <td>
          <form method="POST" action="{{ route('reset-pw', $user->id) }}">
              @csrf
              @method('POST')
              <button type="submit" class="btn btn-success">Reset Password</button>
          </form>

          </td>
        </tr>
        @endforeach
    
      </tbody>
    </table>
  </div>
</div>
<!--/ Responsive Table -->
@endsection
