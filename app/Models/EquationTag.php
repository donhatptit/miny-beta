<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class EquationTag extends Model
{
    use Sluggable, SluggableScopeHelpers;

    protected $table = 'equation_tags';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name'];

    public function chemical_equations(){
        return $this->belongsToMany('App\Models\ChemicalEquation');
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
