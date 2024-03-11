<?php

namespace App\Imports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BudgetImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    { 

        return new Budget([
            'company_id' => $row['company_id'],
            'project_id' => $row['project_id'], 
            'budget_type_id' => $row['budget_type_id'],
            'expense_type_id' => $row['expense_type_id'],
            'movement_type_id' => $row['movement_type_id'],
            'year' => $row['year'],
            'month_id' => $row['month_id'],
            'amount' => $row['amount'],
            'qty' => $row['qty'],
            'creator_user_id' => $row['creator_user_id'],
            'status' => $row['status'],  
        ]);
    }
}
