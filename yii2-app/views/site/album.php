<?php
use yii\helpers\Json;

print_r($playlist);
?>

<div class="page-inner">
    <div class="container">
<header class="page-header">
    <div class="ui two column stackable grid">
        <div class="column">
            <h1 class="page-title"><?= $album->name?></h1>
        </div>
    </div>
</header>

<div class="page-content">
    <div class="stackable ui grid">
        <div class="five wide column">
            <div class="album-thumb">
                <img src="thumb/album/<?= $album->cover?>" alt="">
            </div>
            <div class="album-release">
                Release Date:  <span><?= $album->release_date?></span>
            </div>
        </div>
        <div class="eleven wide column">
            <div class="album-content">

                <div id="favoriteplay" class="box_content_wrapper">
                    <div class="box_content">
                        <div class="player_box dark_shadow">
                            <div class="player_area">
                                <script type="text/javascript">
                                    jQuery(document).ready(function($) {
                                        var myPlaylist = <?=
                                            Json::encode($playlist)
                                        ?>;
                                        $('.player_area').ttwMusicPlayer(myPlaylist, {
                                            autoPlay:false,
                                            tracksToShow:20,
                                            jPlayer:{
                                                swfPath:'assets/js' //You need to override the default swf path any time the directory structure changes
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        </div>