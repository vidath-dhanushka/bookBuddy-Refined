
        const ctx = document.getElementById('profitabilityChart').getContext('2d');
        const data = {
            labels: ['January', 'February', 'March', 'April', 'May'], // Time periods
            datasets: [
                {
                    label: 'Subscription Revenue',
                    data: [5000, 6000, 7500, 8000, 8500],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Copyright Expenses',
                    data: [2000, 2500, 3000, 3200, 3500],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Profit',
                    data: [3000, 3500, 4500, 4800, 5000],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        };

        const config = {
            type: 'line', // Area chart is a type of line chart with `fill: true`
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Profitability Analysis'
                    }
                }
            }
        };

        new Chart(ctx, config);

   