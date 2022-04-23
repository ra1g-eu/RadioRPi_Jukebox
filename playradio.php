<?php
$radioName = $_GET['n'];
$title = "RadioRPi - Počúvate rádio " . $radioName;
include_once("header.php");

?>
<?php
include_once("navigation.php");
$selectedStation = array();
$stationUuid = trim($_GET['id']);
if ($_GET['cc'] == 'CZ') {
    $station = file_get_contents("czStations.json");
    $stations = json_decode($station, true);
    foreach ($stations as $key => $station) {
        if (containsWord($stationUuid, $station['stationuuid'])) {
            $selectedStation = $station;
        }
    }

} else if ($_GET['cc'] == 'SK') {
    $station = file_get_contents("skStations.json");
    $stations = json_decode($station, true);
    $selectedStation = array();
    foreach ($stations as $key => $station) {
        if (containsWord($stationUuid, $station['stationuuid'])) {
            $selectedStation = $station;
        }
    }
}


?>
<div id="content">

    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Práve hrá stanica <?= $radioName; ?>:</h1>
        </div>
        <div class="row justify-content-center">

            <div class="col-12 mb-4">

                <!-- Illustrations -->
                <div class="card bg-transparent shadow-lg mb-4 border-primary">
                    <div class="card-header bg-transparent py-3 border-dark">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $selectedStation['name']; ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-5 align-self-center text-center">
                                <img class="card-img-top text-center" style="max-width: 100px"
                                     src="<?= $selectedStation['favicon']; ?>" alt="<?= $selectedStation['name']; ?>">
                            </div>
                            <div class="col-7">
                                <ul class="list-group list-group-flush text-white">
                                    <li class="list-group-item bg-transparent">Počet hlasov: <span
                                                class="badge badge-pill badge-primary"><?= $selectedStation['votes']; ?></span>
                                    </li>
                                    <li class="list-group-item bg-transparent">Bitrate: <span
                                                class="badge badge-pill badge-primary"><?= $selectedStation['bitrate']; ?></span>
                                    </li>
                                    <li class="list-group-item bg-transparent">Tagy: <span
                                                class="badge badge-pill badge-primary"><?php $tags = explode(',', $selectedStation['tags']);
                                            $tags2 = join(", ", array_splice($tags, count($tags) > 4 ? 3 : 0));
                                            echo $tags2; ?></span></li>
                                    <li class="list-group-item bg-transparent">Webová stránka: <span
                                                class="badge badge-pill badge-primary"><a
                                                    href="<?= $selectedStation['homepage']; ?>"
                                                    class="text-light"><?= $selectedStation['homepage']; ?></a></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <script>
                        let radioLive = new Howl({
                            src: ['<?= $selectedStation['url_resolved']; ?>'],
                            autoplay: false,
                            volume: 0.5,
                            html5: true
                        });
                    </script>
                    <div class="card-footer bg-transparent border-top border-dark text-center">
                        <i class="fas fa-music fa-fw fa-3x mb-3 mt-3 text-primary" id="musicSpinner"></i>
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="btn-group btn-group-sm border-dark">
                                        <button id="playBtn" type="button" class="btn btn-primary">Spustiť rádio
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6-lg">
                                <div class="card border-0 shadow-sm bg-transparent mt-4 text-white">
                                    <label for="customRange1" class="form-label">Hlasitosť</label>
                                    <input type="range" class="form-range" step="0.01" value="0.5" min="0" max="1"
                                           id="volumeRange">
                                    <p class="font-italic small mt-3 text-white">Po spustení rádia treba niekedy počkať
                                        až 10
                                        sekúnd pre načítanie dát.</p>
                                </div>
                            </div>
                        </div>
                        <?php if (parse_url($selectedStation['url_resolved'])['scheme'] == 'http') { ?>
                            <hr class="mt-3 mb-3 bg-danger">
                            <div class="row justify-content-center">
                                <div class="col-6-lg">
                                    <a href="<?= $selectedStation['url_resolved']; ?>" id="newTabRadio" target="_blank" type="button"
                                       class="btn btn-danger font-weight-bold">Klikni sem ak rádio nejde prehrať</a>
                                    <p class="font-italic mt-3 text-white">Rádiá na nezabezpečenom odkaze je niekedy
                                        nutné
                                        spúšťať v samostatnom okne.</p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once("footer.php"); ?>
