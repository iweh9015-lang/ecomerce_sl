<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function __construct(
        protected string $dateFrom,
        protected string $dateTo
    ) {
    }

    /**
     * 1. Query Data.
     */
    public function query()
    {
        return Order::query()
            ->with(['user', 'items'])
            ->whereDate('created_at', '>=', $this->dateFrom)
            ->whereDate('created_at', '<=', $this->dateTo)
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'asc');
    }

    /**
     * 2. Header Kolom Excel.
     */
    public function headings(): array
    {
        return [
            'No. Order',
            'Tanggal Transaksi',
            'Nama Customer',
            'Email',
            'Jumlah Item',
            'Total Belanja (Rp)',
            'Status',
        ];
    }

    /**
     * 3. Mapping Data per Baris
     * Mengatur data apa yang masuk ke kolom mana.
     */
    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('d/m/Y H:i'), // Format tanggal Excel friendly
            $order->user->name,
            $order->user->email,
            $order->items->sum('quantity'),
            $order->total_amount, // Biarkan angka murni agar bisa dijumlah di Excel
            ucfirst($order->status),
        ];
    }

    /**
     * 4. Styling (Opsional: Bold Header).
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style baris pertama (Header) jadi Bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
