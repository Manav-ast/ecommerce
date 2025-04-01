@props(['monthlyRevenue'])
<div class="bg-white rounded-lg shadow-md overflow-auto">
    <div class="p-3 md:p-4 border-b border-gray-200">
        <h3 class="text-base md:text-lg font-semibold">Monthly Revenue</h3>
    </div>
    <div class="p-2 md:p-4">
        <div class="w-full h-[250px] md:h-[300px]">
            <canvas id="revenueChart" data-revenue='@json($monthlyRevenue)'></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/revenue-chart.js') }}"></script>
@endpush
