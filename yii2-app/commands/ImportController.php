<?php

namespace app\commands;


use app\models\Album;
use app\models\Track;
use app\models\TrackAlbum;
use Yii;
use yii\console\Controller;
use yii\helpers\Json;

class ImportController extends Controller
{
    public function actionIndex() {
        TrackAlbum::deleteAll();
        Track::deleteAll();
        Album::deleteAll();

        $this->resetCounter('album');
        $this->resetCounter('track_album');
        $this->resetCounter('track');

        $data = Json::decode(file_get_contents('files/data.json'));

        foreach ($data['albums'] as $dAlbum) {
            $album = new Album();
            $album->load($dAlbum, '');
            $album->save();
            if (isset($dAlbum['tracks'])) {
                $i = 1;
                foreach ($dAlbum['tracks'] as $dTrack) {
                    $track = Track::findOne(['title' => $dTrack['title']]);
                    if ($track == null) {
                        $track = new Track();
                        $track->load($dTrack, '');
                        $track->save();
                    }
                    // Create connection
                    $trackAlbum = new TrackAlbum();
                    $trackAlbum->load($dTrack, '');
                    $trackAlbum->track_id = $track->id;
                    $trackAlbum->album_id = $album->id;
                    $trackAlbum->track_number = $i;
                    $trackAlbum->save();
                    $i++;
                    if ($trackAlbum->hasErrors()) {
                        echo Json::encode($trackAlbum->getErrors());
                    }
                }
            }
        }

        echo "Done!";
    }

    private function resetCounter($table) {
        $command = "ALTER TABLE $table AUTO_INCREMENT = 1";
        Yii::$app->db->createCommand($command)->execute();
    }
}