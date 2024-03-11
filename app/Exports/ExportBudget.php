<?php

namespace App\Exports;

use App\Models\Budget;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportBudget implements FromCollection,WithHeadings
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
        $query = Budget::query();
        if ($this->request->filled('company_id')) {
            $query->where('tbl_budget.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('project_id')) {
            $query->where('tbl_budget.project_id', $this->request->input('project_id'));
        }
        if ($this->request->filled('budget_type_id')) {
            $query->where('tbl_budget.budget_type_id', $this->request->input('budget_type_id'));
        } 
        if ($this->request->filled('expense_type_id')) {
            $query->where('tbl_budget.expense_type_id', $this->request->input('expense_type_id'));
        }  

        $query->leftjoin('tbl_companies', 'tbl_budget.company_id', '=', 'tbl_companies.company_id');
        $query->leftjoin('tbl_project', 'tbl_budget.project_id', '=', 'tbl_project.project_id');
        $query->leftjoin('tbl_budget_type', 'tbl_budget.budget_type_id', '=', 'tbl_budget_type.budget_type_id');
        $query->leftjoin('tbl_month', 'tbl_budget.month_id', '=', 'tbl_month.month_id');
        $query->leftjoin('tbl_users', 'tbl_budget.creator_user_id', '=', 'tbl_users.user_id');
        $query->leftjoin('tbl_expense_type', 'tbl_budget.expense_type_id', '=', 'tbl_expense_type.expense_type_id');


        $query->select(

            'tbl_budget.company_id',
            'tbl_companies.name as company_name',

            'tbl_budget.project_id',
            'tbl_project.name as project_name', 

            'tbl_budget_type.name as budget_type_name', 
            'tbl_budget.budget_id',

            'tbl_budget.expense_type_id', 
            'tbl_expense_type.name as expense_name',

            'tbl_budget.movement_type_id',

            'tbl_budget.year',

            'tbl_budget.month_id',
            'tbl_month.name as month_name',

            'tbl_budget.amount',
            'tbl_budget.qty',
            'tbl_budget.creator_user_id',
            'tbl_users.name as register_by',

            'tbl_budget.status',
            'tbl_budget.created_at',
            'tbl_budget.updated_at',
        );
//\DB::enableQueryLog();
        $results = $query->orderBy('tbl_budget.budget_id','DESC')->get(); 
  //      dd(\DB::getQueryLog());
    //    print_r($results); die;
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'company_id', 
            'company_name',  // Custom header for the first column
            'project_id',
            'project_name',
            'budget_type_name',
            'budget_id',
            'expense_type_id',
            'expense_type_name',
            'movement_type_id',
            'year',
            'month_id',
            'month_name',
            'amount',
            'qty',
            'creator_user_id',
            'creator_user_name',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    public function map($row): array
    {
        // Format date columns as needed
        $row['created_at'] = $row['created_at']->format('Y/m/d H:i:s');
        $row['updated_at'] = $row['updated_at']->format('Y/m/d H:i:s');

        return $row->toArray();
    }
}