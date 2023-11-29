<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'member_id',
        'RentPrice',
        'DatePaidRentPrice',
        'deleyInDays',
        'costLate',
        'PaidCostLate',
        'DatePaidCostLate',
        'record_id'
        
    ];




    public function member(): BelongsTo {
        return $this->belongsTo(Member::class, 'member_id');
     }



    public function record(): BelongsTo {
        return $this->belongsTo(Record::class);
     
}


}
