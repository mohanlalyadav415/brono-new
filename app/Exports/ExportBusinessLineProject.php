<?php

namespace App\Exports;

use App\Models\Businessline;
use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportBusinessLineProject implements FromCollection,WithHeadings
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
        $listProject = Businessline::
        leftjoin('tbl_users as u', 'u.user_id', '=', 'tbl_business_line.creator_user_id')->
        leftjoin('tbl_companies', 'tbl_companies.company_id', '=', 'tbl_business_line.company_id')
        ->select('tbl_business_line.*','tbl_companies.name as company_name','u.name as register_by');


        if ($this->request->filled('company_id')) {
            $listProject->where('tbl_business_line.company_id', $this->request->input('company_id'));
        }
        if ($this->request->filled('name')) {
            $listProject->where('tbl_business_line.name', $this->request->input('name'));
        }

        $listProject = $listProject->get();

        $data = [];
        foreach ($listProject as $businessLine) { 
            $getProjects = Project::where('business_line_id', $businessLine->business_line_id)
            ->whereNull('deleted_at')
            ->get();

            foreach ($getProjects as $project) {
                $data[] = [
                    $businessLine->business_line_id,
                    $businessLine->name,
                    $businessLine->company_id,
                    $businessLine->company_name,
                    $project->project_id,
                    $project->name,
                    $businessLine->creator_user_id,
                    $businessLine->register_by,
                    $businessLine->status,
                    $businessLine->created_at,
                    $businessLine->updated_at,
                ];
            }
        } 

        return collect($data);

    }

    public function headings(): array
    { 
        return [
            'business_line_id', 
            'business_line_name', 
            'company_id', 
            'company_name', 
            'project_id',
            'project_name',   
            'creator_user_id',
            'creator_user_name', 
            'status',
            'created_at',
            'updated_at',
        ];
    }

}