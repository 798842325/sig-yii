<?php
/**
 * Created by PhpStorm.
 * User: yuer
 * Date: 16/8/23
 * Time: 14:15
 */
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $File;

    public function rules()
    {
        return [
            [['File'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload($savePath='')
    {
        if ($this->validate()) {
            $saveDir= '../../public/'.$savePath;
            if(!is_dir($saveDir))
            {
               if(mkdir($saveDir)){
                return '自动创建'.$savePath.'目录失败,请手动创建再试~';
               }

            }
            $saveName = md5($this->File->baseName). '.' . $this->File->extension;
            $this->File->saveAs($saveDir .$saveName);
            $data['savePath'] = '/public/'.$savePath.$saveName;
            $data['saveName'] = $saveName;
            $data['status'] = 1;
            return $data;
        } else {
            return false;
        }
    }
}