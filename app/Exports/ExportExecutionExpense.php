<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExportExecutionExpense implements FromCollection,WithHeadings
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }
    public function collection()
    { 

        $query = Expense::query(); 
        if (isset($_GET['company_id']) && !empty($_GET['company_id'])) {
            $query->where('tbl_expense.company_id', $_GET['company_id']);
        }

        if (isset($_GET['project_id']) && !empty($_GET['project_id'])) {
            $query->where('tbl_expense.project_id', $_GET['project_id']);
        }

        if (isset($_GET['supplier_id']) && !empty($_GET['supplier_id'])) {
            $query->where('tbl_expense.supplier_id', $_GET['supplier_id']);
        }

        if (isset($_GET['fromDate']) && isset($_GET['fromDate']) && !empty($_GET['toDate']) && !empty($_GET['toDate']) ) { 
            $query->whereBetween('tbl_expense.date', [$_GET['fromDate'],$_GET['toDate']]);
        }

        $query->leftJoin('tbl_project', 'tbl_project.project_id', '=', 'tbl_expense.project_id');
        $query->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_expense.supplier_id');
        $query->leftJoin('tbl_expense_source', 'tbl_expense_source.expense_source_id', '=', 'tbl_expense.source_id');
        $query->leftJoin('tbl_expense_normal', 'tbl_expense.expense_id', '=', 'tbl_expense_normal.expense_id');
        $query->leftJoin('tbl_expense_type', 'tbl_expense_type.expense_type_id', '=', 'tbl_expense_normal.expense_type_id');
        $query->leftJoin('tbl_dte_type', 'tbl_dte_type.dte_type_id', '=', 'tbl_expense.dte_type_id');
        $query->leftJoin('tbl_payment_status', 'tbl_payment_status.payment_status_id', '=', 'tbl_expense.payment_status_id');
        $query->leftJoin(DB::raw('(SELECT tbl_expense_execution_resource.expense_id,
            SUM(tbl_execution_resource.qty * tbl_service.cost_per_unit) AS total,
            SUM(tbl_execution_resource.qty) AS qtys
            FROM tbl_expense_execution_resource
            LEFT JOIN tbl_execution_resource ON tbl_execution_resource.execution_resource_id = tbl_expense_execution_resource.execution_resource_id
            LEFT JOIN tbl_service ON tbl_service.service_id = tbl_execution_resource.service_id
            GROUP BY tbl_expense_execution_resource.expense_id) AS subquery'), function($join) {
            $join->on('tbl_expense.expense_id', '=', 'subquery.expense_id');
        });
        $query->select(
            'tbl_expense.expense_id',
            'tbl_project.name as project',
            'tbl_supplier.rut', 
            'tbl_supplier.name as supplier_name', 
            'tbl_expense_source.name as source', 
            'tbl_expense_type.name as expense_type',
            'tbl_expense.date',
            'tbl_expense_normal.amount',
            'tbl_expense_normal.qty',
            'tbl_dte_type.name as dte_type',
            'tbl_payment_status.name as payment_status',
        );

        if (empty($tbl_expense_normal['amount'])) {
            $query->addSelect(DB::raw('tbl_expense_normal.amount * tbl_expense_normal.qty AS totalAmt'));
        }

        $query->addSelect('subquery.qtys','subquery.total');
 
        $results = $query->get(); 
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'ID', 
            'Project', 
            'RUT Supplier', 
            'Supplier',
            'Source',
            'Expense type',
            'Date',
            'Normal Amount',
            'Normal Qty',
            'DTE type',
            'Payment status' ,
            'Normal Total',
            'Expense Qty',
            'Expense Total',
        ];
    } 
}
