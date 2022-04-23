<?php
$title = "JukeboxRPi - Playlist";
include_once("header.php");
include_once("navigation.php");
if(!empty($_GET)){
    if(file_exists($_GET['p'].".json")){
        $playlistSong = file_get_contents(trim($_GET['p']).".json");
        $playlistSongs = (json_decode($playlistSong, true) != null) ? json_decode($playlistSong, true) : [];
?>
<div id="content">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Audio prehrávač:</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-12 col-sm-12 d-flex mt-1">
                <div class="card border-left-success bg-transparent border-0 shadow-lg mb-2 flex-fill">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="font-weight-bold text-white text-uppercase mb-1">Aktuálna pesnička</div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="font-weight-bold text-white-50 mb-1"><span id="track"></span> (<span id="timer">0:00</span> / <span id="duration">0:00</span>)</div>
                            </div>
                        </div>
                    </div>
                    <div class="align-bottom">
                        <div class="progress bg-dark mt-2 rounded-0">
                            <div id="progress" class="progress-bar bg-success" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 text-center align-self-center mt-1">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <i class="fas fa-volume-up fa-2x text-primary" id="muteBtn"></i>
                    </div>
                    <div class="col-12 p-2">
                        <input type="range" class="form-range" id="volumeBtnRange" step="0.01" value="0.5" min="0" max="1">
                    </div>
                    <div class="col-12">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" id="prevBtn"><i class="fas fa-step-backward fa-2x"></i></button>
                            <button type="button" class="btn btn-primary" id="playBtn"><i class="fas fa-play fa-2x"></i></button>
                            <button type="button" class="btn btn-primary" id="pauseBtn"><i class="fas fa-pause fa-2x"></i></button>
                            <button type="button" class="btn btn-primary" id="nextBtn"><i class="fas fa-step-forward fa-2x"></i></button>
                        </div>
                    </div>
                    <div class="col-12 mt-1">
                        <button type="button" class="btn btn-outline-primary" id="shuffleBtn"><i class="fas fa-random fa-2x"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 mt-1">
                <div id="playlist" class="text-primary">
                    <ul id="list" class="list-group" style="max-height: 200px;overflow-y:auto;">
                        <li class="list-group-item active rounded-top font-weight-bolder">Zoznam pesničiek</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4 mt-4">
            <h1 class="h3 mb-0 text-white">Pridaj pesničky do playlistu</h1>
        </div>
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                <div class="card border-left-primary bg-transparent border-0 shadow-lg h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Počet pesničiek</div>
                                <div class="h5 mb-0 font-weight-bold  text-white"><?= $playlistSongs == null ? '0' : count($playlistSongs); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sort-numeric-up-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                <div class="card border-left-primary bg-transparent border-0 shadow-lg h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Vyhľadaj pesničku a pridaj ju do playlistu</div>
                                <form enctype="multipart/form-data">
                                    <input name="songSearchName" id="songSearchName" class="form-control bg-transparent border-success" type="text"/>
                                </form>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sort-numeric-up-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Nájdené pesničky:</h1>
        </div>

        <div class="row justify-content-center" id="searchResult">
        </div>

        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Playlist:</h1>
        </div>

        <div class="row justify-content-center" id="playlistList">
            <?php if(file_exists("jukeboxSongs.json") && count($playlistSongs)>0) { ?>
                <?php foreach($playlistSongs as $key => $songs){  ?>
                    <div class="col-12 m-0 p-0 d-flex" id="playlistSongId<?=$key+1;?>">
                        <div class="card border-left-success bg-transparent border-0 shadow-lg mb-2 flex-fill">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="font-weight-bold text-white text-uppercase mb-1"><?= $songs['songTitle'] ?></div>
                                        <div class="text-left mb-0 text-white ml-3">
                                            <li>Dĺžka: <span class="badge badge-pill badge-primary"><?php $decTime = $songs['songSeconds']/60; $decSeconds = substr($decTime, strpos($decTime, ".") + 1); $decMinutes = strtok($decTime, '.'); $seconds = ($decSeconds > 0) ? substr($decSeconds, 0, 2)*0.6 : 0; echo $decMinutes . ' minút(y) a ' . round($seconds, 0) . ' sekúnd'; ?></span></li>
                                        </div>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="font-weight-bold text-lg text-white"><?= $key+1; ?>.</span>
                                        <button type="button" id="removeFromPlaylist" onclick="RemoveFromPlaylist(<?= $key+1; ?>)" class="btn btn-sm btn-outline-light border-0"><i class="fas fa-times-circle fa-2x text-danger"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <span class="text-center text-danger font-weight-bold text-lg" id="playlistListStatus">Playlist zatiaľ neobsahuje pesničky!</span>
            <?php } ?>
        </div>
    </div>
</div>
<?php } } ?>

<div class="modal fade" id="choosePlaylistModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-gray-900 border-0">
            <div class="modal-header border-bottom-success">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Vyber si playlist</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-hover table-striped table-borderless table-active table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Názov</th>
                        <th scope="col">Pesničky</th>
                        <th scope="col">Akcia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($_GET)){
                        if(file_exists("playlistList.json")) {
                            $playlistList = file_get_contents("playlistList.json");
                            $playlistLists = (json_decode($playlistList, true) != null) ? json_decode($playlistList, true) : [];
                        } else {
                            $playlistLists = [];
                        }
                        if(count($playlistLists)>0){
                            foreach ($playlistLists as $key => $playlist){
                        ?>
                    <tr>
                        <th scope="row"><?= $key+1; ?></th>
                        <td class="text-wrap"><?= $playlist['playlistName']; ?><sup class="badge rounded-pill bg-success text-black-50 ml-1"><?= $playlist['playlistAuthor']; ?></sup></td>
                        <td><?= $playlist['playlistSongCount']; ?></td>
                        <td><a class="btn btn-primary btn-sm btn-block text-center" href="myplaylists.php?p=<?= $playlist['playlistId']; ?>"><i class="fas fa-external-link-alt text-center"></i></a></td>
                    </tr>
                    <?php } } } ?>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button onclick="window.location='./createPlaylist.php'" type="button" class="btn btn-success">Vytvoriť playlist</button>
                <button type="button" class="btn btn-danger" onclick="window.location='./'">Zatvoriť</button>
            </div>
        </div>
    </div>
</div>
<?php include_once("footer.php");?>
