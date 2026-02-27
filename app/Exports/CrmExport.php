<?php

namespace App\Exports;

use App\Models\Crm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CrmExport implements FromCollection, WithHeadings
{
    protected array $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function collection()
    {
        $query = Crm::query()
            ->leftJoin('categories', 'crm.category_id', '=', 'categories.id');

        $selects = [];

        foreach ($this->columns as $col) {
            switch ($col) {

                case 'category':
                    // AMBIL CATEGORY NAME
                    $selects[] = 'categories.name as category';
                    break;

                default:
                    // FIELD DARI TABLE CRM
                    $selects[] = 'crm.' . $col;
                    break;
            }
        }

        return $query->select($selects)->get();
    }

    public function headings(): array
    {
        return array_map(function ($col) {
            return match ($col) {
                'category' => 'Category',
                default    => ucfirst(str_replace('_', ' ', $col)),
            };
        }, $this->columns);
    }
}
