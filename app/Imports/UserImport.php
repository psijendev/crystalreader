<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UserImport implements ToCollection, WithHeadingRow
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
            User::create([
                'name' =>$row['name'],
                'role' =>$row['role'] ? $row['role'] : "User",
                'status' =>$row['status'] ? $row['status'] : "Active",
                'countrycode' =>$row['countrycode'] ? $row['countrycode'] : null,
                'phoneno' =>$row['phoneno'] ? $row['phoneno'] : null,
                'email' =>$row['email'],
                'email_verified_at' =>$row['email_verified_at'] ? $row['email_verified_at'] : null,
                'password' =>$row['password'],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
