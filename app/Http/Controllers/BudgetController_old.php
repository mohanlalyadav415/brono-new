<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Businessline;
use App\Models\Company; 
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
        //$listProject = Businessline::orderBy('tbl_business_line.name', 'ASC')->get();  

        $listProject = Businessline::orderBy('tbl_business_line.name', 'ASC')
        ->join('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
        ->select('tbl_business_line.*', 'c.name as company_name')
        ->get();  

        //$listUsers = User::orderBy('tbl_users.name', 'ASC')->get();
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

        /*$listBusiness = Businessline::orderBy('tbl_business_line.name', 'ASC')
        ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
        ->select('tbl_business_line.*', 'c.name as company_name')
        ->get();*/
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
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))){
                                return true;
                            }else if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
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

            /*$draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length");

            $search_arr = $request->get('search');
            $searchValue = $search_arr['value'];
            


            $totalRecords = Businessline::orderBy('tbl_business_line.name', 'ASC')
                ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
                ->select('tbl_business_line.*', 'c.name as company_name')
                ->count(); 

            if ($searchValue != '') {  

                $listBusiness = Businessline::orderBy('tbl_business_line.name', 'ASC')
                ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')->where('tbl_business_line.name', 'like', '%' . $searchValue . '%')->orWhere('c.name', 'like', '%' . $searchValue . '%')
                ->select('tbl_business_line.*', 'c.name as company_name')
                ->skip($start)->take($rowperpage)->get();



                $totalRecordswithFilter = Businessline::orderBy('tbl_business_line.name', 'ASC')
                ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')->where('tbl_business_line.name', 'like', '%' . $searchValue . '%')
                ->select('tbl_business_line.*', 'c.name as company_name')->count();

            }else{

                $listBusiness = Businessline::orderBy('tbl_business_line.name', 'ASC')
                ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
                ->select('tbl_business_line.*', 'c.name as company_name')
                ->skip($start)->take($rowperpage)->get();


                $totalRecordswithFilter = Businessline::orderBy('tbl_business_line.name', 'ASC')
                ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
                ->select('tbl_business_line.*', 'c.name as company_name')->count();
            } 


            $recordList = array(); 
            foreach ($listBusiness as $key => $value) {
                $rows = array();
                $rows[] = $value->company_name;
                $rows[] = $value->name;
                $rows[] = ($value->status==1 ? "Active" : "Inactive");
                $rows[] = '<button type="button" name="update" id="'.$value->business_line_id.'" class="btn btn-warning btn-xs update"><i class="ri-edit-2-line"> Edit</button>';
                $rows[] = '<button type="button" name="delete" id="'.$value->business_line_id.'" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>';
                $recordList[] = $rows;
            }  



            $output = [
                'draw' => intval($draw),
                'iTotalRecords' => $totalRecords,
                'iTotalDisplayRecords' => $totalRecordswithFilter,
                'data' => $recordList,
            ];

            return response()->json($output); */
        //}

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
                $resultUpdate->business_line_id = $request->business_line_id;
                $resultUpdate->status = ($request->post('status') ? 1 : 0);
                $resultUpdate->save();
            }

            if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
                $dele = Businessline::find($request->id); 
                $dele->delete();
            }

        /*$listBusiness = Businessline::orderBy('tbl_business_line.name', 'ASC')
        ->Leftjoin('tbl_companies as c', 'c.company_id', '=', 'tbl_business_line.company_id')
        ->select('tbl_business_line.*', 'c.name as company_name')
        ->get();*/ 
        return view('budget.business_line');
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

    public function getBusinessLine(Request $request)
    {


        $companyList = Company::orderBy('name','ASC')->get();
        if(isset($_REQUEST['action']) and $_REQUEST['action']=="addDataRow"){
            ?>
            <tr>
                <td align="center" class="text-danger"><button type="button" data-toggle="tooltip" data-placement="right" title="Click To Remove" onclick="if(confirm('Are you sure to remove?')){$(this).closest('tr').remove();}" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button></td>
                <td align="center">
                    <select name="company_id[]" id="company_id" class="form-control">
                        <?php
                        foreach ($companyList as $key => $value) { ?>
                            <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                        <?php }
                        ?>
                    </select>
                </td>
                <td><input type="text" name="name[]" class="form-control" required="required"></td>
                <td>
                    <div class="form-switch form-switch-lg">
                        <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status[]">
                    </div> 
                </td>
                <td></td> 
            </tr>
            <?php 
        }


        if(isset($_REQUEST['action']) and $_REQUEST['action']=="saveAddMore"){
            //extract($_REQUEST);
            if(isset($request->company_id) && !empty($request->company_id)){
                foreach($_POST['company_id'] as $key=>$value){

                    $result = Businessline::create([
                        "company_id"=>  $value,
                        "name"=>  $request->name[$key], 
                        "creator_user_id"=> Auth::user()->user_id, 
                        "status"=> ($request->post('status') ? 1 : 0), 
                    ]); 
                }
                echo "success";
            }
        }
    }



}
