<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * Class Student
 * @package App
 */
class Student extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'students';

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name;
    }

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    /**
     * @return HasMany
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
}
