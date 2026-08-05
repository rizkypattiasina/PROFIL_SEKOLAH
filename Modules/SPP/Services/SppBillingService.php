<?php

namespace Modules\SPP\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\SPP\Entities\DetailPaymentSpp;
use Modules\SPP\Entities\PaymentSpp;
use Modules\SPP\Entities\SppSetting;

class SppBillingService
{
    public const MONTHS = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ];

    public const MONTH_LABELS = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember',
    ];

    /**
     * Buat atau lengkapi 12 tagihan SPP seorang murid untuk satu tahun.
     */
    public function ensureForStudent(User $student, ?int $year = null): PaymentSpp
    {
        $year = $year ?: (int) date('Y');
        $amount = (int) optional(SppSetting::first())->amount;

        return DB::transaction(function () use ($student, $year, $amount) {
            $payment = PaymentSpp::firstOrCreate(
                ['user_id' => $student->id, 'year' => $year],
                ['is_active' => 1]
            );

            foreach (self::MONTHS as $month) {
                DetailPaymentSpp::firstOrCreate(
                    ['payment_id' => $payment->id, 'month' => $month],
                    [
                        'user_id' => $student->id,
                        'amount' => $amount,
                        'status' => 'unpaid',
                    ]
                );
            }

            $this->syncSummary($payment);

            return $payment->fresh(['detailPayment', 'user.muridDetail']);
        });
    }

    /**
     * Pastikan seluruh murid aktif mempunyai tagihan pada tahun terpilih.
     */
    public function ensureForAllStudents(?int $year = null): void
    {
        $year = $year ?: (int) date('Y');

        User::where('role', 'Murid')
            ->where('status', 'Aktif')
            ->orderBy('id')
            ->chunkById(100, function ($students) use ($year) {
                foreach ($students as $student) {
                    $this->ensureForStudent($student, $year);
                }
            });
    }

    /**
     * Sinkronkan kolom ringkasan Januari-Desember milik payment_spps.
     */
    public function syncSummary(PaymentSpp $payment): void
    {
        $statuses = $payment->detailPayment()->pluck('status', 'month');

        foreach (self::MONTHS as $month) {
            $payment->{$month} = $statuses->get($month, 'unpaid');
        }

        $payment->save();
    }

    public static function labelForMonth(string $month): string
    {
        return self::MONTH_LABELS[$month] ?? $month;
    }
}
