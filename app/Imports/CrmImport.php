<?php
namespace App\Imports;
 
use App\Models\Crm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CrmImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Crm([
            'category_id' => 1,
            'name'  => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'] ?? null,
            'company' => $row['company'] ?? null,
            'position' => $row['position'] ?? null,
            'address' => $row['address'] ?? null,
            'notes' => $row['notes'] ?? null,
            'website' => $row['website'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name'  => 'required|string|max:255',
            '*.email' => 'required|email|unique:crm,email',
        ];
    }
}
