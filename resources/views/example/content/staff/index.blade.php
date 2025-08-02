@extends('example.layouts.default.dashboard')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@vite(['resources/css/app.css','resources/js/app.js'])

{{-- TABLE 1 --}}
<div class="px-4 pt-6">
 
    {{-- TEMPAT Hitung product,supplier,category --}}
<div class="grid w-full grid-cols-1 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-3">
    @foreach ($charts as $chart)
    <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="w-full">
            <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $chart['label'] }}</h3>
            <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $chart['count'] }}</span>
            <p class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400">
                <span class="flex items-center mr-1.5 text-sm text-green-500 dark:text-green-400">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"></path>
                    </svg>
                    {{ $chart['percentage'] }}
                </span>
                Since last week
            </p>
        </div>
        <div class="w-full">
            <div id="{{ $chart['id'] }}"></div>
        </div>
    </div>
    @endforeach
</div>

{{-- TABLE 4 --}}
<br>
{{-- TRANSAKSI --}}
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
      <!-- head table -->
      <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
          <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Information</h3>
          <span class="text-base font-normal text-gray-500 dark:text-gray-400">Note : Pastikan product yang masuk/keluar harus sesuai</span>
        </div>
      </div> 
      <!-- Table transaksi -->
      <div class="flex flex-col mt-6">
        <div class="overflow-x-auto rounded-lg">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      No
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Date
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Name product
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Note
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                  @foreach($lap2  as $key => $transaction)
                    <tr>
                      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ $key + 1 }}</td>
                      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
                      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ $transaction->product->name ?? '-' }}</td>
                      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ $transaction->note ?? 'TOLOL' }}
                      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        @php
                          $status = strtolower($transaction->status);
                          $badgeColor = match($status) {
                            'pending' => 'bg-yellow-300 text-yellow-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300 dark:border-yellow-300',
                            'ditolak' => 'bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-red-400 border border-red-100 dark:border-red-500',
                            'dikeluarkan' => 'bg-green-100 text-red-600 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-red-600 border border-green-100 dark:border-green-500',
                            'diterima' => 'bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500',
                            default => 'bg-gray-100 text-gray-800',
                          };
                        @endphp
                        
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                          {{ ucfirst($transaction->status) }}
                        </span>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- table Footer -->
      <div class="flex items-center justify-between pt-3 sm:pt-6">
        <div>
        </div>
        <div class="flex-shrink-0">
          <a href="#" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
           Transactions Report
            <svg class="w-4 h-4 ml-1 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
          </a>
        </div>
      </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const charts = @json($charts);

    charts.forEach(item => {
        const chart = new ApexCharts(document.querySelector("#" + item.id), {
            chart: {
                type: 'area',
                height: 40,
                sparkline: { enabled: true }
            },
            series: [{ data: item.data }],
            stroke: { curve: 'smooth', width: 2 },
            colors: [item.color]
        });
        chart.render();
    });
});
</script>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: 'donut',
                height: 720
            },
            series: [{{ $totalStockIn }}, {{ $totalStockOut }}],
            labels: ['Stock Masuk', 'Stock Keluar'],
            colors: ['#10b981', '#ef4444'],
            legend: { position: 'bottom',  },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val.toFixed(1) + '%';
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#grafik-stock"), options);
        chart.render();
    });
</script>



