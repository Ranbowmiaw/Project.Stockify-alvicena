<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AtributsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\StockSettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// laravel
Route::get('/', function () {
    return view('example.welcome', ['title' => 'laravel']);
})->name('welcome');

Route::get('/dashboard', function () {
    $role = strtolower(Auth::user()->role);

    if ($role === 'admin') {
        return redirect()->route('dashboard.admin');
    } elseif ($role === 'manager gudang') {
        return redirect()->route('dashboard.manager');
    } elseif ($role === 'staff gudang') {
        return redirect()->route('dashboard.staff');
    }

    abort(403, 'Role tidak dikenali =>' . Auth::user()->role );
})->middleware('auth')->name('dashboard');

Route::get('/settings-role', function () {
    $role = strtolower(Auth::user()->role);

    if ($role === 'admin') {
        return redirect()->route('settings.admin');
    } elseif ($role === 'manager gudang') {
        return redirect()->route('settings.manager');
    } elseif ($role === 'staff gudang') {
        return redirect()->route('settings.staff');
    }

    abort(403, 'Role tidak dikenali =>' . Auth::user()->role );
})->middleware('auth')->name('settings');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('/laporan/activity', [ActivityLogController::class, 'index'])->name('laporan.activity');
    Route::get('admin/settings', [SettingController::class, 'index'])->name('settings.admin');
    
    // Sidebar penghubung
    Route::get('example/crud/add', function () {
        return view('example.content.crud.add');
    });

    Route::get('example/categori/category', function () {
        return view('example.content.categori.category');
    });
    
    Route::get('example/supplier/suppliers', function () {
        return view('example.content.supplier.suppliers');
    });

    Route::get('example/stock/stocks', function () {
        return view('example.content.stock.stocks');
    });
    
    Route::get('example/product_atribut/atribut', function () {
        return view('example.content.product_atribut.atribut');
    });

    Route::get('example/users/log', function () {
        return view('example.content.user_log.userlogg');
    });

    Route::get('example/opname', function () {
        return view('example.content.stock.opname');
    });

    // bagian laporan
    Route::get('example/laporan_stock', function () {
        return view('example.content.laporan.lap1.lapstock');
    });

    Route::get('example/laporan_transaksi', function () {
        return view('example.content.laporan.lap2.laptransaksi');
    });

    // Master shifu //
    Route::get('example/admin/products', [ProductController::class, 'products'])->name('crud.products');
    Route::get('example/admin/category', [CategoriesController::class, 'categori'])->name('categori.categori');
    Route::get('example/admin/suppliers', [SupplierController::class, 'suppliyer'])->name('supplier.suppliers');
    Route::get('example/admin/stocks', [StockController::class, 'stock'])->name('stock.stocks');
    Route::get('example/admin/atribut', [AtributsController::class, 'atribut'])->name('atribut.atribut');
    Route::get('example/admin/users/log', [UserController::class, 'user'])->name('user_log.userlogg');
    Route::get('example/admin/opname', [StockOpnameController::class, 'opname'])->name('stock.opname');
    Route::get('example/admin/minimum-stock', [StockSettingController::class, 'minimumStock'])->name('stock.settings');

    //settings for Admin
    Route::get('example/settings',[UserController::class, 'settings'])->name('settings');
    Route::post('/settings/update-info', [UserController::class, 'updateInfo'])->name('settings.updateInfo');

    // Export/Import Data
    Route::post('/products/import', [ProductController::class, 'import'])->name('product.import');
    Route::get('/products/export', [ProductController::class, 'export'])->name('product.export');

    // aplikasi logo & nama
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Menampilkan laporan stock
    Route::get('example/admin/laporan_stock', [LaporanController::class, 'lapstock1'])->name('reports.lapstock1');
    // Menampilkan laporan transaksi
    Route::get('example/admin/laporan_transaksi', [LaporanController::class, 'lapstock2'])->name('reports.lapstock2');
    // Menapilkan laporan log users
    Route::get('example/admin/laporan_Users', [ActivityLogController::class, 'index'])->name('reports.activity');

    // Untuk export pdff
    Route::get('example/laporan_stock/export', [LaporanController::class, 'export1'])->name('reports.export1');
    Route::get('example/laporan_transaksi/{id}', [LaporanController::class, 'export2'])->name('reports.export2');


    //route users log
    Route::prefix('user')->controller(UserController::class)->group( function () {
        Route::get('','users')->name('user');
        Route::get('edit/{id}','edit')->name('user.edit');
        Route::post('edit/{id}','update')->name('user.tambah.update');
        Route::get('hapus/{id}','hapus')->name('user.hapus');
    });

    //profile update
    Route::middleware(['auth'])->controller(UserController::class)->group(function () {
        Route::get('/settings', 'settings')->name('settings');
        Route::post('/settings/profile-picture', 'updateProfilePicture')->name('settings.updatePicture');
        Route::get('/settings/delete-picture', 'deleteProfilePicture')->name('settings.deletepicture');
        Route::delete('/settings/delete-account', 'deleteAccount')->name('settings.deleteAccount');
    });

    //product atribut
    Route::prefix('atribut')->controller(AtributsController::class)->group( function () {
        Route::get('','atribut')->name('tribute');
        Route::get('tambah','tambah')->name('tribute.tambah');
        Route::post('tambah','simpan')->name('tribute.tambah.simpan');
        Route::get('edit/{id}','edit')->name('tribute.edit');
        Route::post('edit/{id}','update')->name('tribute.tambah.update');
        Route::get('hapus/{id}','hapus')->name('tribute.hapus');
    });

    //stock
    Route::prefix('stock')->controller(StockController::class)->group(function () {
        Route::get('','stock')->name('stok');
        Route::get('tambah','tambah')->name('stok.tambah');
        Route::post('tambah','simpan')->name('stok.tambah.simpan');
        Route::get('hapus/{id}','hapus')->name('stok.hapus');
    });

    //opname
    Route::prefix('opname')->controller(StockOpnameController::class)->group(function () {
        Route::get('','opname')->name('opnamee');
        Route::get('edit/{id}','edit')->name('opnamee.edit');
        Route::put('edit/{id}','update')->name('opnamee.update');
        Route::get('hapus/{id}','hapus')->name('opnamee.hapus');
    });
    
    //supplier
    Route::prefix('suppliers')->controller(SupplierController::class)->group(function () {
        Route::get('','suppliyer')->name('suppliers');
        Route::get('tambah','tambah')->name('suppliers.tambah');
        Route::post('tambah','simpan')->name('suppliers.tambah.simpan');
        Route::get('edit/{id}','edit')->name('suppliers.edit');
        Route::post('edit/{id}','update')->name('suppliers.tambah.update');
        Route::get('hapus/{id}','hapus')->name('suppliers.hapus');
    });
    
    // category
    Route::prefix('category')->controller(CategoriesController::class)->group(function () {
        Route::get('','categori')->name('category');
        Route::get('tambah','tambah')->name('category.tambah');
        Route::post('tambah','simpan')->name('category.tambah.simpan');
        Route::get('edit/{id}','edit')->name('category.edit');
        Route::post('edit/{id}','update')->name('category.tambah.update');
        Route::get('hapus/{id}','hapus')->name('category.hapus');
    });
    
    // product
    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('', 'products')->name('product');
        Route::get('tambah', 'tambah')->name('product.tambah');
        Route::post('tambah', 'simpan')->name('product.tambah.simpan');
        Route::get('edit/{id}', 'edit')->name('product.edit');  
        Route::post('edit/{id}', 'update')->name('product.tambah.update');
        Route::get('hapus/{id}','hapus')->name('product.hapus');
    });
});


// ROLE MANAGER
Route::middleware(['auth', 'role:Manager Gudang'])->group(function () {
    Route::get('dashboard/manager', [DashboardController::class, 'index'])->name('dashboard.manager');
    Route::get('example/product_atribut/atribut', [ProductController::class, 'products'])->name('product.stocks');
    Route::get('manager/settings', [SettingController::class, 'index'])->name('settings.manager');

    // Master shifu //
    Route::get('/pengaturan/stok-minimum', [StockSettingController::class, 'minimumStock'])->name('stok.minimum');
    Route::get('example/manager/settings', [SettingController::class, 'index'])->name('settings');
    Route::get('example/manager/products', [ProductController::class, 'products'])->name('crud.products');
    Route::get('example/manager/suppliers', [SupplierController::class, 'suppliyer'])->name('supplier.suppliers');
    Route::get('example/manager/stocks', [StockController::class, 'stock'])->name('stok');
    Route::get('example/manager/atribut', [AtributsController::class, 'atribut'])->name('atribut.atribut');
    Route::get('example/manager/opname', [StockOpnameController::class, 'opname'])->name('stock.opname');

    //settings for profile
    Route::get('example/settings',[UserController::class, 'settings'])->name('settings');
    Route::post('/settings/update-info', [UserController::class, 'updateInfo'])->name('settings.updateInfo');

    // Menampilkan laporan stock
    Route::get('example/manager/laporan_stock', [LaporanController::class, 'lapstock1'])->name('reports.lapstock1');
    // Menampilkan laporan transaksi
    Route::get('example/manager/laporan_transaksi', [LaporanController::class, 'lapstock2'])->name('reports.lapstock2');

    // Untuk export pdff
    Route::get('example/laporan_stock/export', [LaporanController::class, 'export1'])->name('reports.export1');
    Route::get('example/laporan_transaksi/{id}', [LaporanController::class, 'export2'])->name('reports.export2');

    //profile update
    Route::middleware(['auth'])->controller(UserController::class)->group(function () {
        Route::get('/settings', 'settings')->name('settings');
        Route::post('/settings/profile-picture', 'updateProfilePicture')->name('settings.updatePicture');
        Route::get('/settings/delete-picture', 'deleteProfilePicture')->name('settings.deletepicture');
        Route::delete('/settings/delete-account', 'deleteAccount')->name('settings.deleteAccount');
    });

    //product atribut
    Route::prefix('atribut')->controller(AtributsController::class)->group( function () {
        Route::get('','atribut')->name('tribute');
    });

    //stock
    Route::prefix('stock')->controller(StockController::class)->group(function () {
        Route::get('','stock')->name('stok');
        Route::get('tambah','tambah')->name('stok.tambah');
        Route::post('tambah','simpan')->name('stok.tambah.simpan');
        Route::get('hapus/{id}','hapus')->name('stok.hapus');
    });

    //opname
    Route::prefix('opname')->controller(StockOpnameController::class)->group(function () {
        Route::get('','opname')->name('opnamee');
        Route::get('edit/{id}','edit')->name('opnamee.edit');
        Route::put('edit/{id}','update')->name('opnamee.update');
        Route::get('hapus/{id}','hapus')->name('opnamee.hapus');
    });
    
    //supplier
    Route::prefix('suppliers')->controller(SupplierController::class)->group(function () {
        Route::get('','suppliyer')->name('suppliers');
    });
    
    // product
    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('', 'products')->name('product');
    });
});



// role for staff gudang
Route::middleware(['auth', 'role:Staff Gudang'])->group(function () {
    Route::get('staff/dashboard', [DashboardController::class, 'index'])->name('dashboard.staff');
    Route::get('example/product_atribut/atribut', [ProductController::class, 'products'])->name('product.stocks');
    Route::get('staff/settings', [SettingController::class, 'index'])->name('settings.staff');

    // Master shifu //
    Route::get('example/staff/stocks', [StockController::class, 'stock'])->name('stok');
    Route::get('example/staff/opname', [StockOpnameController::class, 'opname'])->name('stock.opname');

    //settings for profile
    Route::get('example/settings',[UserController::class, 'settings'])->name('settings');
    Route::post('/settings/update-info', [UserController::class, 'updateInfo'])->name('settings.updateInfo');

    //profile update
    Route::middleware(['auth'])->controller(UserController::class)->group(function () {
        Route::get('/settings', 'settings')->name('settings');
        Route::post('/settings/profile-picture', 'updateProfilePicture')->name('settings.updatePicture');
        Route::get('/settings/delete-picture', 'deleteProfilePicture')->name('settings.deletepicture');
        Route::delete('/settings/delete-account', 'deleteAccount')->name('settings.deleteAccount');
    });

    //stock
    Route::prefix('stock')->controller(StockController::class)->group(function () {
        Route::get('','stock')->name('stok');
    });

    //opname
    Route::prefix('opname')->controller(StockOpnameController::class)->group(function () {
        Route::get('','opname')->name('opnamee');
        Route::get('edit/{id}','edit')->name('opnamee.edit');
        Route::put('edit/{id}','update')->name('opnamee.update');
        Route::get('hapus/{id}','hapus')->name('opnamee.hapus');
    });
});


// Pages
Route::get('pages/pricing/', function () {
    return view('example.content.pages.pricing', ['title' => 'Pricing Plans']);
})->name('pages.pricing');

Route::get('pages/maintenance/', function () {
    return view('example.content.pages.maintenance', ['title' => 'Maintenance Mode']);
})->name('pages.maintenance');

Route::get('pages/404/', function () {
    return view('example.content.pages.404', ['title' => '404 - Page Not Found']);
})->name('pages.404');

Route::get('pages/500/', function () {
    return view('example.content.pages.500', ['title' => '500 - Server Error']);
})->name('pages.500');


// Authentication LOGIN/REGISTER
Route::controller(AuthController::class)->group(function () {
    Route::get('register','register')->name('register');
    Route::post('register','registerSimpan')->name('register.simpan');

    Route::get('login','login')->name('login');
    Route::post('login','loginAksi')->name('login.aksi');

    Route::get('logout','logout')->middleware('auth')->name('logout');
});

// Authentication
Route::get('authentication/sign-in', function () {
    return view('example.content.authentication.sign-in', ['title' => 'Sign In']);
})->name('sign-in');

Route::get('authentication/sign-up', function () {
    return view('example.content.authentication.sign-up', ['title' => 'Sign Up']);
})->name('sign-up');

Route::get('authentication/forgot-password', function () {
    return view('example.content.authentication.forgot-password', ['title' => 'Forgot Password']);
})->name('forgot-password');

Route::get('authentication/reset-password', function () {
    return view('example.content.authentication.reset-password', ['title' => 'Reset Password']);
})->name('reset-password');

Route::get('authentication/profile-lock', function () {
    return view('example.content.authentication.profile-lock', ['title' => 'Profile Lock']);
})->name('profile-lock');



// Playground
Route::get('playground/stacked', function () {
    return view('example.content.playground.stacked', ['title' => 'Playground - Stacked Layout']);
})->name('playground.stacked');

Route::get('playground/sidebar', function () {
    return view('example.content.playground.sidebar', ['title' => 'Playground - Sidebar Layout']);
})->name('playground.sidebar');



// cuman test
Route::get('test', function () {
    return view('test');
});
