@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display JSON Data in Chart</title>
    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Data Chart</h1>
    <canvas id="dataChart" height="10"></canvas>

    <script>
        // URL of the JSON data
        const url = 'http://127.0.0.1:8000/api/apiChart'; // Ganti dengan URL yang benar

        // Function to fetch and display the data in chart
        function fetchData() {
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json(); // Convert response to JSON
                })
                .then(data => {
                    createChart(data); // Call the function to create chart
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        // Function to create the chart
        function createChart(data) {
            const ctx = document.getElementById('dataChart').getContext('2d');

            // Extracting data for the chart
            const labels = data.data.map(item => `Bulan ${item.bulan}`);
            const userCounts = data.data.map(item => item.user_count);

            // Creating the chart
            new Chart(ctx, {
                type: 'bar', // Type of chart: bar, line, pie, etc.
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'User Count per Bulan',
                        data: userCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Call the function to fetch and display the data in chart
        fetchData();
    </script>
</body>
</html>

@endsection
