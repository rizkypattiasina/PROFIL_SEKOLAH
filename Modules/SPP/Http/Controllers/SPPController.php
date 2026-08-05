<?php

namespace Modules\SPP\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\SPP\Entities\DetailPaymentSpp;
use Modules\SPP\Entities\PaymentSpp;
use Modules\SPP\Entities\SppSetting;
use Modules\SPP\Services\SppBillingService;

class SPPController extends Controller
{
    private $billing;

    public function __construct(SppBillingService $billing)
    {
        $this->billing = $billing;
    }

    public function index(Request $request)
    {
        $year = $this->selectedYear($request);
        $this->billing->ensureForAllStudents($year);

        $details = DetailPaymentSpp::whereHas('payment', function ($query) use ($year) {
            $query->where('year', $year)->where('is_active', 1);
        });

        $studentCount = PaymentSpp::where('year', $year)->where('is_active', 1)->count();
        $currentMonthBills = (clone $details)->where('month', date('F'))->count();
        $paid = (clone $details)->where('status', 'paid')->count();
        $unpaid = (clone $details)->where('status', 'unpaid')->count();
        $pending = (clone $details)->where('status', 'unpaid')->whereNotNull('file')->count();
        $paidAmount = (int) (clone $details)->where('status', 'paid')->sum('amount');
        $outstandingAmount = (int) (clone $details)->where('status', 'unpaid')->sum('amount');

        return view('spp::index', compact(
            'year', 'studentCount', 'currentMonthBills', 'paid', 'unpaid',
            'pending', 'paidAmount', 'outstandingAmount'
        ));
    }

    public function murid(Request $request)
    {
        $year = $this->selectedYear($request);
        $this->billing->ensureForAllStudents($year);

        $payment = User::with([
                'muridDetail',
                'payments' => function ($query) use ($year) {
                    $query->where('year', $year)->with('detailPayment');
                },
            ])
            ->where('role', 'Murid')
            ->orderBy('name')
            ->get();

        return view('spp::murid.index', compact('payment', 'year'));
    }

    public function detail($id)
    {
        $payment = PaymentSpp::with('detailPayment.approvedBy', 'detailPayment.user.muridDetail', 'user.muridDetail')
            ->findOrFail($id);

        if ($payment->user) {
            $payment = $this->billing->ensureForStudent($payment->user, (int) $payment->year);
            $payment->load('detailPayment.approvedBy', 'detailPayment.user.muridDetail', 'user.muridDetail');
        }

        return view('spp::murid.show', compact('payment'));
    }

    public function updatePembayaran(Request $request)
    {
        $validated = $request->validate([
            'id_payment' => 'required|integer|exists:detail_payment_spps,id',
        ]);

        $detail = DB::transaction(function () use ($validated) {
            $detail = DetailPaymentSpp::lockForUpdate()->findOrFail($validated['id_payment']);

            if ($detail->status === 'paid') {
                return $detail;
            }

            $detail->update([
                'status' => 'paid',
                'approve_by' => Auth::id(),
                'approve_date' => Carbon::now(),
            ]);

            $this->billing->syncSummary($detail->payment);

            return $detail->fresh('approvedBy');
        });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Pembayaran berhasil dikonfirmasi.',
                'payment' => $detail,
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function rejectPembayaran(Request $request)
    {
        $validated = $request->validate([
            'id_payment' => 'required|integer|exists:detail_payment_spps,id',
        ]);

        $detail = DetailPaymentSpp::findOrFail($validated['id_payment']);

        if ($detail->status === 'paid') {
            return back()->with('error', 'Pembayaran yang sudah lunas tidak dapat ditolak.');
        }

        if ($detail->file) {
            Storage::disk('public')->delete('images/bukti_payment/'.$detail->file);
        }

        $detail->update([
            'file' => null,
            'date_file' => null,
            'sender' => null,
            'bank_sender' => null,
            'destination_bank' => null,
            'status' => 'unpaid',
            'approve_by' => null,
            'approve_date' => null,
        ]);

        $this->billing->syncSummary($detail->payment);

        return back()->with('success', 'Bukti pembayaran ditolak. Murid dapat mengunggah ulang.');
    }

    public function setting()
    {
        $setting = SppSetting::with('updateBy')->first();

        return view('spp::setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:0|max:2000000000',
            'apply_existing' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated) {
            $setting = SppSetting::first();
            $payload = ['amount' => $validated['amount'], 'update_by' => Auth::id()];

            $setting ? $setting->update($payload) : SppSetting::create($payload);

            if (! empty($validated['apply_existing'])) {
                DetailPaymentSpp::where('status', 'unpaid')
                    ->whereHas('payment', function ($query) {
                        $query->where('year', date('Y'));
                    })
                    ->update(['amount' => $validated['amount']]);
            }
        });

        return back()->with('success', 'Nominal SPP berhasil diperbarui.');
    }

    private function selectedYear(Request $request): int
    {
        $year = (int) $request->query('year', date('Y'));

        return ($year >= 2020 && $year <= ((int) date('Y') + 1))
            ? $year
            : (int) date('Y');
    }
}
