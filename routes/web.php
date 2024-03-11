<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/userlist', [App\Http\Controllers\UsersController::class, 'userlist'])->name('userlist');
Route::any('/user_card', [App\Http\Controllers\UsersController::class, 'userCard'])->name('user_card');
Route::any('/user_card_edit/{user_id}', [App\Http\Controllers\UsersController::class, 'userCardEdit'])->name('user_card_edit');
Route::any('/user_card_delete/{user_id}', [App\Http\Controllers\UsersController::class, 'deleteuserCard'])->name('user_card_delete');
Route::any('/get-user-access-module', [App\Http\Controllers\UsersController::class, 'getUserAccessModule'])->name('get-user-access-module');

Route::get('/companylist', [App\Http\Controllers\UsersController::class, 'companyList'])->name('companylist');
Route::any('/company_card', [App\Http\Controllers\UsersController::class, 'companyCard'])->name('company_card');
Route::get('/get-comuna/{region_id}', [App\Http\Controllers\UsersController::class, 'getComuna'])->name('get-comuna');
Route::any('/company_card_edit/{company_id}', [App\Http\Controllers\UsersController::class, 'companyCardEdit'])->name('company_card_edit');
Route::any('/company_card_delete/{company_id}', [App\Http\Controllers\UsersController::class, 'deleteCompanyCard'])->name('company_card_delete');


Route::any('/projectlist', [App\Http\Controllers\BudgetController::class, 'projectlist'])->name('projectlist');
Route::any('/project_card', [App\Http\Controllers\BudgetController::class, 'projectCard'])->name('project_card');
Route::any('/project_card_edit/{project_id}', [App\Http\Controllers\BudgetController::class, 'projectCardEdit'])->name('project_card_edit');
Route::any('/project_card_delete/{project_id}', [App\Http\Controllers\BudgetController::class, 'deleteprojectCard'])->name('project_card_delete');

Route::any('/business-line-list', [App\Http\Controllers\BudgetController::class, 'BusinessLineList'])->name('business-line-list');
Route::any('/delete_business_card/{line_id}', [App\Http\Controllers\BudgetController::class, 'deleteBusinessCard'])->name('delete_business_card');


Route::any('/account-list', [App\Http\Controllers\BudgetController::class, 'accountList'])->name('account-list');
Route::any('/supplierlist', [App\Http\Controllers\ExpensesController::class, 'supplierList'])->name('supplierlist');
Route::any('/supplier-export', [App\Http\Controllers\ExpensesController::class, 'supplierExport'])->name('supplier.export');

Route::any('/servicelist', [App\Http\Controllers\ExpensesController::class, 'serviceList'])->name('servicelist');
Route::any('/service-export', [App\Http\Controllers\ExpensesController::class, 'serviceExport'])->name('service.export');

Route::any('/resourcelist', [App\Http\Controllers\ExpensesController::class, 'resourceList'])->name('resourcelist');
Route::any('/resource-export', [App\Http\Controllers\ExpensesController::class, 'resourceExport'])->name('resource.export');

Route::any('/export-execution-expenses', [App\Http\Controllers\ExpensesController::class, 'exportExecutionExpenses'])->name('export.execution.expenses');

Route::any('/export-softland', [App\Http\Controllers\ExpensesController::class, 'exportExportSoftland'])->name('export.softland');


Route::any('/executioncard', [App\Http\Controllers\ExpensesController::class, 'executionCardList'])->name('executioncard');

Route::any('/executionresourcelist', [App\Http\Controllers\ExpensesController::class, 'executionResourceList'])->name('executionresourcelist');
Route::any('/execution-resource-export', [App\Http\Controllers\ExpensesController::class, 'executionResourceExport'])->name('execution.resource.export');

Route::any('/execution-expenses-card', [App\Http\Controllers\ExpensesController::class, 'executionExpenseCard'])->name('execution.expenses.card');

Route::any('/execution-resource-by-supplier', [App\Http\Controllers\ExpensesController::class, 'getExcutionResourceListBySupplier'])->name('execution-resource-by-supplier');

Route::any('/expenseslist', [App\Http\Controllers\ExpensesController::class, 'expensesList'])->name('expenseslist');
Route::any('/normal-expense-card', [App\Http\Controllers\ExpensesController::class, 'expenseNormalCard'])->name('normal.expense.card');
Route::any('/normal-expense-card-edit/{expense_id}', [App\Http\Controllers\ExpensesController::class, 'expenseNormalCardEdit'])->name('normal-expense-card-edit');

Route::any('/execution-expense-send-mail/{expense_id}', [App\Http\Controllers\ExpensesController::class, 'executionMxpenseMendMail'])->name('execution-expense-send-mail');

Route::any('/execution-expense-card-edit/{expense_id}', [App\Http\Controllers\ExpensesController::class, 'executionExpenseCardEdit'])->name('execution-expense-card-edit');

Route::any('/execution-expense-summary-list', [App\Http\Controllers\ExpensesController::class, 'excutionExpenseSummaryList'])->name('execution-expense-summary-list');

Route::any('/execution-expense-summary-list-send-mail', [App\Http\Controllers\ExpensesController::class, 'executionExpenseSummaryListSendMail'])->name('execution-expense-summary-list');

Route::post('/company-by-project', [App\Http\Controllers\ExpensesController::class, 'companyByProject'])->name('company-by-project');


Route::any('/cost-centre-list', [App\Http\Controllers\BudgetController::class, 'costCentreList'])->name('cost-centre-list');
Route::any('/budget-project-list', [App\Http\Controllers\BudgetController::class, 'budgetsProjectList'])->name('budget-project-list');
Route::get('/budget-export',[App\Http\Controllers\BudgetController::class,'budgetExport'])->name('budget.export');
Route::post('/budget-import',[App\Http\Controllers\BudgetController::class,'importBudget'])->name('budget-import');

Route::get('/user-export',[App\Http\Controllers\UsersController::class,'userExport'])->name('user.export');
Route::get('/company-export',[App\Http\Controllers\UsersController::class,'companyExport'])->name('company.export');
Route::get('/account-export',[App\Http\Controllers\BudgetController::class,'accountExport'])->name('account.export');
Route::get('/cost-center-export',[App\Http\Controllers\BudgetController::class,'costCenterExport'])->name('cost.center.export');
Route::get('/expense-type-export',[App\Http\Controllers\BudgetController::class,'expenseTypeExport'])->name('expense.type.export');
Route::get('/business-line-project-export',[App\Http\Controllers\BudgetController::class,'businessLineProjectExport'])->name('business.line.project.export');

Route::any('/get-project-list-by-company',[App\Http\Controllers\BudgetController::class,'getProjectByCompany'])->name('get-project-list-by-company');

Route::any('/expense-type-list', [App\Http\Controllers\BudgetController::class, 'expenseTypeList'])->name('expense-type-list');

Route::any('/get-business-line', [App\Http\Controllers\BudgetController::class, 'getBusinessLine'])->name('get-business-line');


//Update User Details
Route::post('/forget_password', [App\Http\Controllers\ForgotController::class, 'forget_password']);
Route::any('/reset-password/{token}', [App\Http\Controllers\ForgotController::class, 'resetPassword']);


/*Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');*/

Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
