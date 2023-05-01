<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseDetailController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);

});

Route::group([
    'Middleware' => [
        'auth.jwt'
    ],
    'role:superAdmin|admin',
    'prefix' => 'admin',
], function () {
    Route::post('add-restaurant', [RestaurantController::class, 'addRestaurant'])->name('add.restaurant');
    Route::post('edit-restaurant/{id}', [RestaurantController::class, 'editRestaurant'])->name('edit.restaurant');
    Route::delete('delete-restaurant/{id}', [RestaurantController::class, 'deleteRestaurant'])->name('delete.restaurant');
    Route::get('list-restaurants', [RestaurantController::class, 'listRestaurants']);

    
    Route::post('add-category', [CategoryController::class, 'addCategory'])->name('add.category');
    Route::put('edit-category/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');
    Route::delete('delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete.category');
    Route::get('list-categories', [CategoryController::class, 'listCategories']);


    Route::post('add-type', [TypeController::class, 'addType'])->name('add.type');
    Route::put('edit-type/{id}', [TypeController::class, 'editType'])->name('edit.type');
    Route::delete('delete-type/{id}', [TypeController::class, 'deleteType'])->name('delete.type');
    Route::get('list-types', [TypeController::class, 'listTypes']);


    Route::post('add-food', [FoodController::class, 'addFood'])->name('add.food');
    Route::put('edit-food/{id}', [FoodController::class, 'editFood'])->name('edit.food');
    Route::delete('delete-food/{id}', [FoodController::class, 'deleteFood'])->name('delete.food');
    Route::get('list-foods', [FoodController::class, 'listFoods'])->name('list.food');
    Route::put('update-food-status/{id}', [FoodController::class, 'updateFoodStatus'])->name('update.food.status');


    Route::post('add-customer', [CustomerController::class, 'addCustomer'])->name('add.customer');
    Route::post('edit-customer/{id}', [CustomerController::class, 'editCustomer'])->name('edit.customer');
    Route::delete('delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete.customer');
    Route::get('list-customers', [CustomerController::class, 'listCustomers']);
    Route::put('update-customer-status/{id}', [CustomerController::class, 'updateCustomerStatus'])->name('update.customer.status');


    Route::post('add-purchaseOrder', [PurchaseOrderController::class, 'addPurchaseOrder'])->name('add.purchaseOrder');
    Route::post('add-purchaseDetail/{id}', [PurchaseOrderController::class, 'addPurchaseDetail'])->name('add.purchase.detail');
    Route::put('edit-purchaseOrder/{id}', [PurchaseOrderController::class, 'editPurchaseOrder'])->name('edit.purchaseOrder');
    Route::delete('delete-purchaseOrder/{id}', [PurchaseOrderController::class, 'deletePurchaseOrder'])->name('delete.purchaseOrder');
    Route::get('list-purchaseOrders', [PurchaseOrderController::class, 'listPurchaseOrders']);
    Route::get('list-purchaseDetail/{id}', [PurchaseOrderController::class, 'listPurchaseDetails']);
    Route::delete('delete-purchaseDetail/{id}', [PurchaseOrderController::class, 'deletePurchaseDetail'])->name('delete.purchaseDetail');
    Route::put('edit-purchaseDetail/{id}', [PurchaseOrderController::class, 'editPurchaseDetail'])->name('edit.purchaseDetail');


});
