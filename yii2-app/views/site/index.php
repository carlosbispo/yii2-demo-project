<div class="page-inner">
    <div class="container">

        <header class="page-header">
            <h1 class="page-title">Discography </h1>
        </header>

        <div class="page-content">
            <div class="album_wrapper three column stackable doubling ui grid">
                <?php foreach ($albums as $album) :?>
                    <div class="column">
                        <div class="album">
                            <a href="/album?id=<?= $album->id ?>">
                                <img src="thumb/album/<?= $album->cover ?>" alt="">
                                <div class="overlay"></div>
                                <div class="overlay_title">
                                    <h2><?= $album->name ?></h2>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div> <!-- END .page-inner -->