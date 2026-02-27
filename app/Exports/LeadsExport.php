<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExport implements FromCollection, WithHeadings
{
    protected array $columns;
    protected ?int $categoryId;

    /**
     * @param array $columns
     * @param int|null $categoryId
     */
    public function __construct(array $columns, ?int $categoryId = null)
    {
        $this->columns = $columns;
        $this->categoryId = $categoryId;
    }

    public function collection()
    {
        $query = Lead::query()
            ->leftJoin('crm', 'leads.crm_id', '=', 'crm.id')
            ->leftJoin('categories', 'crm.category_id', '=', 'categories.id');

        // FILTER BERDASARKAN CATEGORY HALAMAN
        if ($this->categoryId) {
            $query->where('crm.category_id', $this->categoryId);
        }

        $selects = [];

        foreach ($this->columns as $col) {
            switch ($col) {

                case 'crm_id':
                    // CRM NAME
                    $selects[] = 'crm.name as crm_name';
                    break;

                case 'category':
                    // CATEGORY NAME DARI TABLE CATEGORIES
                    $selects[] = 'categories.name as category';
                    break;

                default:
                    // FIELD LANGSUNG DARI LEADS
                    $selects[] = 'leads.' . $col;
                    break;
            }
        }

        return $query->select($selects)->get();
    }

    public function headings(): array
    {
        return array_map(function ($col) {
            return match ($col) {
                'crm_id'     => 'CRM Name',
                'source'     => 'Source',
                'status'     => 'Status',
                'assigned_to'=> 'Assigned To',
                'category'   => 'Category',
                'notes'      => 'Notes',
                default      => ucfirst(str_replace('_', ' ', $col)),
            };
        }, $this->columns);
    }
}
