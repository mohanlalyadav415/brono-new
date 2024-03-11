<?php

namespace App\Exports;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSupplier implements FromCollection,WithHeadings
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function collection()
    { 
        $query = Supplier::query(); 

        if ($this->request->filled('company_id')) {
            $query->where('tbl_supplier.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('status')) {
            $query->where('tbl_supplier.status', $this->request->input('status'));
        }
 
        $query->leftjoin('tbl_dte_type', 'tbl_dte_type.dte_type_id', '=', 'tbl_supplier.dte_type_id');
        $query->leftjoin('tbl_organization_type', 'tbl_organization_type.organization_type_id', '=', 'tbl_supplier.organization_type_id');
        $query->leftjoin('tbl_companies', 'tbl_companies.company_id', '=', 'tbl_supplier.company_id'); 

        $query->select(
            'tbl_companies.name as comp',
            'tbl_supplier.supplier_id',
            'tbl_supplier.rut',
            'tbl_supplier.name as supplier_name',
            'tbl_companies.status',
            'tbl_organization_type.name',
            'tbl_supplier.contacts_email',
            'tbl_supplier.contact_name',
            'tbl_dte_type.name as dte_type_name',
        ); 

        $results = $query->orderBy('tbl_supplier.supplier_id','ASC')->get();
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'company_name', 
            'supplier_id', 
            'supplier_rut', 
            'supplier_name',
            'status',
            'organization_type',
            'email',
            'contacts_person',
            'dte_type_name',
        ];
    } 
}