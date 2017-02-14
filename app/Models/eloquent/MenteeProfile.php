<?php

namespace App\Models\eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenteeProfile extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mentee_profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'year_of_birth', 'address',
        'residence_id', 'email', 'linkedin_url', 'phone', 'cell_phone',
        'university_name', 'university_department_name', 'university_graduation_year',
        'is_employed', 'job_description', 'specialty_id', 'specialty_experience',
        'expectations', 'career_goals', 'reference'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function residence()
    {
        return $this->hasOne(Residence::class, 'id', 'residence_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function specialty()
    {
        return $this->hasOne(Specialty::class, 'id', 'specialty_id');
    }
}
