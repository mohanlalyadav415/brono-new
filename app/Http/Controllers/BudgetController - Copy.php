<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Businessline;
use App\Models\Company; 
use App\Models\Account; 
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


class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    public function projectlist(Request $request)
    { 
        $listProject = Businessline::orderBy('tbl_business_line.name', 'ASC')
        ->join('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
        ->select('tbl_business_line.*', 'c.name as company_name')
        ->get();  
        return view('budget.projectlist',compact('listProject'));
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
                    if (!empty($request->get('status'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) { 
                            return Str::contains(Str::lower($row['status']), Str::lower($request->get('status'))) ? true : false;
                        });
                    }

                })
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->business_line_id.'" class="btn btn-warning ri-edit-2-line update"> Edit</button>&nbsp;<button type="button" name="delete" id="'.$row->business_line_id.'" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>'; 
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
            ->addColumn('action', function($row){
                $btn = '<button type="button" name="update" id="'.$row->account_id.'" class="btn btn-warning ri-edit-2-line update"> Edit</button>&nbsp;<button type="button" name="delete" id="'.$row->account_id.'" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>'; 
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
        } 

        if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') { 
            Account::create([ 
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
            $resultUpdate->account_name = $request->account_name; 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);
            $resultUpdate->save();
        }

        if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
            $dele = Account::find($request->id); 
            $dele->delete();
        } 
        
        return view('budget.account_list');
    }

    public function deleteAccountCard($account_id)
    {
        $Account = Account::find($account_id);

        if($Account->delete()) { 
            return redirect('account_list')->with('success_msg','Account deleted successfully.');
        } else { 
            return redirect('account_list')->with('error_msg',__('failed to add.'));
        }
    }

}
