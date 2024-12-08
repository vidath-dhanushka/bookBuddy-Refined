<?php $this->view('courier/includes/sidenav'); ?>
<courierDashboard>
    <h1 class="title">Courier Dashboard</h1>

    <h2 style="text-align: center;">Monthly Earnings</h2>
    <hr>
    <div class="chart-container">
        <canvas id="earningsChart"></canvas>
    </div>
    <br>
    <br>

    <h2 style="text-align: center;">Orders Status</h2>
    <hr>
    <div style=" width: 100%; display:flex; align-items:center; justify-content:center">
        <div class="chart-container" style="width: 50%;">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
    <br>
    <br>
    <h2 style="text-align: center;">Order history (last 7 days)</h2>
    <hr>
    <div style="display:flex; align-items:center; justify-content:center">
        <div class="chart-container" style="width: 80%; height: inherit;">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
</courierDashboard>
<script>
    // Earnings Chart (Line Chart)
    const earningsCtx = document.getElementById('earningsChart').getContext('2d');
    new Chart(earningsCtx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: 'Monthly Earnings (Rs)',
                data: [5000, 7000, 8000, 10000, 6000, 9000, 12000, 11000, 9500, 8000, 7500, 11000],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.3 // Smooth curves
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Order Status Distribution (Pie Chart)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ["Pending", "Completed", "Returned"],
            datasets: [{
                data: [30, 50, 20], // Sample data
                backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // Orders Per Day (Bar Chart)
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            datasets: [{
                label: 'Orders',
                data: [5, 10, 8, 6, 9, 12, 7], // Sample data
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>