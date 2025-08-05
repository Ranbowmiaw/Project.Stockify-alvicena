@extends('example.layouts.default.dashboard')
@section('content')


{{-- TEMPAT TAMBAH PRODUCT --}}
    <div class="col-span-2">
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
          <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                  <li class="inline-flex items-center">
                    <a href="{{ url('dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                      <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                      Dashboard
                    </a>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <a href="{{ url('example/staff/opname') }}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Stock</a>
                    </div>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <a href="{{ url('example/staff/opname') }}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Stocks Opname</a>
                    </div>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page"> Update Opname</span>
                    </div>
                  </li>
                </ol>
            </nav>
            <h1 class="mb-4 text-xl font-semibold dark:text-white">Update Stock</h3>
            <small class="p-3 bg-red-100 text-red-700 rounded mb-4">NOTE: PASTIKAN STOCKNYA SESUAI DENGAN DI GUDANG</small>
        </div>

        {{-- stock tambah --}}
  <form action="{{ route('opnamee.update', $opname->id) }}" method="POST">
      @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
              <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Produk</label>
              <input type="text" value="{{ $opname->product->name }}" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
            <div>
              <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock sistem</label>
              <input type="number" value="{{ $opname->quantity }}" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
              </select>
            </div>
            <div>
            @php
              $isMasuk = $opname->type === 'masuk';
              $realValue = $isMasuk ? ($opname->opname->real_in_quantity ?? '') : ($opname->opname->real_out_quantity ?? '');
            @endphp

            <label for="real_quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Stock Fisik {{ $isMasuk ? 'Masuk' : 'Keluar' }}
            </label>
            <input
              type="number"
              name="real_quantity"
              value="{{ old('real_quantity', $realValue) }}"
              required
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            />

            </div>
            <div>
                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                 <textarea name="note" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{ old('note', $opname->note) }}</textarea>
            </div>
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select name="status" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="pending" {{ $opname->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="Diterima" {{ $opname->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="Ditolak" {{ $opname->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="Dikeluarkan" {{ $opname->status == 'Dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
            </select>
            </div>
            <br>
            <div>
                <button class="inline-flex items-center px-6 py-3 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="submit">Save</button>
                <a href="{{ url('example/staff/opname') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-sm px-6 py-3 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div> 
@endsection
