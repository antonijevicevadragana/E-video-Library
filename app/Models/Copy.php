<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Copy extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'film_id',
        'code',
        'active',
        'status'
    ];

    public function film(): BelongsTo {
        return $this->belongsTo(Film::class, 'film_id');
     }
     
     
     
     public function scopeFilter($query, array $filters)
     {
 
         if ($filters['search'] ?? false) {
             $query->where('name', 'like', '%' . request('search') . '%')
                 ->orWhere('code', 'like', '%' . request('search') . '%')
                 ->orWhere('active', 'like', '%' . request('search') . '%')
                 ;
         }
 
     }

    //  //relacija 1:1 sa records table  /record Model
    // public function record(): HasOne {
    //     return $this->hasOne(Record::class);
    //  }



    // public function records(): HasMany {
    //     return $this->hasMany(Record::class, 'recordes');
    //  }
     

     public function records()
     {
         return $this->hasMany(Record::class, 'copy_id'); //copy_id je strani kljuc na teblu copies(id)
     }

}
