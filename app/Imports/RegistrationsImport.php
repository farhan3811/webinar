<?php

namespace App\Imports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegistrationsImport implements ToModel, WithHeadingRow
{
    /**
     * Transform the row into a model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Registration([
            'name' => $row['name'],
            'email' => $row['email'],
        ]);
    }
}

