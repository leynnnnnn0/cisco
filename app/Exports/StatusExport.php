<?php

namespace App\Exports;

use App\Models\Status;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class StatusExport implements FromQuery
{
    use Exportable;
    private int $id;
    private string $from;
    private string $to;
    public function getQuery(int $id, string $from, string $to)
    {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;

        return $this;
    }

    public function getId(int $id)
    {
        $this->id = $id;
        return $this;
    }
    /**
    * @return Collection
    */
    public function query()
    {
        return Status::query()->where('user_id', $this->id)->whereBetween('created_at', [$this->from, $this->to . ' 23:59:59']);
    }
}
