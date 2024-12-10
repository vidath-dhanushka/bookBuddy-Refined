

const ctx = document.getElementById('profitabilityChart').getContext('2d');

console.log(profitabilityData);
const chartData = {
    labels: profitabilityData.labels,  // Months
    datasets: [
        {
            label: 'Subscription Revenue',
            data: profitabilityData.revenue,  // Revenue data
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: true,
            tension: 0.4
        },
        {
            label: 'Copyright Expenses',
            data: profitabilityData.expenses,  // Expenses data
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            fill: true,
            tension: 0.4
        },
        {
            label: 'Profit',
            data: profitabilityData.profit,  // Profit data
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            fill: true,
            tension: 0.4
        }
    ]
};

// Chart.js configuration
const config = {
    type: 'line', // You can use other types like 'bar' if needed
    data: chartData,
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

// Create the chart
new Chart(ctx, config);
