<?php

namespace App\Exports;

use App\Models\Service;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportService implements FromCollection,WithHeadings
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function collection()
    { 
        $query = Service::query(); 

        if ($this->request->filled('company_id')) {
            $query->where('tbl_service.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('status')) {
            $query->where('tbl_service.status', $this->request->input('status'));
        }
 
        $query->leftjoin('tbl_expense_type', 'tbl_expense_type.expense_type_id', '=', 'tbl_service.expense_type_id');
        $query->leftjoin('tbl_companies', 'tbl_companies.company_id', '=', 'tbl_service.company_id'); 

        $query->select(
            'tbl_companies.name as comp',
            'tbl_service.service_id',
            'tbl_service.name',
            'tbl_expense_type.expense_type_id',
            'tbl_expense_type.name as expense_type',
            'tbl_service.cost_per_unit',
            'tbl_companies.status',
        ); 

        $results = $query->orderBy('tbl_service.service_id','ASC')->get();
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'company_name', 
            'service_id', 
            'service', 
            'expense_type_id',
            'expense_type_name',
            'cost_per_unit',
            'status',
        ];
    } 
}