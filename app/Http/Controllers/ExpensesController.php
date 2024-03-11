<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company; 
use App\Models\Supplier; 
use App\Models\Expensetype; 
use App\Models\Dtetype;
use App\Models\Organizationtype;
use App\Models\Service;
use App\Models\Resource;
use App\Models\Execution;
use App\Models\Execution_resource;
use App\Models\Time;
use App\Models\Businessline;
use App\Models\Expense_source;
use App\Models\Payment_status;
use App\Models\Expense;
use App\Models\ExpenseExecutionResource;
use App\Models\ExpenseNormal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; 
use App\Exports\ExportSupplier;
use App\Exports\ExportService;
use App\Exports\ExportResource;
use App\Exports\ExportExecutionResource;
use App\Exports\ExportExecutionExpense;
use App\Exports\ExportSoftland;
use DB;
use DataTables;
use Excel;
use Mail;


class ExpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }    

    public function supplierList(Request $request){
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Supplier::orderBy('name', 'ASC')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('status'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['status']), Str::lower($request->get('status'))) ? true : false;
                    });
                }
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->supplier_id.'" class="btn btn-primary ri-edit-2-line update"> Edit</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {
            $request->validate([  
                'company_id' => 'required',
                'organization_type_id' => 'required',
                'name' => 'required',
                'rut' => 'required|chilean_rut',
                'contact_name' => 'required',
                'contacts_email' => 'required',
                'dte_type_id' => 'required',
            ]);

            Supplier::create([ 
                "company_id"=>  $request->company_id, 
                "organization_type_id"=>  $request->organization_type_id, 
                "name"=>  $request->name, 
                "rut"=>  $request->rut, 
                "contact_name"=>  $request->contact_name, 
                "contacts_email"=>  $request->contacts_email, 
                "dte_type_id"=>  $request->dte_type_id, 
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Supplier::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Supplier not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $request->validate([  
                'company_id' => 'required',
                'organization_type_id' => 'required',
                'name' => 'required',
                'rut' => 'required|chilean_rut',
                'contact_name' => 'required',
                'contacts_email' => 'required',
                'dte_type_id' => 'required',
            ]);

            $resultUpdate = Supplier::find($request->supplier_id);
            $resultUpdate->company_id = $request->company_id; 
            $resultUpdate->organization_type_id = $request->organization_type_id; 
            $resultUpdate->name = $request->name; 
            $resultUpdate->rut = $request->rut; 
            $resultUpdate->contact_name = $request->contact_name; 
            $resultUpdate->contacts_email = $request->contacts_email; 
            $resultUpdate->dte_type_id = $request->dte_type_id; 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Supplier::find($request->id); 
            $dele->delete();
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $organizationtype = Organizationtype::orderBy('organization_type_id','ASC')->get();
        $dtetype = Dtetype::orderBy('dte_type_id','ASC')->get();
        return view('expenses.supplierlist',compact('companyList','organizationtype','dtetype'));
    } 

    public function supplierExport(Request $request)
    {
        return Excel::download(new ExportSupplier($request), 'supplierList.xlsx');
    }

    public function serviceList(Request $request){
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Service::leftjoin('tbl_expense_type','tbl_expense_type.expense_type_id','=','tbl_service.expense_type_id')->orderBy('tbl_service.name', 'ASC')
            ->select('tbl_service.*',
                DB::raw("CONCAT(tbl_service.expense_type_id, ' ', tbl_expense_type.name) AS expense_type")
            )->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('status'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['status']), Str::lower($request->get('status'))) ? true : false;
                    });
                }
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->service_id.'" class="btn btn-primary ri-edit-2-line update"> Edit</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {
            $request->validate([  
                'company_id' => 'required', 
                'name' => 'required', 
                'expense_type_id' => 'required',
                'cost_per_unit' => 'required', 
            ]);

            Service::create([ 
                "company_id"=>  $request->company_id,  
                "name"=>  $request->name,  
                "expense_type_id"=>  $request->expense_type_id, 
                "cost_per_unit"=>  $request->cost_per_unit,  
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Service::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Service not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $request->validate([  
                'company_id' => 'required', 
                'name' => 'required', 
                'expense_type_id' => 'required',
                'cost_per_unit' => 'required', 
            ]);

            $resultUpdate = Service::find($request->service_id);
            $resultUpdate->company_id = $request->company_id;  
            $resultUpdate->name = $request->name; 
            $resultUpdate->expense_type_id = $request->expense_type_id; 
            $resultUpdate->cost_per_unit = $request->cost_per_unit;  
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Service::find($request->id); 
            $dele->delete();
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $expensetypeList = Expensetype::orderBy('name','ASC')->where('status',1)->get(); 
        return view('expenses.servicelist',compact('companyList','expensetypeList'));
    } 

    public function serviceExport(Request $request)
    {
        return Excel::download(new ExportService($request), 'serviceList.xlsx');
    }
    public function resourceList(Request $request){
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Resource::leftjoin('tbl_supplier','tbl_supplier.supplier_id','=','tbl_resource.supplier_id')->orderBy('tbl_resource.name', 'ASC')
            ->select('tbl_resource.*','tbl_supplier.name as supplier_name')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('status'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['status']), Str::lower($request->get('status'))) ? true : false;
                    });
                }
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->resource_id.'" class="btn btn-primary ri-edit-2-line update"> Edit</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {
            $request->validate([  
                'company_id' => 'required', 
                'supplier_id' => 'required',
                'name' => 'required',
            ]);

            Resource::create([ 
                "company_id"=>  $request->company_id,  
                "supplier_id"=>  $request->supplier_id, 
                "name"=>  $request->name,  
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Resource::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Resource not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $request->validate([  
                'company_id' => 'required', 
                'supplier_id' => 'required',
                'name' => 'required', 
            ]);

            $resultUpdate = Resource::find($request->resource_id);
            $resultUpdate->company_id = $request->company_id;  
            $resultUpdate->name = $request->name; 
            $resultUpdate->supplier_id = $request->supplier_id; 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Resource::find($request->id); 
            $dele->delete();
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $supplierList = Supplier::orderBy('name','ASC')->where('status',1)->get(); 
        return view('expenses.resourcelist',compact('companyList','supplierList'));
    }

    public function executionCardList(Request $request){
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Execution::leftJoin('tbl_project', 'tbl_project.project_id', '=', 'tbl_execution.project_id')
            ->leftJoin('tbl_companies', 'tbl_companies.company_id', '=', 'tbl_execution.company_id')
            ->select(
                'tbl_execution.*',
                'tbl_companies.name as company_name',
                'tbl_project.name as project',
                DB::raw('(SELECT SUM(tbl_execution_resource.qty) FROM tbl_execution_resource WHERE tbl_execution_resource.execution_id = tbl_execution.execution_id) AS totalAmt')
            )
            ->get();

            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('status'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['status']), Str::lower($request->get('status'))) ? true : false;
                    });
                }
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->execution_id.'" class="btn btn-primary ri-edit-2-line update"> Edit</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {

            $request->validate([  
                'company_id' => 'required', 
                'project_id' => 'required',
                'date' => 'required', 
            ]);

            $execution = Execution::create([ 
                "company_id"=>  $request->company_id,  
                "project_id"=>  $request->project_id, 
                "date"=>  $request->date,
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 

            if($execution->execution_id){ 
                if(isset($_POST['resource_id']) && !empty($_POST['resource_id'])){
                    foreach ($_POST['resource_id'] as $key => $value) {
                        Execution_resource::create([ 
                            "execution_id"=>  $execution->execution_id,  
                            "resource_id"=>  $value,  
                            "service_id"=>  $request->service_id[$key], 
                            "qty"=>  $request->qty[$key], 
                            "time_id"=>  $request->time_id[$key], 
                            "creator_user_id"=> Auth::user()->user_id, 
                            "status"=>  ($request->post('status') ? 1 : 0)
                        ]); 
                    }
                } 
            }
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Execution::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Execution not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $request->validate([  
                'company_id' => 'required', 
                'project_id' => 'required',
                'date' => 'required', 
            ]);

            $resultUpdate = Execution::find($request->execution_id);
            $resultUpdate->company_id = $request->company_id;  
            $resultUpdate->project_id = $request->project_id; 
            $resultUpdate->date = $request->date; 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Execution::find($request->id); 
            $dele->delete();
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get(); 
        $resourceList = Resource::orderBy('name','ASC')->where('status',1)->get(); 
        $serviceList = Service::orderBy('name','ASC')->where('status',1)->get(); 
        $timeList = Time::orderBy('name','ASC')->get(); 
        return view('expenses.executioncard',compact('companyList','resourceList','serviceList','timeList'));
    } 

    public function resourceExport(Request $request)
    {
        return Excel::download(new ExportResource($request), 'resourceList.xlsx');
    }


    public function executionResourceList(Request $request){
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Execution_resource::
            leftjoin('tbl_resource','tbl_resource.resource_id','=','tbl_execution_resource.resource_id')
            ->leftjoin('tbl_service','tbl_service.service_id','=','tbl_execution_resource.service_id')
            ->leftjoin('tbl_project','tbl_project.project_id','=','tbl_execution_resource.project_id')
            ->orderBy('tbl_execution_resource.execution_resource_id', 'ASC')
            ->select('tbl_execution_resource.*','tbl_resource.name as resource','tbl_service.name as service','tbl_project.name as project')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('status'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['status']), Str::lower($request->get('status'))) ? true : false;
                    });
                }
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->execution_resource_id.'" class="btn btn-primary ri-edit-2-line update"> Edit</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {
            $request->validate([  
                'company_id' => 'required', 
                'project_id' => 'required',
                'date' => 'required',
                'resource_id' => 'required',
                'service_id' => 'required',
                'qty' => 'required',
                'time_id' => 'required',
            ]);

            Execution_resource::create([ 
                "company_id"=>  $request->company_id,  
                "project_id"=>  $request->project_id, 
                "date"=>  $request->date, 
                "resource_id"=>  $request->resource_id,  
                "service_id"=>  $request->service_id,  
                "qty"=>  $request->qty,  
                "time_id"=>  $request->time_id,  
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Execution_resource::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Execution resource not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $request->validate([  
                'company_id' => 'required', 
                'project_id' => 'required',
                'date' => 'required',
                'resource_id' => 'required',
                'service_id' => 'required',
                'qty' => 'required',
                'time_id' => 'required',
            ]);

            $resultUpdate = Execution_resource::find($request->execution_resource_id);
            $resultUpdate->company_id = $request->company_id;  
            $resultUpdate->project_id = $request->project_id; 
            $resultUpdate->date = $request->date; 
            $resultUpdate->resource_id = $request->resource_id; 
            $resultUpdate->service_id = $request->service_id; 
            $resultUpdate->qty = $request->qty; 
            $resultUpdate->time_id = $request->time_id; 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Execution_resource::find($request->id); 
            $dele->delete();
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $resourceList = Resource::orderBy('name','ASC')->where('status',1)->get(); 
        $serviceList = Service::orderBy('name','ASC')->where('status',1)->get(); 
        $timeList = Time::orderBy('name','ASC')->get(); 
        return view('expenses.executionlist',compact('companyList','resourceList','serviceList','timeList'));
    } 

    public function executionResourceExport(Request $request)
    {
        return Excel::download(new ExportExecutionResource($request), 'executionList.xlsx');
    }
    public function exportExecutionExpenses(Request $request)
    {
        return Excel::download(new ExportExecutionExpense($request), 'expenseList.xlsx');
    }
    public function exportExportSoftland(Request $request)
    {
        return Excel::download(new ExportSoftland($request), 'expense_softland_list.xlsx');
    }

    public function expensesList(Request $request){ 
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $company_id = $request->input('company_id');
            $project_id = $request->input('project_id');
            $supplier_id = $request->input('supplier_id');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $data = Expense::leftJoin('tbl_project', 'tbl_project.project_id', '=', 'tbl_expense.project_id')
            ->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_expense.supplier_id')
            ->leftJoin('tbl_expense_source', 'tbl_expense_source.expense_source_id', '=', 'tbl_expense.source_id')
            ->leftJoin('tbl_expense_normal', 'tbl_expense.expense_id', '=', 'tbl_expense_normal.expense_id')
            ->leftJoin('tbl_expense_type', 'tbl_expense_type.expense_type_id', '=', 'tbl_expense_normal.expense_type_id')
            ->leftJoin('tbl_dte_type', 'tbl_dte_type.dte_type_id', '=', 'tbl_expense.dte_type_id')
            ->leftJoin('tbl_payment_status', 'tbl_payment_status.payment_status_id', '=', 'tbl_expense.payment_status_id')
            ->leftJoin(DB::raw('(SELECT tbl_expense_execution_resource.expense_id,
                SUM(tbl_execution_resource.qty * tbl_service.cost_per_unit) AS total,
                SUM(tbl_execution_resource.qty) AS qtys
                FROM tbl_expense_execution_resource
                LEFT JOIN tbl_execution_resource ON tbl_execution_resource.execution_resource_id = tbl_expense_execution_resource.execution_resource_id
                LEFT JOIN tbl_service ON tbl_service.service_id = tbl_execution_resource.service_id
                GROUP BY tbl_expense_execution_resource.expense_id) AS subquery'), function($join) {
                $join->on('tbl_expense.expense_id', '=', 'subquery.expense_id');
            })
            ->select('tbl_expense.*', 'tbl_project.name as project', 'tbl_supplier.name as supplier_name', 'tbl_supplier.rut', 'tbl_expense_source.name as source', 'tbl_expense_type.name as expense_type', 'tbl_dte_type.name as dte_type', 'tbl_payment_status.name as payment_status', 'tbl_expense_normal.expense_normal_id', 'tbl_expense_normal.amount', 'tbl_expense_normal.qty',
                DB::raw('tbl_expense_normal.amount * tbl_expense_normal.qty AS totalAmt'), 'subquery.total', 'subquery.qtys');
            
            if ($company_id) {
                $data->where('tbl_expense.company_id', $company_id);
            }

            if ($project_id) {
                $data->where('tbl_expense.project_id', $project_id);
            }
            if ($supplier_id) {
                $data->where('tbl_expense.supplier_id', $supplier_id);
            }

            if ($fromDate && $toDate) {
                $data->whereBetween('tbl_expense.date', [$fromDate, $toDate]);
            }

            $datas = $data->get();
            return Datatables::of($datas)
            ->addColumn('action', function($row){ 
                if(!empty($row->expense_normal_id)){
                    $btn = '<a href="'.url('/').'/normal-expense-card-edit/'.$row->expense_id.'" class="btn btn-primary ri-edit-2-line update"> Edit normal expense</a>';     
                }else{
                    $btn = '<a href="'.url('/').'/execution-expense-card-edit/'.$row->expense_id.'" class="btn btn-primary ri-edit-2-line update"> Edit execution expense</a>
                    <a href="'.url('/').'/execution-expense-send-mail/'.$row->expense_id.'" class="btn btn-primary ri-send-plane-fill"> Send to supplier</a>
                    '; 

                } 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        }
        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        return view('expenses.expenseslist',compact('companyList'));
    }

    public function executionExpenseCard(Request $request){
        if($request->post()){ 
            $request->validate([
                'company_id' => 'required',
                'project_id' => 'required',
                'supplier_id' => 'required', 
                'date' => 'required', 
                'purchase_order_code' => 'required',
                'document' => 'required', 
                'dte_type_id' => 'required',
                'payment_status_id' => 'required', 
            ]);
            //print_r($_POST); die;
            if(!isset($request->execution_resource_id) && empty($request->execution_resource_id)){
                return redirect('execution-expenses-card')->with('error_msg',__('Please add at least one SELECTED EXECUTION to the table before submitting.'));
            }


            $document = $request->file('document');
            $documents = time().'_'.$document->getClientOriginalName();  
            $request->document->move(public_path('images/execution_expense'), $documents);

            $results = Expense::create([
                "company_id"=>  $request->company_id,
                "project_id"=>  $request->project_id,
                "supplier_id"=>  $request->supplier_id,  
                "source_id"=>  4,  

                "purchase_order_code"=>  $request->purchase_order_code,   
                "document"=>  $documents,   
                "date"=>  $request->date,   
                "dte_type_id"=>  $request->dte_type_id,   
                "payment_status_id"=>  $request->payment_status_id,  
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]);    

            if(!is_null($results->expense_id)) { 
                foreach ($request->execution_resource_id as $key => $value) {
                    ExpenseExecutionResource::create([
                        "expense_id"=>  $results->expense_id,
                        "execution_resource_id"=>  $value,
                        "sent_date"=>  $request->date,
                        "creator_user_id"=> Auth::user()->user_id, 
                        "status"=>  1
                    ]);
                }
                return redirect('expenseslist')->with('success_msg','Execution expense card added successfully.');
            } else { 
                return redirect('expenseslist')->with('error_msg',__('failed to add.'));
            }
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $expenseSourceList = Expense_source::where('shows_normal_expense_card',1)->get();
        $dteTypeList = Dtetype::all();
        $paymentStatus = Payment_status::all();


        $newInsertID = DB::table('INFORMATION_SCHEMA.TABLES')->select('auto_increment')->where('table_name', 'tbl_expense')->value('auto_increment');
        return view('expenses.execution_expense_card',compact('newInsertID','companyList','expenseSourceList','dteTypeList','paymentStatus'));
    }

    public function executionExpenseCardEdit(Request $request,$expense_id){  
        if($request->post()){ 
            $request->validate([
                'company_id' => 'required',
                'project_id' => 'required',
                'supplier_id' => 'required',
                'date' => 'required', 
                'purchase_order_code' => 'required', 
                'source_id' => 'required',
                'dte_type_id' => 'required',
                'payment_status_id' => 'required', 
            ]);


            $resultUpdate = Expense::find($expense_id);

            $document = $request->file('document');
            if($document){ 
                $documents = time().'_'.$document->getClientOriginalName();  
                $request->document->move(public_path('images/execution_expense'), $documents);
                $resultUpdate->document = $documents; 
            }

            $resultUpdate->company_id = $request->company_id;
            $resultUpdate->project_id = $request->project_id;
            $resultUpdate->supplier_id = $request->supplier_id;
            $resultUpdate->source_id = 4;
            $resultUpdate->purchase_order_code = $request->purchase_order_code;
            $resultUpdate->date = $request->date;
            $resultUpdate->dte_type_id = $request->dte_type_id;
            $resultUpdate->payment_status_id = $request->payment_status_id;
            $resultUpdate->status = ($request->post('status') ? 1 : 0);

            if($resultUpdate->save()) { 
                return redirect('expenseslist')->with('success_msg','Execution expense card update successfully.');
            } else { 
                return redirect('expenseslist')->with('error_msg',__('failed to add.'));
            }
        } 

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $expenseSourceList = Expense_source::where('shows_normal_expense_card',1)->get();
        $dteTypeList = Dtetype::all();
        $paymentStatus = Payment_status::all();

        $executionExpenseList = Expense::find($expense_id);  

        return view('expenses.execution_expense_card_edit',compact('executionExpenseList','companyList','expenseSourceList','dteTypeList','paymentStatus'));
    }

    public function expenseNormalCard(Request $request){  
        if($request->post()){  
            $request->validate([
                'company_id' => 'required',
                'project_id' => 'required',
                'supplier_id' => 'required',
                'expense_type_id' => 'required',
                'date' => 'required',
                'amount' => 'required',
                'qty' => 'required',
                'purchase_order_code' => 'required',
                'document' => 'required',
                'source_id' => 'required',
                'dte_type_id' => 'required',
                'payment_status_id' => 'required', 
            ]);


            $document = $request->file('document');
            $documents = time().'_'.$document->getClientOriginalName();  
            $request->document->move(public_path('images/normal-expense'), $documents);

            $results = Expense::create([
                "company_id"=>  $request->company_id,
                "project_id"=>  $request->project_id,
                "supplier_id"=>  $request->supplier_id,  
                "source_id"=> ($request->source_id ? $request->source_id : 0), 
                "purchase_order_code"=>  $request->purchase_order_code,   
                "document"=>  $documents,   
                "date"=>  $request->date,   
                "dte_type_id"=>  $request->dte_type_id,   
                "payment_status_id"=>  $request->payment_status_id,  
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]);    

            if(!is_null($results->expense_id)) { 

                $results = ExpenseNormal::create([
                    "expense_id"=>  $results->expense_id,
                    "expense_type_id"=>  $request->expense_type_id,
                    "amount"=>  $request->amount,   
                    "qty"=>  $request->qty,   
                    "creator_user_id"=> Auth::user()->user_id, 
                    "status"=>  ($request->post('status') ? 1 : 0)
                ]);  
                
                return redirect('expenseslist')->with('success_msg','Normal expense card added successfully.');
            } else { 
                return redirect('expenseslist')->with('error_msg',__('failed to add.'));
            }
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $expenseSourceList = Expense_source::where('shows_normal_expense_card',1)->get();
        $dteTypeList = Dtetype::all();
        $paymentStatus = Payment_status::all();
        $newInsertID = DB::table('INFORMATION_SCHEMA.TABLES')->select('auto_increment')->where('table_name', 'tbl_expense_normal')->value('auto_increment');
        return view('expenses.normal_expense_card',compact('newInsertID','companyList','expenseSourceList','dteTypeList','paymentStatus'));
    }

    public function expenseNormalCardEdit(Request $request,$expense_id){  
        if($request->post()){ 
            $request->validate([
                'company_id' => 'required',
                'project_id' => 'required',
                'supplier_id' => 'required',
                'expense_type_id' => 'required',
                'date' => 'required',
                'amount' => 'required',
                'qty' => 'required',
                'purchase_order_code' => 'required', 
                'source_id' => 'required',
                'dte_type_id' => 'required',
                'payment_status_id' => 'required', 
            ]);


            $resultUpdate = Expense::find($expense_id);

            $document = $request->file('document');
            if($document){ 
                $documents = time().'_'.$document->getClientOriginalName();  
                $request->document->move(public_path('images/normal-expense'), $documents);
                $resultUpdate->document = $documents; 
            }

            $resultUpdate->company_id = $request->company_id;
            $resultUpdate->project_id = $request->project_id;
            $resultUpdate->supplier_id = $request->supplier_id;
            $resultUpdate->source_id = $request->source_id;
            $resultUpdate->purchase_order_code = $request->purchase_order_code;
            $resultUpdate->date = $request->date;
            $resultUpdate->dte_type_id = $request->dte_type_id;
            $resultUpdate->payment_status_id = $request->payment_status_id;
            $resultUpdate->status = ($request->post('status') ? 1 : 0);

            if($resultUpdate->save()) { 

                $expenseNormal = ExpenseNormal::find($request->expense_normal_id);
                $expenseNormal->update([
                    "expense_type_id" => $request->expense_type_id,
                    "amount" => $request->amount,
                    "qty" => $request->qty,
                    "status" => ($request->post('status') ? 1 : 0)
                ]); 
                
                return redirect('expenseslist')->with('success_msg','Normal expense card update successfully.');
            } else { 
                return redirect('expenseslist')->with('error_msg',__('failed to add.'));
            }
        } 

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $expenseSourceList = Expense_source::where('shows_normal_expense_card',1)->get();
        $dteTypeList = Dtetype::all();
        $paymentStatus = Payment_status::all();

        $normalExpenseList = ExpenseNormal::where('tbl_expense_normal.expense_id',$expense_id)
        ->join('tbl_expense', 'tbl_expense.expense_id', '=', 'tbl_expense_normal.expense_id')
        ->select('tbl_expense.*','tbl_expense_normal.expense_normal_id','tbl_expense_normal.expense_type_id','tbl_expense_normal.amount','tbl_expense_normal.qty')
        ->first();  

        return view('expenses.normal_expense_card_edit',compact('normalExpenseList','companyList','expenseSourceList','dteTypeList','paymentStatus'));
    }

    public function companyByProject(Request $request)
    {  
        $getBusinessID = Businessline::where('company_id',$request->company_id)->get();
        $businessID = [];

        foreach ($getBusinessID as $key => $value) {
            $businessID[] =    $value->business_line_id;
        }

        $getProjectList = Project::WhereIn('business_line_id',$businessID)->where('status',1)->get();
        $data = "";
        $data .= '<option value="">Project</option>';
        foreach ($getProjectList as $key => $values) { 
            $data .= '<option value='.$values->project_id.'>'.$values->name.'</option>';
        }

        $getSupplier = Supplier::where('company_id',$request->company_id)->where('status',1)->get();

        $dataSupplier = '';
        $dataSupplier .= '<option value="">Supplier</option>';
        foreach ($getSupplier as $key => $values) { 
            $dataSupplier .= '<option value='.$values->supplier_id.'>'.$values->name.'</option>';
        }

        $getExpenseType = Expensetype::where('company_id',$request->company_id)->where('status',1)->get();

        $dataExpenseType = '';
        //$dataExpenseType .= '<option value="">Expense Type</option>';
        foreach ($getExpenseType as $key => $values) { 
            $dataExpenseType .= '<option value='.$values->expense_type_id.'>'.$values->expense_type_id.' '.$values->name.'</option>';
        }



        $getResource = Resource::where('company_id',$request->company_id)->where('status',1)->get();

        $dataResource = '';
        //$dataExpenseType .= '<option value="">Expense Type</option>';
        foreach ($getResource as $key => $values) { 
            $dataResource .= '<option value='.$values->resource_id.'>'.$values->name.'</option>';
        }

        $getService = Service::where('company_id',$request->company_id)->where('status',1)->get();

        $dataService = '';
        //$dataExpenseType .= '<option value="">Expense Type</option>';
        foreach ($getService as $key => $values) { 
            $dataService .= '<option value='.$values->service_id.'>'.$values->name.'</option>';
        }

        return response()->json(['data'=>$data,'dataSupplier'=>$dataSupplier,'dataExpenseType'=>$dataExpenseType,'ResourceList'=>$dataResource,'ServiceList'=>$dataService]);
    }

    public function getExcutionResourceListBySupplier(Request $request){ 
        $excutionResouce = Resource::
        Join('tbl_execution_resource', 'tbl_execution_resource.resource_id', '=', 'tbl_resource.resource_id')
        ->leftJoin('tbl_execution', 'tbl_execution.execution_id', '=', 'tbl_execution_resource.execution_id')
        ->leftJoin('tbl_project', 'tbl_project.project_id', '=', 'tbl_execution.project_id')
        ->leftJoin('tbl_service', 'tbl_service.service_id', '=', 'tbl_execution_resource.service_id')
        ->leftJoin('tbl_expense_type', 'tbl_expense_type.expense_type_id', '=', 'tbl_service.expense_type_id')
        ->leftJoin('tbl_time', 'tbl_time.time_id', '=', 'tbl_execution_resource.time_id')
        ->select(
            'tbl_execution_resource.*',
            'tbl_project.name as project',
            'tbl_resource.*',
            'tbl_service.name as service',
            'tbl_service.cost_per_unit',
            'tbl_expense_type.expense_type_id as expense_type_id',
            'tbl_expense_type.name as expense_type',
            'tbl_time.name as time',
            'tbl_execution.date',
            DB::raw('tbl_execution_resource.qty * tbl_service.cost_per_unit AS total')
        )
        ->where('tbl_resource.company_id', $request->company_id)
        ->where('tbl_resource.supplier_id', $request->supplier_id)
        ->where('tbl_execution.project_id', $request->project_id)
        ->get();


        $bodyHtml = "";
        foreach ($excutionResouce as $key => $value) { 
            $bodyHtml .= "<tr>";
            $bodyHtml .= "<td><input type='hidden' name='execution_resource_id[]' value='".$value->execution_resource_id."'>".$value->execution_resource_id."<input type='hidden' name='first_table_movement[]' value='0'></td>";
            $bodyHtml .= "<td>".$value->project."</td>";
            $bodyHtml .= "<td>".$value->name."</td>";
            $bodyHtml .= "<td>".$value->service."</td>";
            $bodyHtml .= "<td>".$value->date."</td>";
            $bodyHtml .= "<td>".$value->time."</td>";
            $bodyHtml .= "<td>".$value->qty."</td>";
            $bodyHtml .= "<td>".$value->cost_per_unit."</td>";
            $bodyHtml .= "<td>".$value->total."</td>";
            $bodyHtml .= "<td>".$value->expense_type_id.' - '.$value->expense_type."</td>";
            $bodyHtml .= "<td><button type='button' class='moveToFirst btn btn-success'>+ Add</button></td>";
            $bodyHtml .= "</tr>"; 
        }
        return response()->json(['data'=>$bodyHtml]);
    }

    public function excutionExpenseSummaryList(Request $request){ 
        if($request->post()){   
            $company_id = $request->input('company_id'); 
            $supplier_id = $request->input('supplier_id');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $dataFetchExp = ExpenseExecutionResource::
            join('tbl_expense', 'tbl_expense.expense_id', '=', 'tbl_expense_execution_resource.expense_id') 
            ->leftjoin('tbl_execution_resource', 'tbl_expense_execution_resource.execution_resource_id', '=', 'tbl_execution_resource.execution_resource_id')
            ->leftjoin('tbl_execution', 'tbl_execution.execution_id', '=', 'tbl_execution_resource.execution_id')
            ->leftJoin('tbl_project', 'tbl_project.project_id', '=', 'tbl_execution.project_id')
            ->leftJoin('tbl_resource', 'tbl_resource.resource_id', '=', 'tbl_execution_resource.resource_id')
            ->leftJoin('tbl_service', 'tbl_service.service_id', '=', 'tbl_execution_resource.service_id')
            ->leftJoin('tbl_expense_type', 'tbl_expense_type.expense_type_id', '=', 'tbl_service.expense_type_id')
            ->leftJoin('tbl_time', 'tbl_time.time_id', '=', 'tbl_execution_resource.time_id')
            ->select(
                'tbl_execution_resource.*', 
                'tbl_expense_execution_resource.expense_execution_resource_id', 
                'tbl_project.name as project',
                'tbl_resource.name as resource',
                'tbl_service.name as service',
                'tbl_service.cost_per_unit',
                'tbl_expense_type.expense_type_id',
                'tbl_expense_type.name as expense_type',
                'tbl_time.name as TIME',
                'tbl_execution.date',
                DB::raw('tbl_execution_resource.qty * tbl_service.cost_per_unit AS total') 
            );
            if ($company_id) {
                $dataFetchExp->where('tbl_expense.company_id', $company_id);
            }

            if ($supplier_id) {
                $dataFetchExp->where('tbl_expense.supplier_id', $supplier_id);
            }

            if ($fromDate && $toDate) {
                $dataFetchExp->whereBetween('tbl_expense.date', [$fromDate, $toDate]);
            }

            $dataFetchExp = $dataFetchExp->get();  

            $bodyHtml = "";

            foreach ($dataFetchExp as $key => $value) {  
                $bodyHtml .= "<tr>";
                $bodyHtml .= "<td><input type='hidden' name='execution_resource_id[]' value='".$value->expense_execution_resource_id."'>".$value->expense_execution_resource_id."</td>";
                $bodyHtml .= "<td>".$value->project."</td>";
                $bodyHtml .= "<td>".$value->resource."</td>";
                $bodyHtml .= "<td>".$value->service."</td>";
                $bodyHtml .= "<td>".$value->date."</td>";
                $bodyHtml .= "<td>".$value->TIME."</td>";
                $bodyHtml .= "<td>".$value->qty."</td>";
                $bodyHtml .= "<td>".$value->cost_per_unit."</td>";
                $bodyHtml .= "<td>".$value->total."</td>";
                $bodyHtml .= "<td>".$value->expense_type_id.' - '.$value->expense_type."</td>";
                $bodyHtml .= "<td><button type='button' class='removeRowBtn btn btn-danger'>X Remove</button></td>";
                $bodyHtml .= "</tr>"; 
            }
            return response()->json(['data'=>$bodyHtml]);
        }
        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        return view('expenses.execution_expense_summary_list',compact('companyList'));
    }
    public function executionMxpenseMendMail($expense_id)
    {
        $getExpenseExecutionResource = ExpenseExecutionResource::where('expense_id',$expense_id)->get();
        //print_r($getExpenseExecutionResource);
        foreach ($getExpenseExecutionResource as $key => $valuess) {

            $existingSentDate = $valuess->sent_date;
            $newDate = now()->toDateTimeString();
            $updatedSentDate = $existingSentDate ? "$existingSentDate,$newDate" : $newDate;
            DB::table('tbl_expense_execution_resource')
            ->where('expense_execution_resource_id', $valuess->expense_execution_resource_id) 
            ->update([
                'sent_date' => $updatedSentDate
            ]);
        } 
        $getExpense = Expense::
        leftJoin('tbl_companies', 'tbl_companies.company_id', '=', 'tbl_expense.company_id')
        ->leftJoin('tbl_dte_type', 'tbl_dte_type.dte_type_id', '=', 'tbl_expense.dte_type_id')
        ->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_expense.supplier_id')
        ->leftJoin('tbl_payment_status', 'tbl_expense.payment_status_id', '=', 'tbl_expense.payment_status_id')
        ->select('tbl_expense.*','tbl_companies.name as company_name',
            'tbl_supplier.name as supplier_name',
            'tbl_dte_type.name as dte_type', 
            'tbl_payment_status.name as payment_status')->where('expense_id',$expense_id)->first();

        $getSupplier = Supplier::where('supplier_id',$getExpense->supplier_id)->first();
        $getEmail = explode(',', $getSupplier->contacts_email);
        $dataFetchExp = ExpenseExecutionResource::query()
        ->join('tbl_execution_resource', 'tbl_expense_execution_resource.execution_resource_id', '=', 'tbl_execution_resource.execution_resource_id')
        ->leftJoin('tbl_execution', 'tbl_execution.execution_id', '=', 'tbl_execution_resource.execution_id')
        ->leftJoin('tbl_project', 'tbl_project.project_id', '=', 'tbl_execution.project_id')
        ->leftJoin('tbl_resource', 'tbl_resource.resource_id', '=', 'tbl_execution_resource.resource_id')
        ->leftJoin('tbl_service', 'tbl_service.service_id', '=', 'tbl_execution_resource.service_id')
        ->leftJoin('tbl_expense_type', 'tbl_expense_type.expense_type_id', '=', 'tbl_service.expense_type_id')
        ->leftJoin('tbl_time', 'tbl_time.time_id', '=', 'tbl_execution_resource.time_id')
        ->select(
            'tbl_execution_resource.*', 
            'tbl_project.name as project',
            'tbl_resource.name as resource',
            'tbl_service.name as service',
            'tbl_service.cost_per_unit',
            'tbl_expense_type.expense_type_id as expense_type_id',
            'tbl_expense_type.name as expense_type',
            'tbl_time.name as TIME',
            'tbl_execution.date',
            DB::raw('tbl_execution_resource.qty * tbl_service.cost_per_unit AS total') 
        )->where('expense_id', $expense_id)->get();

        foreach ($getEmail as $key => $value) {

            $documentPath = public_path('/images/execution_expense/'.$getExpense->document); 
            Mail::send('/emails/sendExpenseList', ['datalist' => $dataFetchExp,'expense'=>$getExpense], function($message) use($value,$getExpense,$documentPath){
                $message->to($value);
                $message->subject($getExpense->company_name.' | Execution expense id '.$getExpense->expense_id);
                
                // Add BCC recipient(s)
                $message->bcc('backup@hu-technology.com');
                // Attach the document
                $message->attach($documentPath, [
                    'as' => 'document.pdf',
                    'mime' => 'application/pdf',
                ]);
            });  
        } 

        $getMil = Expense::find($expense_id);

        if($getMil->sent_mail_check == "" || $getMil->sent_mail_check=0){
            $getMil->sent_mail_check = 1;
            $getMil->save();
        }

        return redirect('expenseslist')->with('success_msg','Mail send successfully.');
    }
    public function executionExpenseSummaryListSendMail(Request $request)
    {  
        $company = Company::where('company_id',$_POST['company_id'])->first();
        $supplier = Supplier::where('supplier_id',$_POST['supplier_id'])->first();
        $fromDate = date('d M Y',strtotime($_POST['fromDate']));
        $toDate = date('d M Y',strtotime($_POST['toDate']));
        
        Mail::send('/emails/sendExecutionExpenseSummary', ['datalist' => $_POST['allRowData'],'total'=>$_POST['sum'],'company'=>$company->name,'supplier'=>$supplier->name,'fromDate'=>$fromDate,'toDate'=>$toDate], function($message) use($company,$supplier,$fromDate,$toDate) {
                $message->to('amit.jangid@indiaresults.com');
                $message->subject($company->name.' | Execution expense summary from '.$fromDate.' '.$toDate);                
                // Add BCC recipient(s)
                //$message->bcc('backup@hu-technology.com');
            });  
        return true;
    }
}
