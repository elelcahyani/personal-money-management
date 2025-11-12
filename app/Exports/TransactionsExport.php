<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;
    protected $startDate;
    protected $endDate;

    public function __construct($userId, $startDate = null, $endDate = null)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Transaction::where('user_id', $this->userId);

        if ($this->startDate) {
            $query->where('transaction_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->where('transaction_date', '<=', $this->endDate);
        }

        return $query->orderBy('transaction_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Tipe',
            'Kategori',
            'Jumlah',
            'Deskripsi',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_date->format('d/m/Y'),
            $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran',
            $transaction->category,
            $transaction->amount,
            $transaction->description ?? '-',
        ];
    }
}
