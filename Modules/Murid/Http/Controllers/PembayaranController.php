<?php

namespace Modules\Murid\Http\Controllers;

use App\Models\Bank;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Murid\Http\Requests\ConfirmPaymentRequest;
use Modules\SPP\Entities\BankAccount;
use Modules\SPP\Entities\DetailPaymentSpp;
use Modules\SPP\Services\SppBillingService;

class PembayaranController extends Controller
{
    private $billing;

    public function __construct(SppBillingService $billing)
    {
        $this->billing = $billing;
    }

    public function index()
    {
        $year = (int) request()->query('year', date('Y'));
        $year = ($year >= 2020 && $year <= ((int) date('Y') + 1)) ? $year : (int) date('Y');

        $this->billing->ensureForStudent(Auth::user(), $year);

        $payment = DetailPaymentSpp::with('payment')
            ->where('user_id', Auth::id())
            ->whereHas('payment', function ($query) use ($year) {
                $query->where('year', $year)->where('is_active', 1);
            })
            ->orderBy('id')
            ->get();

        $paidAmount = (int) $payment->where('status', 'paid')->sum('amount');
        $outstandingAmount = (int) $payment->where('status', 'unpaid')->sum('amount');
        $pendingCount = $payment->filter(function ($item) {
            return $item->status === 'unpaid' && ! empty($item->file);
        })->count();

        return view('murid::pembayaran.index', compact(
            'payment', 'year', 'paidAmount', 'outstandingAmount', 'pendingCount'
        ));
    }

    public function edit($id)
    {
        $payment = DetailPaymentSpp::with('user.muridDetail', 'payment')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($payment->status === 'paid') {
            return redirect()->route('pembayaran.index')
                ->with('error', 'Pembayaran tersebut sudah lunas.');
        }

        $accountbanks = BankAccount::where('is_active', 1)
            ->orderByDesc('is_primary')
            ->orderBy('bank_name')
            ->get();
        $bank = Bank::orderBy('nama_bank')->get();

        return view('murid::pembayaran.edit', compact('payment', 'accountbanks', 'bank'));
    }

    public function update(ConfirmPaymentRequest $request, $id)
    {
        $payment = DetailPaymentSpp::where('user_id', Auth::id())->findOrFail($id);

        if ($payment->status === 'paid') {
            return redirect()->route('pembayaran.index')
                ->with('error', 'Pembayaran tersebut sudah lunas.');
        }

        if (! $request->hasFile('file') && empty($payment->file)) {
            return back()->withErrors(['file' => 'File bukti pembayaran wajib diunggah.'])->withInput();
        }

        $newFile = null;
        if ($request->hasFile('file')) {
            $newFile = $request->file('file')->store('images/bukti_payment', 'public');
            $newFile = basename($newFile);
        }

        DB::transaction(function () use ($request, $payment, $newFile) {
            if ($newFile && $payment->file) {
                Storage::disk('public')->delete('images/bukti_payment/'.$payment->file);
            }

            $payment->update([
                'file' => $newFile ?: $payment->file,
                'date_file' => $request->date_file,
                'sender' => $request->sender,
                'bank_sender' => $request->bank_sender,
                'destination_bank' => $request->destination_bank,
                'approve_by' => null,
                'approve_date' => null,
            ]);
        });

        return redirect()->route('pembayaran.index')
            ->with('success', 'Bukti pembayaran berhasil dikirim dan menunggu verifikasi.');
    }
}
