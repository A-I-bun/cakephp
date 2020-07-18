<?php
namespace App\Model\Validation;

use Cake\Validation\Validation;

class CustomValidation extends Validation {

  //画像サイズチェック用
  public static function imageSize($file, array $options) :bool {
    $size=$file['image']->getSize();
    return $size > 2000000;
  }

  //画像ファイルの確認
  public static function isImage($file) :bool{
    $file['image']->getClientMediaType();
    $file['image']->getClientFilename();
    $ext=pathinfo($file['image'],PATHINFO_EXTENSION);

    $mimeCheck=['image/gif','image/png','image/jpeg'];
    $extCheck=['gif','png','jpg','jpeg'];

   return !in_array((strtolower($mime)),$mimeCheck) && !in_array((strtolower($ext)),$extCheck);

    }
  }

