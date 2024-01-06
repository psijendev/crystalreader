<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Document;
use App\Models\User;
use App\Models\Catalog;


class CatalogImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Catalog::create([
                'title' =>$row['title'],
                'description' =>$row['description'],
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
