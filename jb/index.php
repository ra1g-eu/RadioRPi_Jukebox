<?php
$title = "JukeboxRPi - Pesničky na želanie";
include_once("header.php");
include_once("navigation.php");
if(file_exists("jukeboxSongs.json")) {
    $allSong = file_get_contents("jukeboxSongs.json");
    $allSongs = (json_decode($allSong, true) != null) ? json_decode($allSong, true) : [];
} else {
    $allSongs = [];
}
?>
<div id="content">

    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Vitaj na JukeboxRPi</h1>
        </div>
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                <div class="card border-left-primary bg-transparent border-0 shadow-lg h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Počet pesničiek</div>
                                <div class="h5 mb-0 font-weight-bold  text-white"><?= $allSongs == null ? '0' : count($allSongs); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sort-numeric-up-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                <div class="card border-left-primary bg-transparent border-0 shadow-lg h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Vyber celý priečinok s pesničkami</div>
                                <form id="songUploadForm" name="songUploadForm" method="post" enctype="multipart/form-data">
                                    <input name="musicdir[]" id="songFileInput" class="form-control bg-transparent border-0" type="file" webkitdirectory multiple />
                                    <input type="submit" class="form-control-file btn-success rounded mt-2" name="uploadMusic" value="Nahrať priečinok" />
                                </form>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sort-numeric-up-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                <div class="card border-left-primary bg-transparent border-0 shadow-lg h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Vyber pesničky samostatne</div>
                                <form id="songUploadForm" name="songUploadForm" method="post" enctype="multipart/form-data">
                                    <input name="musicdir[]" id="songFileInput" class="form-control bg-transparent border-0" type="file" multiple />
                                    <input type="submit" class="form-control-file btn-success rounded mt-2" name="uploadMusic" value="Nahrať pesničky" />
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
            <h1 class="h3 mb-0 text-white">Všetky dostupné pesničky:</h1>
        </div>

        <div class="row justify-content-center">
        <?php if(file_exists("jukeboxSongs.json") && count($allSongs)>0) { ?>
            <?php foreach($allSongs as $key => $songs){  ?>
                <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 d-flex">
                    <div class="card border-left-success bg-transparent border-0 shadow-lg mb-4 flex-fill">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="font-weight-bold text-white text-uppercase mb-1">
                                        <?= $songs['songTitle'] ?></div>
                                    <div class="text-left mb-0 text-white ml-3">
                                        <li>Názov: <span class="badge badge-pill badge-primary"><?= $songs['songName'] ?></span></li>
                                        <li>Autor(i): <span class="badge badge-pill badge-primary"><?= $songs['songArtist'] ?></span></li>
                                        <li>Žáner: <span class="badge badge-pill badge-primary"><?= $songs['songGenre'] ?></span></li>
                                        <li>Dĺžka: <span class="badge badge-pill badge-primary"><?php $decTime = $songs['songSeconds']/60; $decSeconds = substr($decTime, strpos($decTime, ".") + 1); $decMinutes = strtok($decTime, '.'); $seconds = ($decSeconds > 0) ? substr($decSeconds, 0, 2)*0.6 : 0; echo $decMinutes . ' minút(y) a ' . round($seconds, 0) . ' sekúnd'; ?></span></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center mt-0 p-0 mb-2">
                            <audio src="music/<?= $songs['songFileName'] ?>" controls preload="none" muted></audio>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once("footer.php");?>
