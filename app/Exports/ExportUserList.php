<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUserList implements FromCollection,WithHeadings
{
    protected $request;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }
    public function collection()
    { 
        $query = User::query();
        /*if ($this->request->filled('company_id')) {
            $query->where('tbl_cost_centre.company_id', $this->request->input('company_id'));
        }*/ 

        $query->leftjoin('tbl_users as u', 'u.user_id', '=', 'tbl_users.creator_user_id');

        $query->select(
            'tbl_users.user_id',
            'tbl_users.dni',
            'tbl_users.name',
            'tbl_users.last_name_1',
            'tbl_users.last_name_2',
            'tbl_users.email',
            'tbl_users.phone',
            'tbl_users.superadmin',
            'tbl_users.creator_user_id',
            'u.name as register_by',
            'tbl_users.status',
            'tbl_users.created_at',
            'tbl_users.updated_at'
        ); 

        $results = $query->orderBy('tbl_users.user_id','DESC')->get();
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'user_id', 
            'dni', 
            'name', 
            'last_name_1',
            'last_name_2',
            'email',
            'phone',
            'superadmin', 
            'creator_user_id',
            'creator_user_name',
            'status',
            'created_at',
            'updated_at',
        ];
    } 
}