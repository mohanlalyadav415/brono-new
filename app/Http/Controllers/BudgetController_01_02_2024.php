<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Businessline;
use App\Models\Company; 
use App\Models\Account; 
use App\Models\Costcentre; 
use App\Models\Budgettype; 
use App\Models\MovementType; 
use App\Models\Month; 
use App\Models\Budget; 
use App\Models\Expensetype; 
use App\Models\Expensetypeproject; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Helpers\RutHelper;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use DataTables;
use Illuminate\Support\Str; 
use Excel;
use App\Imports\BudgetImport;
use App\Exports\ExportBudget;
use App\Exports\ExportAccount;
use App\Exports\ExportCostCenter;
use App\Exports\ExportExpenseType;
use App\Exports\ExportBusinessLineProject;


class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function projectlist(Request $request)
    {  
        $businesslineList = Businessline::orderBy('name', 'ASC')->where('status',1)->get();
        $companyList = Company::orderBy('name', 'ASC')->where('status',1)->get();

        if ($request->ajax() && $request->input('action') === 'listProjects') {
            $listProject = Businessline::orderBy('name', 'ASC')->get();
            $data = [];
            foreach ($listProject as $userData) { 
                $getProject = DB::table('tbl_project')
                ->where('business_line_id', $userData->business_line_id)->whereNull('deleted_at')
                ->get();

                $projectsID = '';
                $projectsName = '';
                $projectsStatus = '';
                $btn = '';

                foreach ($getProject as $project) {
                    $projectsID .= '<li>' . $project->project_id . '</li><br>';
                    $projectsName .= '<li>' . $project->name . '</li><br>';
                    $projectsStatus .= '<li><div class="col-md-6 position-relative form-check form-switch form-switch-lg"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" '.($project->status == 1 ? "checked" : ""). '></div></li><br>';
                    $btn .= '<a href="' . url("/project_card_edit/{$project->project_id}") . '" class="btn btn-primary btn-sm"><i class="ri-edit-2-line"></i> Edit</a><br><br>'; 

                    /*$btn .= '<a href="' . url("/project_card_edit/{$project->project_id}") . '" class="btn btn-primary btn-sm"><i class="ri-edit-2-line"></i> Edit</a>
                    <a href="' . url("/project_card_delete/{$project->project_id}") . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="ri-delete-bin-line"></i> Delete</a><br><br>'; */
                }

                $data[] = [
                    'business_line_id' => $userData->business_line_id,
                    'company_id' => $userData->company_id,
                    'name' => $userData->name,
                    'project_id' => '<ul>' . $projectsID . '</ul>',
                    'project_name' => '<ul>' . $projectsName . '</ul>',
                    'status' => '<ul>' . $projectsStatus . '</ul>',
                    'edit' => $btn,
                ];
            }

            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('name'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['name']), Str::lower($request->get('name'))) ? true : false;
                    });
                }
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                } 
            })
            ->make(true); 
        }

        return view('budget.projectlist',compact('businesslineList','companyList'));
    }
    public function projectCard(Request $request)
    {
        if($request->post()){  
            $request->validate([ 
                'name' => 'required',
                'business_line_id' => 'required'
            ]);

            $results = Project::create([ 
                "name"=>  $request->name,
                "business_line_id"=>  $request->business_line_id,   
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]);  

            if(!is_null($results->project_id)) {
                return redirect('projectlist')->with('success_msg','Project Card added successfully.');
            } else { 
                return redirect('project_card')->with('error_msg',__('failed to add.'));
            }
        } 

        $listBusiness = Businessline::orderBy('name', 'ASC')->where('status',1)->get(); 
        $newInsertID = DB::table('INFORMATION_SCHEMA.TABLES')->select('auto_increment')->where('table_name', 'tbl_project')->value('auto_increment');
        return view('budget.project_card',compact('newInsertID','listBusiness'));
    }

    public function projectCardEdit(Request $request,$project_id)
    {
        if($request->post()){  
            $request->validate([ 
                'name' => 'required',
                'business_line_id' => 'required'
            ]);

            $resultUpdate = Project::find($request->project_id);

            $resultUpdate->name = $request->name;
            $resultUpdate->business_line_id = $request->business_line_id;
            $resultUpdate->status = ($request->post('status') ? 1 : 0);

            if($resultUpdate->save()) { 
                return redirect('projectlist')->with('success_msg','Project card update successfully.');
            } 
        }

        $getProject = Project::where('project_id',$project_id)->first();
        $listBusiness = Businessline::orderBy('name', 'ASC')->where('status',1)->get(); 

        return view('budget.project_card_edit',compact('getProject','listBusiness'));
    }

    public function deleteprojectCard($user_id)
    {
        $project = Project::find($user_id);
        if($project->delete()) { 
            return redirect('projectlist')->with('success_msg','Project Card deleted successfully.');
        } else { 
            return redirect('projectlist')->with('error_msg',__('failed to add.'));
        }
    }


    public function BusinessLineList(Request $request)
    {
        $dataNameList = Businessline::orderBy('name', 'ASC')->get();
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Businessline::orderBy('tbl_business_line.name', 'ASC')
            ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
            ->select('tbl_business_line.*', 'c.name as company_name')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('name'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['name']), Str::lower($request->get('name'))) ? true : false;
                    });
                }
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }
                /*if (!empty($request->get('status'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['status']), Str::lower($request->get('status'))) ? true : false;
                    });
                }*/

            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->business_line_id.'" class="btn btn-primary ri-edit-2-line update"> Edit</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') { 
            Businessline::create([ 
                "name"=>  $request->name,
                "company_id"=>  $request->company_id,   
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Businessline::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Business line not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {

            $resultUpdate = Businessline::find($request->business_line_id); 
            $resultUpdate->name = $request->name;
            $resultUpdate->company_id = $request->company_id;
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Businessline::find($request->id); 
            $dele->delete();
        } 

        return view('budget.business_line',compact('dataNameList'));
    }

    public function deleteBusinessCard($line_id)
    {
        $business_card = Businessline::find($line_id);

        if($business_card->delete()) { 
            return redirect('business-line-list')->with('success_msg','Business line Card deleted successfully.');
        } else { 
            return redirect('business-line-list')->with('error_msg',__('failed to add.'));
        }
    }

    public function accountList(Request $request)
    {
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Account::orderBy('account_name', 'ASC')->get();
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
                $btn = '<button type="button" name="update" id="'.$row->account_id.'" class="btn btn-warning ri-edit-2-line update"> Edit</button>&nbsp;<button type="button" name="delete" id="'.$row->account_id.'" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') { 
            Account::create([ 
                "company_id"=>  $request->company_id, 
                "account_external_id"=>  $request->account_external_id, 
                "account_name"=>  $request->account_name, 
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Account::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Account not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $resultUpdate = Account::find($request->account_id); 
            $resultUpdate->account_external_id = $request->account_external_id; 
            $resultUpdate->company_id = $request->company_id; 
            $resultUpdate->account_name = $request->account_name; 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Account::find($request->id); 
            $dele->delete();
        } 
        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        return view('budget.account_list',compact('companyList'));
    } 

    public function costCentreList(Request $request)
    {
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Costcentre::orderBy('name', 'ASC')->get();
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
                $btn = '<button type="button" name="update" id="'.$row->cost_centre_id.'" class="btn btn-warning ri-edit-2-line update"> Edit</button>&nbsp;<button type="button" name="delete" id="'.$row->cost_centre_id.'" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') { 
            Costcentre::create([ 
                "cost_center_external_id"=>  $request->cost_center_external_id, 
                "company_id"=>  $request->company_id, 
                "name"=>  $request->name, 
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]); 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Costcentre::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Cost centre not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $resultUpdate = Costcentre::find($request->cost_center_id); 
            $resultUpdate->company_id = $request->company_id; 
            $resultUpdate->cost_center_external_id = $request->cost_center_external_id; 
            $resultUpdate->name = $request->name; 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Costcentre::find($request->id); 
            $dele->delete();
        } 

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        return view('budget.cost_center_list',compact('companyList'));
    }

    public function budgetsProjectList(Request $request)
    {
        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 
            $data = Budget::orderBy('budget_id', 'DESC')
            ->Leftjoin('tbl_month as M', 'M.month_id', '=', 'tbl_budget.month_id')
            ->Leftjoin('tbl_expense_type as E', 'E.expense_type_id', '=', 'tbl_budget.expense_type_id')
            ->select('tbl_budget.*', 'M.name as month_name','E.name as expense_name')
            ->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }
                if (!empty($request->get('project_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['project_id']), Str::lower($request->get('project_id'))) ? true : false;
                    });
                }
                if (!empty($request->get('budget_type_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['budget_type_id']), Str::lower($request->get('budget_type_id'))) ? true : false;
                    });
                }
                if (!empty($request->get('expense_type_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['expense_type_id']), Str::lower($request->get('expense_type_id'))) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->budget_id.'" class="btn btn-warning ri-edit-2-line update"> Edit</button>&nbsp;<button type="button" name="delete" id="'.$row->budget_id.'" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') { 

            $request->validate([ 
                'amount' => 'required|numeric', 
                'qty' => 'required|numeric', 
            ]);
            Budget::create([ 
                "company_id"=>  ($request->company_id ? $request->company_id : 0) , 
                "project_id"=>  ($request->project_id ? $request->project_id : 0) , 
                "budget_type_id"=>  ($request->budget_type_id ? $request->budget_type_id : 0) , 
                "expense_type_id"=>  ($request->expense_type_id ? $request->expense_type_id : 0) ,   
                "movement_type_id"=>  ($request->movement_type_id ? $request->movement_type_id : 0) ,   
                "year"=>  ($request->year ? $request->year : 0) ,   
                "month_id"=>  ($request->month_id ? $request->month_id : 0) ,   
                "amount"=>  ($request->amount ? $request->amount : 0) ,   
                "qty"=>  ($request->qty ? $request->qty : 0) ,   
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]);
            return 0; 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Budget::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Cost centre not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $request->validate([ 
                'amount' => 'required|numeric', 
                'qty' => 'required|numeric', 
            ]);
            $resultUpdate = Budget::find($request->budget_id); 
            $resultUpdate->company_id = ($request->company_id ? $request->company_id : 0); 
            $resultUpdate->project_id = ($request->project_id ? $request->project_id : 0); 
            $resultUpdate->budget_type_id = ($request->budget_type_id ? $request->budget_type_id : 0); 
            $resultUpdate->expense_type_id = ($request->expense_type_id ? $request->expense_type_id : 0); 
            $resultUpdate->movement_type_id = ($request->expense_type_id ? $request->movement_type_id : 0); 
            $resultUpdate->year = ($request->year ? $request->year : 0); 
            $resultUpdate->month_id = ($request->month_id ? $request->month_id : 0); 
            $resultUpdate->amount = ($request->amount ? $request->amount : 0); 
            $resultUpdate->qty = ($request->qty ? $request->qty : 0); 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Budget::find($request->id); 
            $dele->delete();
        } 

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $projectList = Project::orderBy('name','ASC')->where('status',1)->get();
        $budgetTypeList = Budgettype::orderBy('name','ASC')->get();
        $expenseTypeList = Expensetype::orderBy('name','ASC')->get();
        $movementList = MovementType::orderBy('name','ASC')->get();
        $monthList = Month::all();

        return view('budget.budget_project_list',compact('companyList','projectList','budgetTypeList','movementList','monthList','expenseTypeList'));
    }

    public function expenseTypeList(Request $request)
    {

        if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') { 

            $data = Expensetype::orderBy('expense_type_id', 'DESC')
            ->leftJoin('tbl_account as a', 'a.account_id', '=', 'tbl_expense_type.account_debit_id')
            ->leftJoin('tbl_account as b', 'b.account_id', '=', 'tbl_expense_type.account_credit_id')
            ->leftJoin('tbl_cost_centre as C', 'C.cost_centre_id', '=', 'tbl_expense_type.cost_centre_id')
            ->select('tbl_expense_type.*', 'a.account_name as debit_account_name', 'b.account_name as credit_account_name', 'C.name as cost_center_name')
            ->get();



            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) { 
                if (!empty($request->get('company_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['company_id']), Str::lower($request->get('company_id'))) ? true : false;
                    });
                }

                if (!empty($request->get('expense_type_id'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                        return Str::contains(Str::lower($row['expense_type_id']), Str::lower($request->get('expense_type_id'))) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->expense_type_id.'" class="btn btn-warning ri-edit-2-line update"> Edit</button>&nbsp;<button type="button" name="delete" id="'.$row->expense_type_id.'" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') { 

            Expensetype::create([ 
                "company_id"=>  ($request->company_id ? $request->company_id : 0) ,  
                "name"=>  ($request->name ? $request->name : "") , 
                "account_debit_id"=>  ($request->account_debit ? $request->account_debit : 0) ,   
                "account_credit_id"=>  ($request->account_credit ? $request->account_credit : 0) ,   
                "cost_centre_id"=>  ($request->cost_centre_id ? $request->cost_centre_id : 0) , 
                "all_projects"=>  2 , 
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]);
            return 0; 
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') { 
            $record = Expensetype::find($request->id);
            if (!$record) {
                return response()->json(['error' => 'Cost centre not found'], 404);
            }
            return response()->json($record);
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
            $resultUpdate = Expensetype::find($request->expense_type_id); 
            $resultUpdate->company_id = ($request->company_id ? $request->company_id : 0); 
            $resultUpdate->name = ($request->name ? $request->name : 0); 
            $resultUpdate->account_debit_id = ($request->account_debit ? $request->account_debit : 0); 
            $resultUpdate->account_credit_id = ($request->account_credit ? $request->account_credit : 0); 
            $resultUpdate->cost_centre_id = ($request->cost_centre_id ? $request->cost_centre_id : 0);  
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Expensetype::find($request->id); 
            $dele->delete();
        } 


        if(!empty($_POST['action']) && $_POST['action'] == 'addExpenseProject') {
            if(isset($request->project_checkbox) && !empty($request->project_checkbox)){ 

                DB::table('tbl_expense_type_project')->where('expense_type_id', $request->expense_project_type_id)->delete();
                
                $updExp = Expensetype::find($request->expense_project_type_id); 
                $updExp->all_projects = 0; 
                $updExp->save();

                foreach ($request->project_checkbox as $key => $value) {
                    Expensetypeproject::create([ 
                        "project_active_id"=> $value ,
                        "expense_type_id"=> $request->expense_project_type_id ,  
                        "creator_user_id"=> Auth::user()->user_id, 
                        "status"=> 1
                    ]);
                }    
            }
            return 0;
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'actionAllProject') {

            if(isset($request->company_id) && !empty($request->company_id)){ 

                $getBusinessID = Businessline::where('company_id',$request->company_id)->get();
                $businessID = [];
                foreach ($getBusinessID as $key => $valueA) {
                    $businessID[] =    $valueA->business_line_id;
                }

                $getProjectList = Project::WhereIn('business_line_id',$businessID)->get();

                if($request->checkboxVal == 1){
                    DB::table('tbl_expense_type_project')->where('expense_type_id', $request->expense_type_id)->delete();

                    foreach ($getProjectList as $key => $valueP) {
                        Expensetypeproject::create([ 
                            "project_active_id"=> $valueP->project_id ,
                            "expense_type_id"=> $request->expense_type_id ,  
                            "creator_user_id"=> Auth::user()->user_id, 
                            "status"=> 1
                        ]);
                    }

                    $updExp = Expensetype::find($request->expense_type_id); 
                    $updExp->all_projects = 1; 
                    $updExp->save();

                }else{
                    DB::table('tbl_expense_type_project')->where('expense_type_id', $request->expense_type_id)->delete();
                    $updExp = Expensetype::find($request->expense_type_id); 
                    $updExp->all_projects = 2; 
                    $updExp->save();
                }
            }
            return 0;
        }

        $companyList = Company::orderBy('name','ASC')->where('status',1)->get();
        $accountList = Account::orderBy('account_name','ASC')->where('status',1)->get();
        $costcentreList = Costcentre::orderBy('name','ASC')->get();
        $expensetypeList = Expensetype::orderBy('name','ASC')->get();

        return view('budget.expense_type_list',compact('companyList','accountList','costcentreList','expensetypeList'));
    }
    public function budgetExport(Request $request)
    {
        return Excel::download(new ExportBudget($request), 'BudgetProject.xlsx');
    } 

    public function importBudget(Request $request)
    { 
        $file = $request->file('file'); 
        Excel::import(new BudgetImport, $file); 
        return redirect()->back()->with('success', 'Budget data imported successfully.');
    }

    public function accountExport(Request $request)
    {
        return Excel::download(new ExportAccount($request), 'AccountList.xlsx');
    }
    public function costCenterExport(Request $request)
    {
        return Excel::download(new ExportCostCenter($request), 'CostCenterList.xlsx');
    }
    public function expenseTypeExport(Request $request)
    {
        return Excel::download(new ExportExpenseType($request), 'ExpenseTypeList.xlsx');
    }
    public function businessLineProjectExport(Request $request)
    {
        return Excel::download(new ExportBusinessLineProject($request), 'BusinessLineProjectList.xlsx');
    }

    public function getProjectByCompany(Request $request)
    { 
        $getBusinessID = Businessline::where('company_id',$request->company_id)->get();
        $company_name = Company::where('company_id',$request->company_id)->pluck('name');
        $businessID = [];
        foreach ($getBusinessID as $key => $value) {
            $businessID[] =    $value->business_line_id;
        }
        $getProjectList = Project::WhereIn('business_line_id',$businessID)->get();
        $data = "";
        $getexpense_type = Expensetypeproject::where('expense_type_id',$request->expense_type_id)->get();
        $selectID = [];
        foreach ($getexpense_type as $key => $valuess) {
            $selectID[] = $valuess->project_active_id;
        }
        

        foreach ($getProjectList as $key => $values) { 
            $isChecked = in_array($values->project_id, $selectID) ? 'checked' : '';
            $data .= '<input type="checkbox" name="project_checkbox['.$values->project_id.']" id="project_'.$values->project_id.'" value="'.$values->project_id.'" '.$isChecked.'> <label for="project_'.$values->project_id.'">'.$values->name.'</label>&nbsp;&nbsp;<br>';
        }
        return response()->json(['data'=>$data,'company_name'=>$company_name]);
    }
}
