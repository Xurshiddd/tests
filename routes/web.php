<?php
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController as Prd;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    $p = DB::table('products')->count();
    $u = DB::table('users')->count();
    $c = DB::table('categories')->count();
    $t = DB::table('tags')->count();
    $data = [
        'labels' => ['Product', 'Users', 'Categories', 'Tag'],
        'data' => [$p, $u, $c, $t],
    ];
    return view('dashboard', compact('data'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('attribute-values', AttributeValueController::class);
    Route::resource('products', ProductController::class);
    Route::resource('brands', ProductBrandController::class);
    Route::resource('tags', TagController::class);
    \Buki\AutoRoute\Facades\Route::auto('data', \App\Repositories\DataRepository::class);
});
\Buki\AutoRoute\Facades\Route::auto('front', \App\Repositories\FrontRepository::class);
Route::resource('product', Prd::class);
Route::post('form', function (\Illuminate\Http\Request $request){
    dd($request->all());
})->name('form');
require __DIR__.'/auth.php';
