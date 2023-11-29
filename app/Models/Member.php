<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'gender',
        'name',
        'surname',
        'b_date',
        'Membercode',
        'image'
    ];

    protected function FullNameMemeber(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->name . " " . $this->surname),
        );
    }

    protected function NameCodeMemeber(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->name . " " . $this->surname . "(". $this->Membercode.")"),
        );
    }


    //relacija 1:m - members(1): records(m)

    public function records(): HasMany {
        return $this->hasMany(Record::class, 'member_id');
     }

    

    public function scopeFilter($query, array $filters)
    {

        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('surname', 'like', '%' . request('search') . '%');
        }
    }


    public function finances(): HasMany {
        return $this->hasMany(Finance::class, 'member_id'); //member_id je kolona preko koje su u vezi, tj koja je strani kljuc u tabeli finances
     }
}
