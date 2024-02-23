<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
/* use Maatwebsite\Excel\Concerns\FromView; */
use Illuminate\Contracts\View\View;
use App\Models\Transaction;

class ExportRevenue implements FromCollection
/* class ExportRevenue implements FromView */
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $doneTransactions = Transaction::where('transaction_status', 'DONE')->get();
        return $doneTransactions;
    }
}
