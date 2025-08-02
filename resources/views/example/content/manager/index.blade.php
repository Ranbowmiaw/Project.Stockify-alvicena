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

  {{-- TABLE 2 --}}
      <div class="grid w-full grid-cols-4 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-1">      
         <!--Jumlah Stock Hari ini -->
        <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
          <h2 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Jumlah Stock Hari Ini</h2>
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
                            Nama Product
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Stock Fisik
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Stock Minimum
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Status
                          </th>
                        </tr>
                      </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                      @foreach($minimumStockProducts as $Stockminim)
                          <tr>
                              <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $loop->iteration }}</td>
                              <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $Stockminim->name }}</td>
                              <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                  @php
                                      $realIn = optional($Stockminim->opnames)->sum('real_in_quantity') ?? 0;
                                      $realOut = optional($Stockminim->opnames)->sum('real_out_quantity') ?? 0;
                                      $currentStock = $realIn - $realOut;

                                      // Fallback kalau tidak ada data
                                      if ($currentStock === 0 && $Stockminim->latestOpname) {
                                          $currentStock = $Stockminim->latestOpname->real_quantity ?? 0;
                                      }
                                  @endphp
                                  {{ $currentStock > 0 ? $currentStock : 'Belum dicek' }}
                              </td>
                              <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $Stockminim->minimum_stock }}</td>
                              <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                  @if ($currentStock < $Stockminim->minimum_stock)
                                      <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-red-400 border border-red-100 dark:border-red-500">Stock Rendah</span>
                                  @else
                                      <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">Stock Aman</span>
                                  @endif
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
            </div>
          </div>
          </div>
     </div>
     {{-- GRAFIK --}}
      <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800 xl:mb-0">
        <div class="grid grid-cols-1 my-4 xl:grid-cols-8 xl:gap-4"> 
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
              <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">total product stock since last month</h3>
              <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">Total Stock Product</span>
            </div>
          </div>
          {{-- grafik disini --}}
          <div id="grafik-stock"></div>
        </div>
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



