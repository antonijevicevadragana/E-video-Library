<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;




class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'year',
        'running_h',
        'running_m',
        'rating',
        'image'
    ];

    public function genres(): BelongsToMany
    {
        //OVO JE QB I MOZETE DA SIRITE I WHERE USLOVIMA ORDERBY ITD.
        return $this->belongsToMany(Genre::class);
    }

    protected function runningTime(): Attribute
    {
        return Attribute::make(
            get: fn () => trim(($this->running_h ? ($this->running_h . " h ") : "") .
                ($this->running_m ? ($this->running_m . " min") : "")),
        );
    }

    public function writers(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_writer');
    }

    public function stars(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_star');
    }

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_director');
    }

    protected function imgSrc(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->image && Storage::disk('public')->exists($this->image)) ?
                Storage::url($this->image) : '/storage/film_images/film.png',
        );  // pristup slikama ako ih ima ili dodela default slike ako je nema
    }



    ///////////////////////

    protected function NameYear(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->rating . " " . $this->name . " " . $this->year),
        );
    }

    protected function NameYearFilm(): Attribute
    {
        return Attribute::make(
            get: fn () => ( $this->name ." " . "(" . $this->year .")"),
        );
    }

    protected function FilmRating(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->rating),
        );
    }


    public function scopeFilter($query, array $filters)
    {

        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('rating', 'like', '%' . request('search') . '%')
                ->orWhere('year', 'like', '%' . request('search') . '%')
                ;
        }

    }



//prosirujemo filmove sa relacijom za copies tabelu
public function copies(): HasMany {
    return $this->hasMany(Copy::class, 'film_id'); //film_id je kolona preko koje su u vezi, tj koja je strani kljuc u tabeli copies
 }


////sad dodato 

 public function records()
 {
     return $this->hasMany(Record::class, 'copy_id');  //filmovi su povezani sa evidencijom preko kolone copies i stranog kljuca copy_id
 }
 
   
}
