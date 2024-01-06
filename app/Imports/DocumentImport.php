<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Document;
use App\Models\User;
use App\Models\Catalog;

class DocumentImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Document::create([
                'title' =>$row['title'],
                'description' =>$row['description'],
                'status' =>$row['status'],
                'isCatalog' =>$row['is_catalog'] ? $row['is_catalog'] : null,
                'catalog_id' => $row['catalog_id'] ? Catalog::where('id', $row['catalog_id'])->first()->id : null,
                'metadata' => $row['metadata'] ? json_decode($row['metadata']) : null,
                'user_id' =>  $row['user_id'] ? User::where('id', $row['user_id'])->first()->id : null,
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
