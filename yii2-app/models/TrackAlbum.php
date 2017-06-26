<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track_album".
 *
 * @property integer $album_id
 * @property integer $track_id
 * @property integer $track_number
 * @property integer $duration
 * @property string $obs
 * @property string mp3
 *
 * @property Album $album
 * @property Track $track
 */
class TrackAlbum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'track_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'track_id', 'track_number'], 'required'],
            [['album_id', 'track_id', 'track_number', 'duration'], 'integer'],
            [['obs', 'mp3'], 'string'],
            [['time'], 'safe'],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['album_id' => 'id']],
            [['track_id'], 'exist', 'skipOnError' => true, 'targetClass' => Track::className(), 'targetAttribute' => ['track_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'album_id' => 'Album ID',
            'track_id' => 'Track ID',
            'track_number' => 'Track Number',
            'duration' => 'Duration',
            'obs' => 'Obs',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::className(), ['id' => 'album_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrack()
    {
        return $this->hasOne(Track::className(), ['id' => 'track_id']);
    }

    public function setTime($time) {
        $duration = explode(":", $time);
        $minutes = (int)$duration[0];
        $seconds = (int)$duration[1];
        $this->duration = $minutes * 60 + $seconds;
    }
}
