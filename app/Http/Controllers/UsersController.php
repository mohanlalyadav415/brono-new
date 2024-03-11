<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use App\Models\Rrsstype;
use App\Models\Comuna;
use App\Models\Company;
use App\Models\Role;
use App\Models\Access;
use App\Models\Usersaccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Helpers\RutHelper;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Excel;
use App\Exports\ExportUserList;
use App\Exports\ExportCompanyList;


class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function userlist(Request $request)
    {
        $listUsers = User::orderBy('tbl_users.name', 'ASC')
        ->Leftjoin('tbl_users as u', 'u.user_id', '=', 'tbl_users.creator_user_id')
        ->select('tbl_users.*', 'u.name as register_by')
        ->get();  
        //$listUsers = User::orderBy('tbl_users.name', 'ASC')->get();
        return view('configure.userlist',compact('listUsers'));
    }
    public function userCard(Request $request)
    {
        if($request->post()){ 

            $request->validate([
                'dni' => 'required|chilean_rut', 
                'name' => 'required',   
                'last_name_1' => 'required',   
                'last_name_2' => 'required',   
                'email' => 'required|email|unique:tbl_users', 
                'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            ]);

            $results = User::create([
                "dni"=>  $request->dni,
                "name"=>  $request->name,
                "last_name_1"=>  $request->last_name_1,  
                "last_name_2"=>  $request->last_name_2,  
                "email"=>  $request->email,  
                "phone"=> ($request->phone ? $request->phone : ""), 
                "superadmin"=> ($request->superadmin ? $request->superadmin : 0), 
                "password"=>  Hash::make($request->password),  
                "creator_user_id"=> Auth::user()->user_id, 
                "status"=>  ($request->post('status') ? 1 : 0)
            ]);  

            if(!is_null($results->user_id)) { 
                if($request->superadmin==0){
                    foreach ($request->post('company_id') as $key => $value) {

                        $result = Usersaccess::create([
                            "user_id"=>  $results->user_id,
                            "company_id"=>  $value,
                            "role_id"=>  $request->role_id[$key],
                            "access_id"=> $request->btn_access_1[$key],
                            "creator_user_id"=> Auth::user()->user_id, 
                            "status"=> 0, 
                        ]);
                    } 
                }
                
                return redirect('userlist')->with('success_msg','User Card added successfully.');
            } else { 
                return redirect('user_card')->with('error_msg',__('failed to add.'));
            }
        } 

        $listCompany = Company::orderBy('name', 'ASC')->get(); 
        $listRole = Role::orderBy('name', 'ASC')->get(); 
        $getAccess = Access::all();
        $newInsertID = DB::table('INFORMATION_SCHEMA.TABLES')->select('auto_increment')->where('table_name', 'tbl_users')->value('auto_increment');
        return view('configure.user_card',compact('newInsertID','getAccess','listCompany','listRole'));
    }

    public function userCardEdit(Request $request,$user_id)
    {
        if($request->post()){ 

            $request->validate([
                'dni' => 'required|chilean_rut', 
                'name' => 'required',   
                'last_name_1' => 'required',   
                'last_name_2' => 'required',   
                'email' => 'required'
            ]);

            $resultUpdate = User::find($request->user_id);

            $resultUpdate->dni = $request->dni;
            $resultUpdate->name = $request->name;
            $resultUpdate->last_name_1 = $request->last_name_1;
            $resultUpdate->last_name_2 = $request->last_name_2;
            $resultUpdate->email = $request->email;
            $resultUpdate->phone = ($request->phone ? $request->phone : "");
            $resultUpdate->superadmin = ($request->superadmin ? $request->superadmin : 0); 
            $resultUpdate->status = ($request->post('status') ? 1 : 0);

            if($resultUpdate->save()) { 
                if($request->superadmin==0){
                    Usersaccess::where('user_id',$user_id)->delete();
                    foreach ($request->post('company_id') as $key => $value) {

                        $result = Usersaccess::create([
                            "user_id"=>  $user_id,
                            "company_id"=>  $value,
                            "role_id"=>  $request->role_id[$key],
                            "access_id"=> $request->btn_access_1[$key], 
                            "creator_user_id"=> Auth::user()->user_id, 
                            "status"=> 0, 
                        ]);
                    } 
                }elseif($request->superadmin==1){
                 Usersaccess::where('user_id',$user_id)->delete();
             }
             return redirect('userlist')->with('success_msg','User card update successfully.');
         } 
     }

     $getUser = User::where('user_id',$user_id)->first();


     $listCompany = Company::orderBy('name', 'ASC')->get(); 
     $listRole = Role::orderBy('name', 'ASC')->get(); 
     $getAccess = Access::all();

     $listUserAccess = Usersaccess::where('user_id',$user_id)->get(); 

     return view('configure.user_card_edit',compact('listCompany','listRole','getAccess','getUser','listUserAccess'));
 }

 public function deleteuserCard($user_id)
 {
    $company_card = User::find($user_id);

    if($company_card->delete()) { 
        return redirect('userlist')->with('success_msg','User Card deleted successfully.');
    } else { 
        return redirect('userlist')->with('error_msg',__('failed to add.'));
    }
}

public function companyList(Request $request)
{
    $listCompany = Company::orderBy('tbl_companies.name', 'ASC')
    ->join('tbl_users', 'tbl_companies.creator_user_id', '=', 'tbl_users.user_id')
    ->select('tbl_companies.*', 'tbl_users.name as register_by')
    ->get(); 

    return view('configure.companylist',compact('listCompany'));
}
public function companyCard(Request $request)
{
    if($request->post()){ 

        $request->validate([
            'name' => 'required', 
            'rut' => 'required|chilean_rut', 
            'logo' => 'required',   
            'region_id' => 'required',   
            'address_line_1' => 'required', 
            'comuna_id' => 'required', 
        ]);


        $logo = $request->file('logo');
        $imageName = time().'_'.$logo->getClientOriginalName();  
        $request->logo->move(public_path('images/company'), $imageName);

        $result = Company::create([
            "name"=>  $request->name,
            "rut"=>  $request->rut, 
            "business_activity"=>  ($request->business_activity ? $request->business_activity : ""), 
            "logo"=>  $imageName,
            "webpage_url"=> ($request->webpage_url ? $request->webpage_url : ""), 
            "rrss_url"=> ($request->rrss_url ? $request->rrss_url : ""), 
            "rrss_type_id"=> ($request->rrss_type_id ? $request->rrss_type_id : 0), 
            "address_line_1"=> ($request->address_line_1 ? $request->address_line_1 : ""), 
            "address_line_2"=> ($request->address_line_2 ? $request->address_line_2 : ""), 
            "region_id"=> ($request->region_id ? $request->region_id : 0), 
            "comuna_id"=> ($request->comuna_id ? $request->comuna_id : 0), 
            "creator_user_id"=> Auth::user()->user_id, 
            "status"=>  ($request->post('status') ? 1 : 0)
        ]);  

        if(!is_null($result->company_id)) { 
            return redirect('companylist')->with('success_msg','Company Card added successfully.');
        } else { 
            return redirect('company_card')->with('error_msg',__('failed to add.'));
        }
    }

    $newInsertID = DB::table('INFORMATION_SCHEMA.TABLES')->select('auto_increment')->where('table_name', 'tbl_companies')->value('auto_increment');

    $listRsstype = Rrsstype::orderBy('name','ASC')->get();
    $listRegion = Region::orderBy('name','ASC')->get();  
    return view('configure.company_card',compact('listRsstype','listRegion','newInsertID'));
}

public function companyCardEdit(Request $request,$company_id)
{ 
    if($request->post()){ 

        $request->validate([
            'name' => 'required', 
            'rut' => 'required',    
            'region_id' => 'required',    
            'address_line_1' => 'required', 
            'comuna_id' => 'required', 
        ]); 
        $resultUpdate = Company::find($request->company_id);

        $resultUpdate->name = $request->name;
        $resultUpdate->rut = $request->rut;
        $resultUpdate->business_activity = ($request->business_activity ? $request->business_activity : "");

        $logo = $request->file('logo');
        if($logo){
            $imageName = time().'_'.$logo->getClientOriginalName();  
            $request->logo->move(public_path('images/company'), $imageName);
            $resultUpdate->logo = $imageName;
        }

        $resultUpdate->webpage_url = ($request->webpage_url ? $request->webpage_url : ""); 
        $resultUpdate->rrss_url = ($request->rrss_url ? $request->rrss_url : "");
        $resultUpdate->rrss_type_id = ($request->rrss_type_id ? $request->rrss_type_id : 0) ;
        $resultUpdate->address_line_1 = ($request->address_line_1 ? $request->address_line_1 : "") ;
        $resultUpdate->address_line_2 = ($request->address_line_2 ? $request->address_line_2 : "") ;
        $resultUpdate->region_id = ($request->region_id ? $request->region_id : 0) ;
        $resultUpdate->comuna_id = ($request->comuna_id ? $request->comuna_id : 0) ;
        $resultUpdate->status = ($request->post('status') ? 1 : 0);

        if($resultUpdate->save()) { 
            return redirect('companylist')->with('success_msg','Company card update successfully.');
        } 
    }

    $listRsstype = Rrsstype::orderBy('name','ASC')->get();
    $listRegion = Region::orderBy('name','ASC')->get();
    $getCompany = Company::where('company_id',$company_id)->first();

    return view('configure.company_card_edit',compact('listRsstype','listRegion','getCompany'));
}

public function deleteCompanyCard($company_id)
{
    $company_card = Company::find($company_id);

    if($company_card->delete()) { 
        return redirect('companylist')->with('success_msg','Company Card deleted successfully.');
    } else { 
        return redirect('companylist')->with('error_msg',__('failed to add.'));
    }
}

public function getUserAccessModule(Request $request)
{
    $UsersaccessList = Usersaccess::where('user_access_id',$request->user_access_id)->get();
    return response()->json($UsersaccessList);
}


public function getComuna($region_id)
{
    $comunaList = Comuna::where('region_id', $region_id)->get();
    return response()->json($comunaList);
}

public function userExport(Request $request)
{
    return Excel::download(new ExportUserList($request), 'UserList.xlsx');
} 
public function companyExport(Request $request)
{
    return Excel::download(new ExportCompanyList($request), 'CompanyList.xlsx');
} 

}
