<?php

namespace Modules\SPP\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentSpp extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }

    public function detailPayment()
    {
      return $this->hasMany(DetailPaymentSpp::class,'payment_id')->orderBy('id');
    }

    public function getPaidAmountAttribute(): int
    {
        return (int) $this->detailPayment->where('status', 'paid')->sum('amount');
    }

    public function getOutstandingAmountAttribute(): int
    {
        return (int) $this->detailPayment->where('status', 'unpaid')->sum('amount');
    }
}
