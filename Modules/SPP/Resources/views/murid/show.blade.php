@extends('layouts.backend.app')

@section('title', 'Detail Pembayaran Murid')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <h2>Detail SPP {{ optional($payment->user)->name }}</h2>
            <p class="text-muted mb-0">NISN: {{ optional(optional($payment->user)->muridDetail)->nisn ?: '-' }} · Tahun {{ $payment->year }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Sudah Dibayar</small><h3 class="text-success">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</h3></div></div></div>
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Sisa Tagihan</small><h3 class="text-warning">Rp {{ number_format($payment->outstanding_amount, 0, ',', '.') }}</h3></div></div></div>
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Status Tahunan</small><h3>{{ $payment->detailPayment->where('status', 'unpaid')->isEmpty() ? 'Lunas' : $payment->detailPayment->where('status', 'unpaid')->count().' bulan tersisa' }}</h3></div></div></div>
    </div>

    <div class="card">
        <div class="card-header border-bottom"><h4 class="card-title">Rincian Tagihan</h4></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No</th><th>Bulan</th><th>Nominal</th><th>Status</th><th>Bukti</th><th>Verifikasi</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($payment->detailPayment as $key => $detail)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $detail->month_label }}</td>
                        <td>Rp {{ number_format($detail->amount, 0, ',', '.') }}</td>
                        <td>
                            @if($detail->status === 'paid')<span class="badge badge-success">Lunas</span>
                            @elseif($detail->file)<span class="badge badge-info">Menunggu Verifikasi</span>
                            @else<span class="badge badge-warning">Belum Lunas</span>@endif
                        </td>
                        <td>@if($detail->url_file)<a href="{{ $detail->url_file }}" target="_blank" rel="noopener" class="btn btn-outline-info btn-sm">Lihat Bukti</a>@else-@endif</td>
                        <td>@if($detail->status === 'paid'){{ optional($detail->approvedBy)->name ?: '-' }}<br><small>{{ optional($detail->approve_date)->format('d-m-Y') }}</small>@else-@endif</td>
                        <td>
                            @if($detail->status === 'unpaid' && $detail->file)
                                <button type="button" class="btn btn-success btn-sm payment-process" data-toggle="modal" data-target="#modalPembayaran"
                                    data-id="{{ $detail->id }}" data-name="{{ optional($detail->user)->name }}"
                                    data-nisn="{{ optional(optional($detail->user)->muridDetail)->nisn }}" data-month="{{ $detail->month_label }}"
                                    data-amount="Rp {{ number_format($detail->amount, 0, ',', '.') }}" data-sender="{{ $detail->sender }}"
                                    data-banksender="{{ $detail->bank_sender }}" data-datefile="{{ $detail->date_file }}" data-destinationbank="{{ $detail->destination_bank }}">Konfirmasi</button>
                                <form action="{{ route('spp.murid.reject.pembayaran') }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak bukti pembayaran ini?')">
                                    @csrf @method('PUT')<input type="hidden" name="id_payment" value="{{ $detail->id }}">
                                    <button class="btn btn-outline-danger btn-sm">Tolak</button>
                                </form>
                            @else-
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('spp.murid.index', ['year' => $payment->year]) }}" class="btn btn-outline-secondary">Kembali</a>
    @include('spp::murid.update')
</div>
@endsection

@section('scripts')
<script>
$(document).on('click', '.payment-process', function () {
    var button = $(this);
    $('#id_payment').val(button.data('id'));
    $('#nisn').val(button.data('nisn'));
    $('#name').val(button.data('name'));
    $('#month').val(button.data('month'));
    $('#amount').val(button.data('amount'));
    $('#sender').val(button.data('sender'));
    $('#banksender').val(button.data('banksender'));
    $('#datefile').val(button.data('datefile'));
    $('#destinationbank').val(button.data('destinationbank'));
});

$(document).on('click', '#konfirmasiPembayaran', function () {
    var button = $(this);
    button.prop('disabled', true);
    $.ajax({
        url: '{{ route('spp.murid.update.pembayaran') }}',
        method: 'PUT',
        data: {_token: '{{ csrf_token() }}', id_payment: $('#id_payment').val()},
        success: function () { window.location.reload(); },
        error: function () { button.prop('disabled', false); alert('Pembayaran gagal dikonfirmasi. Silakan muat ulang halaman.'); }
    });
});
</script>
@endsection
