<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusStudent extends Model
{
    /** @use HasFactory<\Database\Factories\StatusStudentFactory> */

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];


    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'status');
    }
}
