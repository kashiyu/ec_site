<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ec_toolController;
use App\Http\Controllers\ec_loginController;
use App\Http\Controllers\ec_storeController;

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

Route::get('/', function () {
    return view('welcome');
});

/* login -------------------------------------------- */
//ログインページ
Route::get('/ec/login', [ec_loginController::class, 'index']);

//ログイン処理
Route::post('/ec/login', [ec_loginController::class, 'login']);

//ログアウト処理
Route::get('/ec/logout', [ec_loginController::class, 'logout']);

//ユーザー登録画面
Route::get('/ec/register', [ec_loginController::class, 'register_page']);

//ユーザー登録処理
Route::post('/ec/register', [ec_loginController::class, 'register']);


/* ec_tool -------------------------------------------- */
//管理ページ
Route::get('/ec/tool', [ec_toolController::class, 'index']);

//商品の登録
Route::post('/ec/tool/add', [ec_toolController::class, 'add_item']);

//商品の削除
//Route::post('/ec/tool/delete', [ec_toolController::class, 'delete_item']);
Route::delete('/ec/tool/delete', [ec_toolController::class, 'delete_item']);

//ステータス変更
Route::post('/ec/tool/chz_sts', [ec_toolController::class, 'change_status']);

//在庫数変更
Route::post('/ec/tool/chz_stock', [ec_toolController::class, 'change_stock']);

//ユーザー管理ページ
Route::get('/ec/tool/admin', [ec_toolController::class, 'user_management']);

//管理者権限変更
Route::post('/ec/tool/admin/chz_adm', [ec_toolController::class, 'change_adm_flag']);

//ユーザー削除
Route::post('/ec/tool/admin/delete', [ec_toolController::class, 'delete_user']);


/* ec_store -------------------------------------------- */
//ECトップページ
Route::get('/ec/store', [ec_storeController::class, 'index']);

//カートページへ遷移
Route::get('/ec/store/cart', [ec_storeController::class, 'cart_page']);

//商品をカートへ入れる
Route::post('/ec/store/cart_in', [ec_storeController::class, 'add_cart']);

//カートから商品を削除
Route::post('/ec/store/cart/delete', [ec_storeController::class, 'delete_cart']);

//カート内のアイテムの数量を変更
Route::post('/ec/store/cart/chz_amount', [ec_storeController::class, 'change_amount_cart']);

//カート内のアイテムの数量を変更
Route::post('/ec/store/cart/buy', [ec_storeController::class, 'buy_item']);


