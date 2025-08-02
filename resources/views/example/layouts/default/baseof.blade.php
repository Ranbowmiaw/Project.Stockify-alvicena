<!doctype html>
<html lang="en" class="dark">
  <head>
    @include('example.layouts.partials.header')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  </head>
  @php
    $whiteBg = isset($params['white_bg']) && $params['white_bg'];
  @endphp


<body class="{{ $whiteBg ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800' }}">

  @yield('main')
  @include('example.layouts.partials.scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

</body>


</html>
