<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairOrder extends Model
{
    use HasFactory, SoftDeletes;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function branches(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public static function getOrderBeforeNow($day){
        $date = Carbon::now()->subDays($day);
        return RepairOrder::where('created_at', '>=', $date)->oldest()->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });
    }

    public function scopeInBranch($query, $key)
    {
        return $query->where('branch_id', $key);
    }

    public function scopeFilterRegistration($query, $key)
    {
        return $query->where('car_registration', 'LIKE', "%{$key}%");
    }

    public function scopeCompleteOrder($query)
    {
        return $query->whereNotNull('returning');
    }

    public function scopeIncompleteOrder($query)
    {
        return $query->whereNull('returning');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'repair_list' => 'array',
    ];
}
