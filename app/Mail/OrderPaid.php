<?php

// app/Mail/OrderPaid.php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaid extends Mailable
{
    // Trait Queueable: Memungkinkan email ini dikirim melalui antrian (Queue)
    // Trait SerializesModels: Penting saat passing Model Order ke Queue.
    // Laravel hanya akan menyimpan ID Order di Queue, lalu mengambil ulang datanya saat Job diproses.
    use Queueable;
    use SerializesModels;

    // Visibility PUBLIC agar bisa diakses langsung di file VIEW blade.
    // Tidak perlu passing via with() di method content.
    public function __construct(
        public Order $order
    ) {
    }

    /**
     * Definisi Subjek dan Pengirim Email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Diterima - Order #'.$this->order->order_number,
        );
    }

    /**
     * Definisi Isi Konten Email (View).
     */
    public function content(): Content
    {
        return new Content(
            // Menggunakan Markdown view
            // Lokasi: resources/views/emails/orders/paid.blade.php
            markdown: 'emails.orders.paid',
        );
    }
}
