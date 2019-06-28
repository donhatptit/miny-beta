<?php
/**
 * Created by PhpStorm.
 * User: duongnam
 * Date: 09/10/2018
 * Time: 23:36
 */

namespace App\Helper;


class ElasticsearchParams
{
    public static function equationSearchParam($chemical_left,$chemical_right,$size){
        $params = [
            'body' => [
                'from' => 0,
                'size' => $size,
                'query' => [
                    'bool' => [
                        'must' => [
                            'match' => [
                                'equation' => [
                                    'query' => $chemical_left." ".$chemical_right,
                                    "fuzziness" => "1",
                                    'operator' => 'and'
                                ]
                            ]
                        ]
                    ]
                ],

            ]
        ];
        return $params;
    }
    public static function equationMakeChemicalSearchParam($one_chemical,$size){
        $params = [
            'body' => [
                'from' => 0,
                'size' => $size,
                'query' => [
                    'bool' => [
                        'must' => [
                            'match' => [
                                'equation' => [
                                    'query' => $one_chemical,
                                    "fuzziness" => "1",
                                    'operator' => 'and'
                                ]
                            ]
                        ]
                    ]
                ],
                'sort' => [
                    '_score' =>  [
                        'order' => 'desc'
                    ]
                ]
            ]
        ];
        return $params;
    }
    public static function chemicalSearchParam($chemical,$size){
        $params = [
            'body' => [
                'from' => 0,
                'size' => $size,
                'query' => [
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $chemical,
                                "fields" => [ "symbol", "name_vi" ],
                                'fuzziness' => '2',
                                'operator' => 'and'
                            ]
                        ]
                    ]
                ],

                'sort' => [
                    '_script' => [
                        "script" => [
                            "lang" => "painless",
                            'source' => "doc['symbol'].length",
                        ],
                         "type" => "number",
                         "order" => "asc"
                    ]
                ]
            ]
        ];
        return $params;
    }
}