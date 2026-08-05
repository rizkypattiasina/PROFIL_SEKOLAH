<?php

namespace Modules\SPP\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class DetailPaymentSpp extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['url_file', 'month_label'];

    protected $casts = [
        'date_file' => 'date',
        'approve_date' => 'date',
        'amount' => 'integer',
    ];

    public function getUrlFileAttribute()
    {
        if (empty($this->file)) {
            return null;
        }
        return asset(Storage::url('images/bukti_payment/' .$this->file));
    }

    public function getMonthLabelAttribute()
    {
        return \Modules\SPP\Services\SppBillingService::labelForMonth($this->month);
    }

    public function payment()
    {
      return $this->belongsTo(PaymentSpp::class,'payment_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }

    public function aprroveBy()
    {
      return $this->belongsTo(User::class, 'approve_by');
    }

    public function approvedBy()
    {
      return $this->belongsTo(User::class, 'approve_by');
    }
}
