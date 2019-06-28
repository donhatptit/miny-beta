<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Elasticquent\ElasticquentTrait;
//use Cviebrock\EloquentSluggable\Sluggable;
//use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class ChemicalEquation extends Model
{
    use CrudTrait;
    use ElasticquentTrait;
//    use Sluggable, SluggableScopeHelpers;

    protected $table = 'chemical_equations';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['equation', 'condition', 'execute', 'phenomenon','extra', 'created_by'];
    protected $mappingProperties = array(
        'equation' => array(
            'type' => 'text',
            'analyzer' => 'standard'
        )
    );
    public function getIndexName()
    {
        return 'equations';
    }
    public function getTypeName()
    {
        return '_doc';
    }
    public function equation_tags(){
        return $this->belongsToMany('App\Models\EquationTag');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attach($tag_id){
        $this->equation_tags()->attach($tag_id);
    }

    public function detach($tag_id){
        $this->equation_tags()->detach($tag_id);
    }

}
