<?php

Route::group(['middleware' => ['auth', 'check.permission']], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index');
    Route::get('info-box', 'DashboardController@InfoBox');

    // Proveedores
    Route::get('proveedores', 'VendorController@index')->name('proveedores.index');
    Route::post('proveedores', 'VendorController@store')->name('proveedores.store');
    Route::get('proveedores/delete/{id}', 'VendorController@destroy')->name('proveedores.delete');
    Route::post('proveedores/update/{id}', 'VendorController@update')->name('proveedores.update');
    Route::get('vendor-list', 'VendorController@Vendor');

    // Categorías
    Route::resource('category', 'CategoryController');
    Route::get('category/delete/{id}', 'CategoryController@destroy');
    Route::post('category/update/{id}', 'CategoryController@update');
    Route::get('category-list', 'CategoryController@CategoryList');
    Route::get('all-category', 'CategoryController@AllCategory');

    // Accesorios
    Route::resource('accesorios', 'AccesorioController');
    Route::get('accesorios/delete/{id}', 'AccesorioController@destroy');
    Route::post('accesorios/update/{id}', 'AccesorioController@update');
    Route::get('accesorios-list', 'AccesorioController@AccesoriosList');
    Route::get('category/accesorios/{id}', 'AccesorioController@accesoriosByCategory');
    

    // Reparaciones
    Route::get('/reparaciones', 'ReparacionController@index')->name('reparaciones.index');
    Route::post('/reparaciones/store', 'ReparacionController@store')->name('reparaciones.store');
    Route::post('/reparaciones/update/{id}', 'ReparacionController@update')->name('reparaciones.update');
    Route::post('/reparaciones/estado', 'ReparacionController@estado')->name('reparaciones.estado');
    Route::post('/reparaciones/destroy/{id}', 'ReparacionController@destroy')->name('reparaciones.destroy');

    // Clientes
    Route::resource('customer', 'CustomerController');
    Route::get('customer/delete/{id}', 'CustomerController@destroy');
    Route::post('customer/update/{id}', 'CustomerController@update');
    Route::get('customer-list', 'CustomerController@CustomerList');
    

    // Stock
    Route::resource('stock', 'StockController');
Route::get('stock/delete/{id}', 'StockController@destroy');
Route::post('stock/update/{id}', 'StockController@update');
Route::get('stock-list', 'StockController@StockList');
Route::get('chalan-list/chalan/{id}', 'StockController@ChalanList');
Route::get('stock-asset', 'StockController@StockAsset');
Route::post('stock-update', 'StockController@StockUpdate');
Route::get('get-products/{category_id}', 'StockController@getProducts');

    // FACTURAS
Route::get('invoice', 'InvoiceController@index')->name('invoice.index');
Route::post('invoice/store', 'InvoiceController@store')->name('invoice.store');
Route::get('invoice-list', 'InvoiceController@InvoiceList')->name('invoice.list');
Route::get('invoice/show/{id}', 'InvoiceController@show');
Route::get('invoice/print/{id}', 'InvoiceController@print');



// 🔥 PARA PRODUCTOS DINÁMICOS
Route::get('get-products/{category_id}', 'StockController@getProducts');

// productos dinámicos
Route::get('get-products/{category_id}', 'StockController@getProducts');
    // Pagos
    Route::resource('payment', 'PaymentController');
    Route::get('payment/delete/{id}', 'PaymentController@destroy');

    // Roles
    Route::resource('role', 'RoleController');
    Route::get('role/delete/{id}', 'RoleController@destroy');
    Route::post('role/update/{id}', 'RoleController@update');
    Route::get('role-list', 'RoleController@RoleList');
    Route::post('permission', 'RoleController@Permission');

    // Reportes
    Route::get('report', ['as' => 'report.index', 'uses' => 'ReportingController@index']);
    Route::get('get-report', ['as' => 'report.store', 'uses' => 'ReportingController@store']);
    Route::get('print-report', ['as' => 'report.print', 'uses' => 'ReportingController@Print']);

    // Usuarios
    Route::get('user', 'UserController@index')->name('user.index');
    Route::post('user/store', 'UserController@store')->name('user.store');
    Route::delete('user/{id}', 'UserController@destroy')->name('user.destroy');

    // Configuración
    Route::get('comapany-setting', ['as' => 'company.index', 'uses' => 'CompanyController@index']);
    Route::post('comapany-setting', ['as' => 'company.store', 'uses' => 'CompanyController@store']);
    Route::get('password-change', ['as' => 'password.index', 'uses' => 'SettingController@index']);
    Route::post('password-change', ['as' => 'password.store', 'uses' => 'SettingController@store']);

    Route::get('user-role', 'RoleController@userRole');
    Route::get('logout', 'UserController@logout')->name('logout.custom');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');