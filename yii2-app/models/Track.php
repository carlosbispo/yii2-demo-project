<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track".
 *
 * @property integer $id
 * @property string $title
 *
 * @property TrackAlbum[] $trackAlbums
 * @property Album[] $albums
 */
class Track extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'track';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrackAlbums()
    {
        return $this->hasMany(TrackAlbum::className(), ['track_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['id' => 'album_id'])->viaTable('track_album', ['track_id' => 'id']);
    }
}
