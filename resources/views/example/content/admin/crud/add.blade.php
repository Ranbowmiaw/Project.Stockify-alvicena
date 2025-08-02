@extends('example.layouts.default.dashboard')
@section('content')


{{-- TEMPAT TAMBAH PRODUCT --}}
    <div class="col-span-2">
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
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
                      <a href="{{ url('example/admin/products') }}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Master Product</a>
                    </div>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <a href="{{ url('example/admin/products') }}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Products</a>
                    </div>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">{{ isset($product) ? 'Edit Products' : 'Add Products' }}</span>
                    </div>
                  </li>
                </ol>
            </nav>

            {{-- crud tambah --}}
            <h3 class="mb-4 text-xl font-semibold dark:text-white">{{ isset($product) ? 'Edit Products' : 'Add Products' }}</h3>
            <form action="{{ isset($product) ? route('product.tambah.update', $product->id) : route('product.tambah.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
            <div>
                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                <select name="category_id" id="category_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                 <option value="">-- Pilih Kategori --</option>
                     @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                             {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                         </option>
                     @endforeach
                </select>
            </div>
             <div>
                <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">supplier</label>
                <select name="supplier_id" id="supplier_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                 <option value="">-- Pilih Supplier --</option>
                     @foreach ($suppliers as $supliers)
                        <option value="{{ $supliers->id }}"
                                {{ isset($product) && $product->supplier_id == $supliers->id ? 'selected' : '' }}>
                                {{ $supliers->name }}
                        </option>
                     @endforeach
                </select>
            </div>
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"placeholder="Ketik nama product disini" value="{{ isset($product) ? $product->name : '' }}">
            </div>
            <div>
                <label for="sku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock keeping unit</label>
                <input type="text" name="sku" id="sku" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"placeholder="Ketik nama product disini" value="{{ isset($product) ? $product->sku : '' }}">
            </div>
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ketik deskripsi product disini">{{ old('description', $product->description ?? '') }}</textarea>

            </div>
            <div>
                <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga pembelian</label>
                <input type="number" name="purchase_price" id="purchase_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ketik nominal harga pembelian disini" value="{{ isset($product) ? $product->purchase_price : '' }}">
            </div>
            <div>
                <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga penjualan</label>
                <input type="number" name="selling_price" id="selling_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ketik nominal harga penjualan disini" value="{{ isset($product) ? $product->selling_price : '' }}">
            </div>
            <div>
              <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar Product</label>
              <input type="file" name="image" id="image"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div>
                <label for="minimum_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Minimal stock</label>
                <input type="number" name="minimum_stock" id="minimum_stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ketik minimal stock product disini" value="{{ isset($product) ? $product->minimum_stock : '' }}">
            </div>
                        <button class="inline-flex items-center px-6 py-3 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="submit">Save</button>
                    <a href="{{ url('example/crud/products') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-sm px-6 py-3 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">Cancel</a>
            </div>
            </form>
        </div>
@endsection
