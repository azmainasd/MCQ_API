<?php

namespace App\Models;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
    ];

    protected $dates = ['created_at', 'updated_at'];
    
    /**
     * Get all of the answer for the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answer()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
