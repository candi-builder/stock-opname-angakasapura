@extends('layouts/contentNavbarLayout')

@section('title', 'data report')

@section('content')
<div class="py-3  d-flex">
  <h4 class=" fw-light p-2 flex-fill">
    chart user yg sudah upload setiap bulan nya
  </h4>
</div>

<!-- Basic Bootstrap Table -->

<!--/ Table within card -->
<!-- Responsive Table -->
<canvas id="dataChart" width="100" height="50"></canvas>
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
          <th>batas jumlah stock</th>
          <th>tanggal</th>
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
          <td>{{ $report->batasan}}</td>
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
<script>
  
        const url = 'http://127.0.0.1:8001/api/apiChart'; 

        function fetchData() {
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json(); 
                })
                .then(data => {
                    createChart(data);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        function createChart(data) {
            const ctx = document.getElementById('dataChart').getContext('2d');

            const labels = data.data.countPerMonth.map(item => `Bulan ${item.bulan}`);
            const userCounts = data.data.countPerMonth.map(item => item.user_count)
            console.log(labels.map(item=>item));
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah pengguna yang mengirim bulan ini',
                        data: userCounts,
                        borderWidth: 1,
                        barPercentage: 0.5,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: data.data.totalUser
                        }
                    }
                }
            });
        }

        // Call the function to fetch and display the data in chart
        fetchData();
    </script>
<!--/ Responsive Table -->
@endsection
