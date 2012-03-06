<?php

/**
 * This is the model class for table "{{Upload}}".
 *
 * The followings are the available columns in table '{{Upload}}':
 * @property integer $id
 * @property integer $post_id
 * @property integer $file_type
 * @property string $url
 * @property integer $create_time
 * @property string $create_ip
 * @property integer $user_id
 * @property string $desc
 * @property string $token
 */
class Upload extends CActiveRecord
{
    const TYPE_UNKNOWN = 0;
    const TYPE_PICTURE = 1;
    const TYPE_FILE = 2;
    const TYPE_AUDIO = 3;
    const TYPE_VIDEO = 4;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Upload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{upload}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		    array('post_id, url', 'required'),
			array('post_id, file_type, create_time, user_id', 'numerical', 'integerOnly'=>true),
			array('url, desc', 'length', 'max'=>250),
			array('create_ip', 'length', 'max'=>15),
			array('token', 'length', 'max'=>32),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		    array(self::BELONGS_TO, 'Post', 'post_id'),
		    array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'post_id' => t('post_id'),
			'file_type' => t('file_type'),
			'url' => 'Url',
			'create_time' => t('create_time'),
			'create_ip' => t('create_ip'),
			'user_id' => t('user_id'),
			'desc' => t('file_description'),
			'token' => 'Token',
		);
	}

	protected function beforeSave()
	{
	    if ($this->getIsNewRecord()) {
	        $this->create_time = $_SERVER['REQUEST_TIME'];
	        $this->create_ip = BetaBase::getClientIp();
	    }
	    
	    return true;
	}
	
	protected function afterDelete()
	{
	    $filename = fbp($this->url);
	    unlink($filename);
	}
}