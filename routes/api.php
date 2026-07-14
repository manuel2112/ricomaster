<?php

use App\Http\Controllers\Admin\AssociatedController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\ClientFinalController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ParameterController;
use App\Http\Controllers\Admin\TypeMenuController;
use App\Http\Controllers\Admin\WhatsappController;
use App\Http\Controllers\Public\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('menu/list', [MenuController::class, 'list']);
Route::post('menu/store', [MenuController::class, 'store']);
Route::put('menu/update', [MenuController::class, 'update']);
Route::delete('menu/delete/{id}', [MenuController::class, 'delete']);

Route::get('bill/get/{id}', [BillController::class, 'getBill']);
Route::get('bill/edit/{id}', [BillController::class, 'getBillById']);
Route::get('bill/list', [BillController::class, 'listBill']);
Route::get('bill/next/{type?}', [BillController::class, 'nextBill']);
Route::get('bill/actual', [BillController::class, 'actualBill']);
Route::get('bill/minuta', [BillController::class, 'minutaBill']);
Route::get('bill/minuta/today', [BillController::class, 'minutaBillToday']);
Route::post('bill', [BillController::class, 'store']);
Route::post('bill/campaign', [BillController::class, 'storeCampaign']);
Route::put('bill/update', [BillController::class, 'update']);

Route::get('campaign/list', [CampaignController::class, 'listCampaigns']);
Route::get('campaign/today', [CampaignController::class, 'getCampaignToday']);
Route::get('campaign/{id}', [CampaignController::class, 'getCampaign']);

Route::get('type-menu/get', [TypeMenuController::class, 'get']);

Route::get('parameters', [ParameterController::class, 'getParameters']);
Route::post('parameters', [ParameterController::class, 'store']);

Route::get('associated/list/{filter}', [AssociatedController::class, 'list']);
Route::post('associated/store', [AssociatedController::class, 'store']);
Route::post('associated/search', [AssociatedController::class, 'search']);
Route::put('associated/update', [AssociatedController::class, 'update']);
Route::delete('associated/delete/{id}', [AssociatedController::class, 'delete']);

Route::get('bill/days', [OrderController::class, 'getDayOrder']);

Route::get('order/final', [OrderController::class, 'getFinalOrders']);
Route::post('order/final', [OrderController::class, 'storeFinal']);
Route::post('order/final/campaign', [OrderController::class, 'storeFinalCampaign']);
Route::get('order/details/final/order/{orderNumber}', [OrderController::class, 'getOrderByNumber']);
Route::get('order/details/final/{day}/{isCampaign}', [OrderController::class, 'getDayOrderDetailFinal']);
Route::get('order/details/final/day/{day}/{isCampaign}', [OrderController::class, 'getOrderFinalByDay']);

Route::get('order/associated', [OrderController::class, 'getAssociatedOrders']);
Route::post('order/associated', [OrderController::class, 'storeAssociated']);
Route::get('order/details/associated/{day}', [OrderController::class, 'getDayOrderDetailAssociated']);
Route::get('order/details/associated/order/{orderNumber}', [OrderController::class, 'getOrderByAssociated']);
Route::get('order/details/associated/day/{day}', [OrderController::class, 'getOrderAssociatedByDay']);

Route::get('final/list', [ClientFinalController::class, 'listClientFinal']);
Route::put('final/', [ClientFinalController::class, 'updateClientFinal']);
Route::get('associated/list', [AssociatedController::class, 'listAssociated']);
Route::put('associated/whatsapp', [AssociatedController::class, 'updateWhatsapp']);

Route::post('contact', [ContactController::class, 'send']);

Route::post('whatsapp/final', [WhatsappController::class, 'storeFinal']);
Route::post('whatsapp/associated', [WhatsappController::class, 'storeAssociated']);
