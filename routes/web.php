<?php

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
namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Session\Session;
//use App\Http\Middleware\Logger;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\LogActivity;


Route::resource('documents', DocumentController::class);
Route::resource('deadlines', DeadlineController::class);
Route::resource('deadline-types', DeadlineTypeController::class);
Route::resource('document-types', DocTypeController::class);
Route::resource('followup-types', FollowupTypeController::class);
Route::resource('trackers', TrackerController::class);
Route::resource('statuses', StatusController::class);
Route::resource('security-levels', SecurityLevelController::class);






Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/maktoob', function () {
    return redirect('/index');
});

// FC9 routes




Route::get('/forbidden', function () {
    return view('forbidden');
})->name('forbidden');

Route::middleware(['logger'])->group(function () {
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
// General Routes
    Route::get('/search', [InventoryController::class, 'search'])->name('search');
    Route::get('/checkingLog', [InventoryController::class, 'checkingLog'])->name('checkingLog');
//    Route::post('/loggerTest', [InventoryController::class, 'loggerTest'])->name('loggerTest')->middleware('loggerActivity');

    Route::post('/loggerTest', function () {
        //
    })->name('loggerTest')->middleware('loggerActivity');
    Route::post('/upload', [AttachmentController::class, 'store'])->name('upload');
    Route::get('download/{id}', [AttachmentController::class, 'download'])->name('download');
    Route::get('print/{type}/{form_id}', [PrintController::class, 'print'])->name('print');
    Route::get('excel', [ExcelController::class, 'export'])->name('excel');
    Route::get('find', [InventoryController::class, 'find'])->name('find');
    Route::get('is_duplicate', [InventoryController::class, 'checkDuplication'])->name('is_duplicate');
    Route::get('check_email', [InventoryController::class, 'checkEmail'])->name('check_email');
    Route::get('getData', [InventoryController::class, 'getData'])->name('getData');
    Route::get('getReportData', [ReportsController::class, 'report'])->name('getData');
    Route::get('getEmployeesByDir', [InventoryController::class, 'getEmployeesByDir'])->name('getEmployeesByDir');
    Route::get('log', [InventoryController::class, 'logs'])->name('log');
    Route::get('get_form_items', [InventoryController::class, 'getFormItems'])->name('get_form_items');
    Route::get('get_item_details', [InventoryController::class, 'getItemDetails'])->name('get_item_details');
    Route::get('get_item_spec', [InventoryController::class, 'getItemSpec'])->name('get_item_spec');
    Route::get('employeeItemSpecs', [InventoryController::class, 'employeeItemSpecs'])->name('emp_item_spec');
    Route::get('getFormTypeData', [InventoryController::class, 'getFormTypeData'])->name('get_form_type_data');
    Route::get('getEmployeeFormItems', [InventoryController::class, 'getEmployeeFormItems'])->name('get_employee_form_items');
    // Route::get('getFecen8Items', [InventoryController::class, 'getFecen8Items'])->name('get_fecen8_items');
    // Route::get('getFecen8ItemSpecs', [InventoryController::class, 'getFecen8ItemSpecs'])->name('get_fecen8_items_specs');

    Route::post('export_data', [ExcelController::class, 'exportData'])->name('export_data');
    Route::post('flow', [InventoryController::class, 'flow'])->name('flow');
    Route::get('checkFlowPermission', [InventoryController::class, 'checkFlowPermission'])->name('checkFlowPermission');

    Route::get('getEmployeeItems', [InventoryController::class, 'getEmployeeItemReceived'])->name('getEmployeeItems');
    // Route::get('getStockItemspec', [InventoryController::class, 'getStockItemSpec'])->name('getStockItemspec');
    Route::get('getStockItems', [InventoryController::class, 'getStockItem'])->name('getStockItems');

   
//users routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('permission:user_list');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:user_create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store')->middleware('permission:user_create');
    Route::get('user/edit/{id}',  [UserController::class, 'edit'])->name('user.edit')->middleware('permission:user_edit');
    Route::get('user/show/{id}',  [UserController::class, 'show'])->name('user.show')->middleware('permission:user_view');
    Route::patch('user/update/{id}',  [UserController::class, 'update'])->name('user.update')->middleware('permission:user_edit');
    Route::delete('user/{id}',  [UserController::class, 'destroy'])->name('user.delete')->middleware('permission:user_delete');
    Route::post('user/deactivate/{id}',  [UserController::class, 'deactivate'])->name('user.deactivate')->middleware('permission:user_delete');
    Route::post('/user/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword')->middleware('permission:user_create');

//role routes
    Route::get('/role', [RoleController::class, 'index'])->name('role.index')->middleware('permission:role_list');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:role_create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store')->middleware('permission:role_create');
    Route::get('role/edit/{id}',  [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:role_edit');
    Route::get('role/show/{id}',  [RoleController::class, 'show'])->name('role.show')->middleware('permission:role_view');
    Route::patch('role/update/{id}',  [RoleController::class, 'update'])->name('role.update')->middleware('permission:role_edit');
    Route::delete('role/{id}',  [RoleController::class, 'destroy'])->name('role.delete')->middleware('permission:role_delete');

// Doc Mgt System Routing start
Route::get('/maktoob', [MaktobController::class, 'index'])->name('index');

 // End of Doc Mgt System
    Route::get('/general', function () {
        return view('reports.general');
    });
    Route::get('/404', function () {
        return view('404');
    });


    Route::get('/form-wizard', function () {
        return view('form-wizard');
    });
    Route::get('/process', function () {
        return view('process');
    });

//codded by naim start
    Route::get('reports', [ReportsController::class, 'index']);
    // New Settings Route of Naim
       Route::get('setting/item', [ItemsController::class, 'index'])->name('setting.item.index')->middleware('permission:setting_list');
    // Route::get('setting/item', [ItemsController::class, 'create'])->name('setting.item.create')->middleware('permission:setting_create');
    Route::post('setting/item/store', [ItemsController::class, 'store'])->name('setting.item.store')->middleware('permission:setting_create');
    Route::get('setting/item/{id}', [ItemsController::class, 'edit'])->middleware('permission:setting_edit');
    Route::patch('setting/item/{id}', [ItemsController::class, 'update'])->middleware('permission:setting_edit');
   
    // employee routing
    Route::get('setting/employee', [EmployeeController::class, 'index'])->name('setting.employee.index')->middleware('permission:setting_list');
    Route::post('setting/employee/store', [EmployeeController::class, 'store'])->name('setting.employee.store')->middleware('permission:setting_create');
    Route::get('setting/employee/{id}', [EmployeeController::class, 'edit'])->middleware('permission:setting_edit');
    Route::patch('setting/employee/{id}', [EmployeeController::class, 'update'])->middleware('permission:setting_edit');
// Directorate routing
    Route::get('setting/directorate', [DirectorateController::class, 'index'])->name('setting.directorate.index')->middleware('permission:setting_list');
    Route::post('setting/directorate/store', [DirectorateController::class, 'store'])->name('setting.directorate.store')->middleware('permission:setting_create');
    Route::get('setting/directorate/{id}', [DirectorateController::class, 'edit'])->middleware('permission:setting_edit');
    Route::patch('setting/directorate/{id}', [DirectorateController::class, 'update'])->middleware('permission:setting_edit');
    // Category routing
    Route::get('setting/category', [CategoryController::class, 'index'])->name('setting.category.index')->middleware('permission:setting_list');
    Route::post('setting/category/store', [CategoryController::class, 'store'])->name('setting.category.store')->middleware('permission:setting_create');
    Route::get('setting/category/{id}', [CategoryController::class, 'edit'])->middleware('permission:setting_edit');
    Route::patch('setting/category/{id}', [CategoryController::class, 'update'])->middleware('permission:setting_edit');
   // Unit 0f measure Routing
   Route::get('setting/unit_of_measure', [MeasureController::class, 'index'])->name('setting.unit_of_measure.index')->middleware('permission:setting_list');
   Route::post('setting/unit_of_measure/store', [MeasureController::class, 'store'])->name('setting.unit_of_measure.store')->middleware('permission:setting_create');
   Route::get('setting/unit_of_measure/{id}', [MeasureController::class, 'edit'])->middleware('permission:setting_edit');
   Route::patch('setting/unit_of_measure/{id}', [MeasureController::class, 'update'])->middleware('permission:setting_edit');
 //donor Routing 
 Route::get('setting/donors', [DonorController::class, 'index'])->name('setting.donors.index')->middleware('permission:setting_list');
 Route::post('setting/donors/store', [DonorController::class, 'store'])->name('setting.donors.store')->middleware('permission:setting_create');
 Route::get('setting/donors/{id}', [DonorController::class, 'edit'])->middleware('permission:setting_edit');
 Route::patch('setting/donors/{id}', [DonorController::class, 'update'])->middleware('permission:setting_edit');
// venders routing
Route::get('setting/venders', [VenderController::class, 'index'])->name('setting.venders.index')->middleware('permission:setting_list');
Route::post('setting/venders/store', [VenderController::class, 'store'])->name('setting.venders.store')->middleware('permission:setting_create');
Route::get('setting/venders/{id}', [VenderController::class, 'edit'])->middleware('permission:setting_edit');
Route::patch('setting/venders/{id}', [VenderController::class, 'update'])->middleware('permission:setting_edit');
//heiat tashrih
Route::get('setting/heiat', [HeiatController::class, 'index'])->name('setting.heiat.index')->middleware('permission:setting_list');
Route::post('setting/heiat/store', [HeiatController::class, 'store'])->name('setting.heiat.store')->middleware('permission:setting_create');
Route::get('setting/heiat/{id}', [HeiatController::class, 'edit'])->middleware('permission:setting_edit');
Route::patch('setting/heiat/{id}', [HeiatController::class, 'update'])->middleware('permission:setting_edit');

//hangar
Route::get('setting/hangars', [HangarController::class, 'index'])->name('setting.hangars.index')->middleware('permission:setting_list');
Route::post('setting/hangars/store', [HangarController::class, 'store'])->name('setting.hangars.store')->middleware('permission:setting_create');
Route::get('setting/hangars/{id}', [HangarController::class, 'edit'])->middleware('permission:setting_edit');
Route::patch('setting/hangars/{id}', [HangarController::class, 'update'])->middleware('permission:setting_edit');
//motamed
Route::get('setting/motamed', [MotamedController::class, 'index'])->name('setting.motamed.index')->middleware('permission:setting_list');
Route::post('setting/motamed/store', [MotamedController::class, 'store'])->name('setting.motamed.store')->middleware('permission:setting_create');
Route::get('setting/motamed/{id}', [MotamedController::class, 'edit'])->middleware('permission:setting_edit');
Route::patch('setting/motamed/{id}', [MotamedController::class, 'update'])->middleware('permission:setting_edit');

//    End of routing by naim
// Category Route
  
//Unit of Measure Route
//Item Type Routing
  
//codded ended by naim
//
// form Moblin
  
// Routing change by naim start
  

    Route::get('reports/report', function () {
        return view('reports/report');
    });
//language
    Route::get('lang.switch/{lang}',[LanguageController::class, 'switchLang'])->name('lang.switch');

});
