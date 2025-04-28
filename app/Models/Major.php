<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'jenjang',
        'akreditasi',
        'kaprodi',
        'image',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'major_id');
    }
}
