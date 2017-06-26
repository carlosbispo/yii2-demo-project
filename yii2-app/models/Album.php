<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "album".
 *
 * @property integer $id
 * @property string $name
 * @property string $release_date
 * @property string $cover
 * @property string $obs
 *
 * @property TrackAlbum[] $trackAlbums
 * @property Track[] $tracks
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'release_date', 'cover'], 'required'],
            [['release_date'], 'safe'],
            [['cover', 'obs'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'release_date' => 'Release Date',
            'cover' => 'Cover',
            'obs' => 'Obs',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrackAlbums()
    {
        return $this->hasMany(TrackAlbum::className(), ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTracks()
    {
        return $this->hasMany(Track::className(), ['id' => 'track_id'])->viaTable('track_album', ['album_id' => 'id']);
    }
}
