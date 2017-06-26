<?php

use yii\db\Migration;
use yii\db\Schema;

class m170322_193517_bd_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%album}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING.' NOT NULL',
            'release_date' => Schema::TYPE_DATE.' NOT NULL',
            'cover' => Schema::TYPE_TEXT.' NOT NULL',
            'obs' => Schema::TYPE_TEXT
        ]);

        $this->createTable('{{%track}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING
        ]);

        $this->createTable('{{%track_album}}', [
            'album_id' => Schema::TYPE_INTEGER,
            'track_id' => Schema::TYPE_INTEGER,
            'track_number' => Schema::TYPE_SMALLINT.' NOT NULL',
            'duration' => Schema::TYPE_INTEGER,
            'mp3' => Schema::TYPE_STRING,
            'obs' => Schema::TYPE_TEXT
        ]);

        $this->addForeignKey('track-album-album', '{{%track_album}}', 'album_id', '{{%album}}', 'id');
        $this->addForeignKey('track-album-track', '{{%track_album}}', 'track_id', '{{%track}}', 'id');
        $this->addPrimaryKey('track-album-pk', '{{%track_album}}', ['album_id', 'track_id']);
    }

    public function safeDown()
    {
       $this->dropTable('{{%track_album}}');
       $this->dropTable('{{%album}}');
       $this->dropTable('{{%track}}');

       return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
