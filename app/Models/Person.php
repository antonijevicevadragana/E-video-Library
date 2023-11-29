<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

//use Illuminate\Support\Facades\App;

class Person extends Model
{
    use HasFactory;

    //polja u tabeli, dodato
    protected $fillable = ['id', 'name', 'surname', 'b_date'];


    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->name . " " . $this->surname),
        );
    }

/////////////////////////////////////////////////////////////////////////////
    
    public function writers(): BelongsToMany {
        return $this->belongsToMany(Film::class, 'film_writer');
     }
     
     public function stars(): BelongsToMany {
        return $this->belongsToMany(Film::class, 'film_star');
     }

     public function directors(): BelongsToMany {
        return $this->belongsToMany(Film::class, 'film_director');
     }
 



    public function scopeFilter($query, array $filters)
    {

        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('surname', 'like', '%' . request('search') . '%');
        }
    }
}