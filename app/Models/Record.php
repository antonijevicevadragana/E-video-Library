<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Record extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'copy_id',
        'member_id',
        'date_take',
        'date_expect_return',
        'returned',
        'returnDate',
        'finance_id'
        
    ];


     public function member(): BelongsTo {
        return $this->belongsTo(Member::class, 'member_id');
     }
  

     public function copy(): BelongsTo {
        return $this->belongsTo(Copy::class);
     }


     public function finance(): HasOne {
        return $this->hasOne(Finance::class);
     }
     
     
}

