<?php

namespace App\Exports;

use App\Models\Account;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAccount implements FromCollection,WithHeadings
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
        $query = Account::query();
        if ($this->request->filled('company_id')) {
            $query->where('tbl_account.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('status')) {
            $query->where('tbl_account.status', $this->request->input('status'));
        }
        

        $query->leftjoin('tbl_companies', 'tbl_account.company_id', '=', 'tbl_companies.company_id');
        $query->leftjoin('tbl_users', 'tbl_account.creator_user_id', '=', 'tbl_users.user_id');

        $query->select(

            'tbl_account.account_id',
            'tbl_account.account_external_id',
            'tbl_account.company_id',
            'tbl_companies.name as company_name',  
            'tbl_account.account_name',  

            'tbl_account.creator_user_id',
            'tbl_users.name as register_by',

            'tbl_account.status',
            'tbl_account.created_at',
            'tbl_account.updated_at',
        ); 
        $results = $query->orderBy('tbl_account.account_id','DESC')->get();
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'account_id', 
            'account_external_id', 
            'company_id', 
            'company_name',  // Custom header for the first column
            'account_name',
            'creator_user_id',
            'creator_user_name',
            'status',
            'created_at',
            'updated_at',
        ];
    } 
}