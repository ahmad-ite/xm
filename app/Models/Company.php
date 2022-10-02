<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;


   
    public $fillable = [
        'symbol',
        'name',
    ];


    public function setStartDateAttribute($input)
    {
        $this->attributes['start_date'] =
            Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
    }
    public function getStartDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)
            ->format(config('app.date_format'));
    }
}
