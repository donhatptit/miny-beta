<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Elasticquent\ElasticquentTrait;

class Chemical extends Model
{
    use CrudTrait;
    use ElasticquentTrait;

    protected $table = 'chemicals';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['symbol', 'name_vi', 'name_eng', 'color','state', 'g_mol','kg_m3','boiling_point','melting_point','electronegativity','ionization_energy'];

    protected $indexSettings = [
        'analysis' => [
            'analyzer' => [
                'analyzer_symbol' => [
                    'type' => 'custom',
                    'tokenizer' => 'my_char_group',
                    "char_filter" => [],
                    'filter' => ['split_symbol','unique','lowercase'],
                ],
            ],
            'tokenizer' => [
                'my_char_group' => [
                    'type' => 'char_group',
                    'tokenize_on_chars' => ['digit','(',')','[',']','.']
                ]
            ],
            'filter' => [
                'split_symbol' => [
                    'type' => 'word_delimiter',
                    'generate_word_parts' => 'true',
                    'generate_number_parts' => 'true',
                    'split_on_case_change' => 'true',
                    'split_on_numerics' => 'false',
                    'stem_english_possessive' => 'false'
                ]
            ],
        ],
    ];
    protected $mappingProperties = array(
        'symbol' => array(
            'type' => 'text',
            'fielddata' =>  true,
            'analyzer' => 'analyzer_symbol',
//            'search_analyzer' => 'standard'
        ),
        'name_vi' => array(
            'type' => 'text',
            'analyzer' => 'standard'
        ),
    );
    public function getIndexName()
    {
        return 'chemicals';
    }
    public function getTypeName()
    {
        return '_doc';
    }
}
