<?php
use App\Http\Controllers\LanguageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// dashboard Routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard','DashboardController@index');
    
    //Taxes
    Route::resource('/finance/taxes', 'TaxesController');
    Route::post('/finance/taxes/delete', 'TaxesController@delete')->name('taxes.delete');

    //Product Categories
    Route::resource('/product-categories', 'ProductCategoriesController');
    Route::post('/product-categories/delete', 'ProductCategoriesController@delete')->name('product-categories.delete');
    
    //Pricing
    Route::resource('/plans', 'PricingController');
    Route::post('/payment', 'PricingController@payment')->name('payment');
	
	//Products
	Route::resource('/products', 'ProductsController');
	Route::post('/products/delete', 'ProductsController@delete')->name('products.delete');
	
	//Account Settings
	Route::resource('/account-settings', 'AccountSettingsController');
	Route::post('/account-settings/update-general', 'AccountSettingsController@updateGeneral')->name('account-settings.updateGeneral');
	Route::post('/account-settings/update-password', 'AccountSettingsController@updatePassword')->name('account-settings.updatePassword');
	Route::post('/account-settings/update-info', 'AccountSettingsController@updateInfo')->name('account-settings.updateInfo');
	
	//Customers
    Route::resource('/customers', 'CustomersController');
	Route::post('/customers/delete', 'CustomersController@delete')->name('customers.delete');
	Route::post('/customers/update-general', 'CustomersController@updateGeneral')->name('customers.updateGeneral');
	
	//Billings
    Route::resource('/billings', 'BillingsController');
	
	//Invoices
    Route::resource('/invoices', 'InvoicesController');
	Route::post('/address', 'InvoicesController@address')->name('invoices.address');
	Route::get('/view-invoice/{id}', 'InvoicesController@view');
	Route::get('/edit/{id}', 'InvoicesController@edit');
	Route::post('/update', 'InvoicesController@update')->name('invoices.update');
	Route::post('/invoices/delete', 'InvoicesController@delete')->name('invoices.delete');
	Route::post('/invoices/payment', 'InvoicesController@payment')->name('invoices.payment');
	
	//Payment Modes
    Route::resource('/payment-modes', 'PaymentModesController');
    Route::post('/payment-modes/delete', 'PaymentModesController@delete')->name('payment-modes.delete');
	
	//Expenses Categories
    Route::resource('/expenses-categories', 'ExpensesCategoriesController');
    Route::post('/expenses-categories/delete', 'ExpensesCategoriesController@delete')->name('expenses-categories.delete');
	
	//Expenses
    Route::resource('/expenses', 'ExpensesController');
    Route::post('/expenses/delete', 'ExpensesController@delete')->name('expenses.delete');
});

Route::get('/','Auth\LoginController@showLoginForm')->name('login');

// locale Route
Route::get('lang/{locale}',[LanguageController::class,'swap']);

// acess controller
Route::get('/access-control', 'AccessController@index');
Route::get('/access-control/{roles}', 'AccessController@roles');
Route::get('/ecommerce', 'AccessController@home')->middleware('role:Admin');

Route::get('/register/complete', 'CompanyController@showCompleteRegister')->name('company.register');

Route::get('/verify', 'CompanyController@verifyEmail')->name('company.verify');
Route::post('/activate', 'CompanyController@activateCompany')->name('company.activate');

Route::post('/register/resend', 'CompanyController@resendEmail')->name('verification.resend');
Auth::routes();


//Auth::routes(['verify' => true]);
Route::stripeWebhooks('stripe-webhook');



