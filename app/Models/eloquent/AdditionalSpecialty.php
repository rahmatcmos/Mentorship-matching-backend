<?php

namespace App\Models\eloquent;

use Illuminate\Database\Eloquent\Model;

class AdditionalSpecialty extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'additional_specialty';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
