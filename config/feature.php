<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 12/5/18
 * Time: 14:04
 */

return [
  'handle_media' => [
      'allow' => env('HANDLE_MEDIA', false)
  ],
  'handle_university' => [
      'allow' => env('FEATURE_HANDLE_UNIVERSITY', true)
  ]

];