/**
 * Revenue Chart Initialization
 * 
 * This script initializes the monthly revenue chart using Chart.js
 */

document.addEventListener('DOMContentLoaded', function () {
    // Check if the revenue chart canvas exists
    const chartCanvas = document.getElementById('revenueChart');
    if (!chartCanvas) return;

    const ctx = chartCanvas.getContext('2d');

    // Get the monthly revenue data from the data attribute
    const monthlyRevenueData = JSON.parse(chartCanvas.getAttribute('data-revenue'));

    // Extract months and totals for the chart
    const months = monthlyRevenueData.map(item => item.month);
    const totals = monthlyRevenueData.map(item => item.total);

    // Create the chart
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Revenue ($)',
                data: totals,
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: window.innerWidth < 768 ? 'bottom' : 'top',
                    labels: {
                        boxWidth: window.innerWidth < 768 ? 12 : 40,
                        font: {
                            size: window.innerWidth < 768 ? 10 : 12
                        }
                    }
                },
                tooltip: {
                    titleFont: {
                        size: window.innerWidth < 768 ? 10 : 12
                    },
                    bodyFont: {
                        size: window.innerWidth < 768 ? 10 : 12
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return '$' + value;
                        },
                        font: {
                            size: window.innerWidth < 768 ? 8 : 11
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: window.innerWidth < 768 ? 8 : 11
                        }
                    }
                }
            }
        }
    });
});