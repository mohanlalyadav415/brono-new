<?php

namespace App\Exports;

use App\Models\Expensetype;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportExpenseType implements FromCollection,WithHeadings
{
    protected $request;
    
    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }
    public function collection()
    { 
        $query = Expensetype::query();
        if ($this->request->filled('company_id')) {
            $query->where('tbl_expense_type.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('expense_type_id')) {
            $query->where('tbl_expense_type.expense_type_id', $this->request->input('expense_type_id'));
        } 

        $query->leftjoin('tbl_companies', 'tbl_expense_type.company_id', '=', 'tbl_companies.company_id'); 
        $query->leftJoin('tbl_account as a', 'a.account_id', '=', 'tbl_expense_type.account_debit_id');
        $query->leftJoin('tbl_account as b', 'b.account_id', '=', 'tbl_expense_type.account_credit_id');
        $query->leftjoin('tbl_cost_centre', 'tbl_expense_type.cost_centre_id', '=', 'tbl_cost_centre.cost_centre_id');
        $query->leftjoin('tbl_users', 'tbl_expense_type.creator_user_id', '=', 'tbl_users.user_id'); 

        $query->select( 
            'tbl_expense_type.expense_type_id', 
            'tbl_expense_type.name as expense_name',

            'tbl_expense_type.company_id',
            'tbl_companies.name as company_name',
 
            'a.account_name as debit_account_name',
            'b.account_name as credit_account_name', 

            'tbl_expense_type.cost_centre_id',
            'tbl_cost_centre.name as cost_centre_name',

            'tbl_expense_type.all_projects',

            'tbl_expense_type.creator_user_id',
            'tbl_users.name as register_by',

            'tbl_expense_type.status',
            'tbl_expense_type.created_at',
            'tbl_expense_type.updated_at',
        );

        $results = $query->orderBy('tbl_expense_type.expense_type_id','DESC')->get(); 
 
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'expense_type_id',
            'expense_type_name',
            'company_id', 
            'company_name',  
            'account_debit_id',
            'account_credit_id',
            'cost_centre_id',
            'cost_centre_name',  
            'all_projects',  
            'creator_user_id',
            'creator_user_name',
            'status',
            'created_at',
            'updated_at',
        ];
    } 
}