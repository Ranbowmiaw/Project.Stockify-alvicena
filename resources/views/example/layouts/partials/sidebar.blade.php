@php
    $url = explode('/', request()->url());
    $page_slug = $url[count($url) - 2];
@endphp

@php
  $role = Auth::user()->role;
@endphp

@if ($role === 'Admin')
    @include('example.layouts.partials.sidebar.admin')
@elseif ($role === 'Manager Gudang')
    @include('example.layouts.partials.sidebar.Manager')
@elseif ($role === 'Staff Gudang')
    @include('example.layouts.partials.sidebar.staff')
@endif

