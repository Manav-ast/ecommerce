@props(['monthlyRevenue'])
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-3 md:p-4 border-b border-gray-200">
        <h3 class="text-base md:text-lg font-semibold">Monthly Revenue</h3>
    </div>
    <div class="p-2 md:p-4">
        <div class="w-full h-[250px] md:h-[300px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('revenueChart').getContext('2d');

                    // Parse the monthly revenue data from PHP
                    const monthlyRevenueData = @json($monthlyRevenue);

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
                                            callback: function(value) {
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
                            });
                    });
    </script>
@endpush
