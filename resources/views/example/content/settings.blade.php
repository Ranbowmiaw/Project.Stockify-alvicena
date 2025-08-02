@extends('example.layouts.default.dashboard')

@section('content')
<div class="grid grid-cols-4 gap-4 px-4 pt-6">
  <div class="mb-4 col-span-full xl:mb-2">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
              <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                  <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                  Home
                </a>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                  <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Users</a>
                </div>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                  <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Settings</span>
                </div>
              </li>
            </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">User settings</h1>
        @if(session('success'))
    <div class="p-3 bg-green-100 text-green-700 rounded mb-4" id="success-message">
        {{ session('success') }}
    </div>

    <script>
        // Refresh halaman setelah 2 detik
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    </script>
@endif
    </div>


    {{-- KIRI: Kotak 1 + Kotak 3 dalam satu kolom vertikal --}}
    <div class="flex flex-col gap-4">

        {{-- Kotak 1 - Atas (Profile) --}}
        <div class="bg-white dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow col-span-1">
            <div class="flex flex-col sm:flex-row xl:flex-col 2xl:flex-row sm:items-start xl:items-start 2xl:items-start sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                    <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" src="{{ asset('image/profiles/' . (Auth::user()->profile_picture ?? 'default.jpeg')) }}" alt="Profile Picture">
                            <div>
                                <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Profile picture</h3>
                                <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                                    JPG, GIF or PNG. Max size of 800K
                                </div>
                                <div class="flex items-center space-x-4">
                                    <form action="{{ route('settings.updatePicture') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                            <div class="flex items-center space-x-4">
                                                <label class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg cursor-pointer bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                    <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
                                                Upload picture
                                            <input type="file" name="profile_picture" class="hidden" onchange="this.form.submit()">
                                        </label>
                                    <a href="{{ route('settings.deletepicture') }}" onclick="return confirm('Yakin ingin menghapus foto profil?')"
                                        class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        Delete </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        {{-- Kotak 3 - Bawah (Quick Panel) --}}
        <div class="bg-white dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow col-span-4">
            <h4 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Quick Panel</h4>
            <a href="{{ url('dashboard') }}" class="space-y-2 text-gray-700 dark:text-gray-300 text-sm">🛖 Dashboard</a>
            <br><br><br><br><br><br><br><br><br><br><br><br>  
        </div>
    </div>

    {{-- KANAN: Kotak 2 (Form Info) --}}
<div class="bg-white dark:bg-gray-800 p-6 border border-gray-200 dark:border-gray-700 rounded-lg shadow col-span-3">
    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Pengaturan Umum</h3>
    <form action="{{ route('settings.updateInfo') }}" method="POST" onsubmit="return confirmPasswordChange();">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input name="name" type="text" value="{{ old('name', Auth::user()->name) }}" class="w-full p-2.5 rounded-lg border bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600" placeholder="Bonnie Green">
            </div>
             <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full p-2.5 rounded-lg border bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Change Password</label>
                <input name="password" id="password" type="password" class="w-full p-2.5 rounded-lg border bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600" placeholder="Biarkan kosong jika tidak ingin mengubah">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
                <input type="text" disabled value="{{ Auth::user()->role }}" class="w-full p-2.5 rounded-lg border bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600">
            </div>
        </div>
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-700 hover:bg-primary-800 rounded-lg focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Simpan Perubahan
        </button>
        <button type="button" 
    onclick="if(confirm('Yakin ingin menghapus akun ini? Tindakan ini tidak bisa dibatalkan.')) { document.getElementById('delete-account-form').submit(); }"
    class="mt-4 px-4 py-2  text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
    Hapus Akun
</button>

</form>
</div>
<form id="delete-account-form" action="{{ route('settings.deleteAccount') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- Konfirmasi jika password diisi --}}
<script>
function confirmPasswordChange() {
    const password = document.getElementById('password').value;
    if (password.trim() !== '') {
        return confirm('Apakah kamu yakin ingin mengubah passwordmu?');
    }
    return true;
}
</script>

</div>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    {{-- TEMPAT settings WEBSITE --}}
    <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="p-6 bg-white rounded shadow dark:bg-gray-800">
            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Pengaturan Website</h2>

            {{-- Notifikasi error --}}
            @if($errors->any())
                <div class="mb-4 p-4 text-red-700 bg-red-100 rounded dark:bg-red-700 dark:text-white">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nama Website</label>
                    <input type="text" name="site_name" value="{{ old('site_name', setting('site_name')) }}"
                        class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Logo Website</label>
                    <input type="file" name="site_logo"
                        class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    
                    @if(setting('site_logo'))
                        <img src="{{ asset('images/logo/' . setting('site_logo')) }}" alt="Logo"
                            class="w-24 mt-2 border rounded shadow">
                    @endif
                </div>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
