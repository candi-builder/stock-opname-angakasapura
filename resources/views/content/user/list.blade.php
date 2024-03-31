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
  <h5 class="card-header">Responsive Table</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>No</th>
          <th>username</th>
          <th>station</th>
          <th>region</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($users as $user)
        <tr>
          <td>{{ ++$i}}</td>
          <td>{{ $user->username}}</td>
          <td>{{ $user->station}}</td>
          <td>{{ $user->region}}</td>
        </tr>
        @endforeach
    
      </tbody>
    </table>
  </div>
</div>
<!--/ Responsive Table -->
@endsection
