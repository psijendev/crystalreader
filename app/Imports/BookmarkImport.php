<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Document;
use App\Models\User;
use App\Models\Bookmark;

class BookmarkImport implements ToCollection, WithHeadingRow
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
            Bookmark::create([
                'document_id' =>  $row['document_id'] ? Document::where('id', $row['document_id'])->first()->id : null,
                'user_id' =>  $row['user_id'] ? User::where('id', $row['user_id'])->first()->id : null,
                'status' => $row['status'],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
