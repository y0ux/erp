<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvFile;

    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'checkExtensionByMimeType' => false, 'mimeTypes' => 'text/csv, text/plain'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->csvFile->saveAs('uploads/' . $this->csvFile->baseName . '.' . $this->csvFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
