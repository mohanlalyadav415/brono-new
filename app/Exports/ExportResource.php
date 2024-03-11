<?php

namespace App\Exports;

use App\Models\Resource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportResource implements FromCollection,WithHeadings
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function collection()
    { 
        $query = Resource::query(); 

        if ($this->request->filled('company_id')) {
            $query->where('tbl_resource.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('status')) {
            $query->where('tbl_resource.status', $this->request->input('status'));
        }
 
        $query->leftjoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_resource.supplier_id');
        $query->leftjoin('tbl_companies', 'tbl_companies.company_id', '=', 'tbl_resource.company_id'); 

        $query->select(
            'tbl_companies.name as company',
            'tbl_resource.resource_id',
            'tbl_resource.name',
            'tbl_supplier.supplier_id',
            'tbl_supplier.name as supplier_name', 
            'tbl_companies.status',
        ); 

        $results = $query->orderBy('tbl_resource.resource_id','ASC')->get();
        return $results; 
    }

    public function headings(): array
    { 
        return [
            'company_name', 
            'resource_id', 
            'resource', 
            'supplier_id',
            'supplier_name',
            'status',
        ];
    } 
}