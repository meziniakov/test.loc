<?php

namespace \frontend\components;
use yii\web\UploadedFile;

class StorageInterface
{
  public function SaveUploadedFile(UploadedFile $file);

  public function getFile(string $filename);
}