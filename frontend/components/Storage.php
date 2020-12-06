<?php
// 1 Получить объект файла - UploadedFile
// 2 Посчитать хэш сумму tmp file
// 3 Составить имя из хэш суммы
// 4 Сохранить файл в папку с именем хэш суммы
// 5 Вернуть имя файла

namespace frontend\components;

use yii\base\Component;
use frontend\components\StorageInterface;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Storage extends Component implements StorageInterface
{
  public $filename;

  public function SaveUploadedFile(UploadedFile $file)
  {
    $path = $this->preparePath($file);

    if ($path && $file->saveAs($path)) {
      return $this->filename;
    }
  }

  public function preparePath(UploadedFile $file)
  {
    $this->filename = $this->getFileName($file);
    // 023/38/223425234252234133.jpg

    $path = $this->getStoragePath() . $this->filename;
    // /var/www/yii2/frontend/web/uploads/picture/023/38/223425234252234133.jpg

    $path = FileHelper::normalizePath($path);
    if (FileHelper::createDirectory(dirname($path))) {
      return $path;
    }
  }

  public function getFileName(UploadedFile $file)
  {
    // $file->tempname = tmp/csdf/fsdfsdf.jpg

    $hash = sha1_file($file->tempName); // 0d0fgd0g0g34dfg79.jpg

    $name = substr_replace($hash, '/', 2, 0); // 0d/0fgd0g0g34dfg79.jpg
    $name = substr_replace($name, '/', 5, 0); // 0d/0f/gd0g0g34dfg79.jpg

    return $name . '.' . $file->extension;
  }

  public function getStoragePath()
  {
    return Yii::getAlias(Yii::$app->params['storagePath']);
  }
  
  public function getFile(string $filename)
  {
    return Yii::getAlias(Yii::$app->params['storageUri']) . $filename;
  }
}