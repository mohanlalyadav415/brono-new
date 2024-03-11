<?php

namespace App\Exports;

use App\Models\Execution_resource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportExecutionResource implements FromCollection,WithHeadings
{
	protected $request;

	public function __construct(Request $request = null)
	{
		$this->request = $request;
	}

	public function collection()
	{ 
		$query = Execution_resource::query(); 

		if ($this->request->filled('company_id')) {
			$query->where('tbl_execution_resource.company_id', $this->request->input('company_id'));
		}
		if ($this->request->filled('status')) {
			$query->where('tbl_execution_resource.status', $this->request->input('status'));
		}

		$query->leftjoin('tbl_companies', 'tbl_companies.company_id', '=', 'tbl_execution_resource.company_id'); 
		$query->leftjoin('tbl_project','tbl_project.project_id','=','tbl_execution_resource.project_id');
		$query->leftjoin('tbl_resource','tbl_resource.resource_id','=','tbl_execution_resource.resource_id');
		$query->leftjoin('tbl_service','tbl_service.service_id','=','tbl_execution_resource.service_id');
		$query->leftjoin('tbl_time','tbl_time.time_id','=','tbl_execution_resource.time_id');

		$query->select(
			'tbl_companies.name as company',
			'tbl_execution_resource.project_id',
			'tbl_project.name as project',
			'tbl_execution_resource.date',
			'tbl_execution_resource.resource_id',
			'tbl_resource.name as resource',
			'tbl_execution_resource.service_id',
			'tbl_service.name as service',
			'tbl_execution_resource.qty',
			'tbl_execution_resource.time_id',
			'tbl_time.name as time', 
			'tbl_companies.status',
		); 

		$results = $query->orderBy('tbl_execution_resource.execution_resource_id','ASC')->get();
		return $results; 
	}

	public function headings(): array
	{ 
		return [
			'company_name', 
			'project_id', 
			'project', 
			'date', 
			'resource_id', 
			'resource', 
			'service_id', 
			'service', 
			'qty', 
			'time_id',
			'time',
			'status',
		];
	} 
}