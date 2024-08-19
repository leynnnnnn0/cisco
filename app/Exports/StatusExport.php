<?php

namespace App\Exports;

use App\Models\Status;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class StatusExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Status::all();
    }
}
