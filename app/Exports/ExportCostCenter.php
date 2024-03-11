<?php

namespace App\Exports;

use App\Models\Costcentre;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCostCenter implements FromCollection,WithHeadings
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
        $query = Costcentre::query();
        if ($this->request->filled('company_id')) {
            $query->where('tbl_cost_centre.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('status')) {
            $query->where('tbl_cost_centre.status', $this->request->input('status'));
        }
        

        $query->leftjoin('tbl_companies', 'tbl_cost_centre.company_id', '=', 'tbl_companies.company_id');
        $query->leftjoin('tbl_users', 'tbl_cost_centre.creator_user_id', '=', 'tbl_users.user_id');

        $query->select(

            'tbl_cost_centre.cost_centre_id',
            'tbl_cost_centre.cost_center_external_id',
            'tbl_cost_centre.company_id',
            'tbl_companies.name as company_name',  
            'tbl_cost_centre.name',  

            'tbl_cost_centre.creator_user_id',
            'tbl_users.name as register_by',

            'tbl_cost_centre.status',
            'tbl_cost_centre.created_at',
            'tbl_cost_centre.updated_at',
        ); 
        $results = $query->orderBy('tbl_cost_centre.cost_centre_id','DESC')->get();
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'cost_centre_id', 
            'cost_center_external_id', 
            'company_id', 
            'company_name',
            'name',
            'creator_user_id',
            'creator_user_name',
            'status',
            'created_at',
            'updated_at',
        ];
    } 
}