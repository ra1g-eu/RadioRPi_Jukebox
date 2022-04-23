<?php
$title = "JukeboxRPi - Vyhľadávanie pesničky";
include_once("header.php");

?>
<?php include_once("navigation.php");
if (isset($_POST['searchSongInput'])) {
    $searchedStringForm = $_POST['searchSongInput'];
    if (file_exists("jukeboxSongs.json")) {
        $allSong = file_get_contents("jukeboxSongs.json");
        $allSongs = json_decode($allSong, true);
        $searchedString = substr($searchedStringForm, strpos($searchedStringForm, ":") + 1);
        $searchedStringFiltered = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $searchedString)));
        if (!containsWord('autor:', $searchedStringForm) && !containsWord('skupina:', $searchedStringForm) && !containsWord('pesnicka:', $searchedStringForm) && !containsWord('nazov:', $searchedStringForm) && !containsWord('zaner:', $searchedStringForm))
        {
            foreach ($allSongs as $key => $songs) {
                $searchedSongTitle = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songTitle'])));
                $searchedSongName = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songName'])));
                $searchedSongBand = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songBand'])));
                $searchedSongArtist = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songArtist'])));
                $searchedSongGenre = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songGenre'])));
                if (!containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "",$searchedStringForm))), $searchedSongTitle) &&
                    !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "",$searchedStringForm))), $searchedSongName) &&
                    !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "",$searchedStringForm))), $searchedSongBand) &&
                    !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "",$searchedStringForm))), $searchedSongArtist) &&
                    !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "",$searchedStringForm))), $searchedSongGenre)) {
                    unset($allSongs[$key]);
                }
            }
        }
        else if (containsWord('nazov:', $searchedStringForm)) {
            foreach ($allSongs as $key => $songs) {
                if (!containsWord($searchedStringFiltered, trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songName']))))) {
                    unset($allSongs[$key]);
                }
            }
        }
        else if (containsWord('pesnicka:', $searchedStringForm)) {
            foreach ($allSongs as $key => $songs) {
                if (!containsWord($searchedStringFiltered, trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songTitle']))))) {
                    unset($allSongs[$key]);
                }
            }
        }
        else if (containsWord('skupina:', $searchedStringForm)) {
            foreach ($allSongs as $key => $songs) {
                if (!containsWord($searchedStringFiltered, trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songBand']))))) {
                    unset($allSongs[$key]);
                }
            }
        }
        else if (containsWord('autor:', $searchedStringForm)) {
            foreach ($allSongs as $key => $songs) {
                if (!containsWord($searchedStringFiltered, trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songArtist']))))) {
                    unset($allSongs[$key]);
                }
            }
        } else if (containsWord('zaner:', $searchedStringForm)) {
            foreach ($allSongs as $key => $songs) {
                if (!containsWord($searchedStringFiltered, trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songGenre']))))) {
                    unset($allSongs[$key]);
                }
            }
        }
    } else {
        $allSongs = [];
    }
}
/*if (isset($_POST['searchSongInput'])) {
    $searchedString = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $_POST['searchSongInput'])));
    $searchedSongTitle = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songTitle'])));
    $searchedSongName = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songName'])));
    $searchedSongBand = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songBand'])));
    $searchedSongArtist = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songArtist'])));
    if (containsWord($searchedString, $searchedSongTitle) || containsWord($searchedString, $searchedSongName) || containsWord($searchedString, $searchedSongBand) || containsWord($searchedString, $searchedSongArtist))
    {

    }
}*/

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
            <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
                <div class="card border-left-primary bg-transparent border-0 shadow-lg h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Počet pesničiek
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-white"><?= empty($allSongs) ? '0' : count($allSongs); ?></div>
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
            <h1 class="h3 mb-0 "><?= empty($allSongs) ? 'Žiadne pesničky neboli nájdené' : 'Všetky nájdené pesničky:'; ?></h1>
        </div>
        <div class="row justify-content-center">
            <?php if (!empty($allSongs)) { ?>
            <?php foreach ($allSongs as $key => $songs) { ?>
            <div class="col-xl-8 col-md-8 col-sm-12">
                <div class="card border-left-success bg-transparent border-0 shadow-lg mb-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">

                                <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">
                                    <?= $songs['songTitle'] ?></div>
                                <div class="text-md-left mb-0 font-weight-bold text-white">Názov:
                                    <span class="badge badge-pill badge-primary"><?= $songs['songName'] ?></span>
                                    <i class="fas fa-minus"></i> Autor(i): <span
                                            class="badge badge-pill badge-primary"><?= $songs['songArtist'] ?></span>
                                    <i class="fas fa-minus"></i> Žáner: <span
                                            class="badge badge-pill badge-primary"><?= $songs['songGenre'] ?></span>
                                    <i class="fas fa-minus"></i> Dĺžka: <span
                                            class="badge badge-pill badge-primary"><?php $decTime = $songs['songSeconds']/60; $decSeconds = substr($decTime, strpos($decTime, ".") + 1); $decMinutes = strtok($decTime, '.'); $seconds = ($decSeconds > 0) ? substr($decSeconds, 0, 2)*0.6 : 0; echo $decMinutes . ' minút(y) a ' . round($seconds, 0) . ' sekúnd'; ?></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <audio src="music/<?= $songs['songFileName'] ?>" controls preload="none"
                                       muted></audio>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            } ?>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once ("footer.php"); ?>
