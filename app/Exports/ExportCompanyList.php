<?php

namespace App\Exports;

use App\Models\Company;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCompanyList implements FromCollection,WithHeadings
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
        $query = Company::query(); 

        $query->leftjoin('tbl_users as u', 'u.user_id', '=', 'tbl_companies.creator_user_id');
        $query->leftjoin('tbl_rrss_type', 'tbl_rrss_type.rrss_type_id', '=', 'tbl_companies.rrss_type_id');
        $query->leftjoin('tbl_comuna', 'tbl_comuna.comuna_id', '=', 'tbl_companies.comuna_id');

        $query->select(
            'tbl_companies.company_id',
            'tbl_companies.name',
            'tbl_companies.rut',
            'tbl_companies.business_activity',
            'tbl_companies.logo',
            'tbl_companies.webpage_url',
            'tbl_companies.rrss_url',
            'tbl_companies.rrss_type_id',
            'tbl_rrss_type.name as rrss_type',

            'tbl_companies.address_line_1',
            'tbl_companies.address_line_2',

            'tbl_companies.comuna_id',
            'tbl_comuna.name as comuna_name',

            'tbl_companies.creator_user_id',
            'u.name as register_by',
            'tbl_companies.status',
            'tbl_companies.created_at',
            'tbl_companies.updated_at'
        ); 

        $results = $query->orderBy('tbl_companies.company_id','DESC')->get();
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'company_id', 
            'name', 
            'rut', 
            'business_activity',
            'logo',
            'webpage_url',
            'rrss_url',
            'rrss_type_id', 
            'rrss_type_name', 
            'address_line_1', 
            'address_line_2', 

            'comuna_id',
            'comuna_name',

            'creator_user_id',
            'creator_user_name',

            'status',
            'created_at',
            'updated_at',
        ];
    } 
}