<?php
$countryName = "";
if(isset($_GET['cc']) && isset($_GET['n'])){
    $countryCode = $_GET['cc'];
    $countryName = $_GET['n'];
    $ccStation = file_get_contents("".$countryCode."Stations.json");
    $ccStations = json_decode($ccStation, true);
}
$title = "RadioRPi - Vybrané " . $countryName . " rádiá";
include_once ("header.php");

?>
<?php include_once ("navigation.php");


?>
<div id="content">

    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Vybrané <?= $countryName ?> rádiá</h1>
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
                                    Počet rádio staníc</div>
                                <div class="h5 mb-0 font-weight-bold text-white"><?= count($ccStations); ?></div>
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
            <h1 class="h3 mb-0 text-white">Vyber si z dostupných rádií:</h1>
        </div>
        <div class="row">
            <?php foreach($ccStations as $key => $station){ ?>
                <div class="col-lg-4 mb-4">

                    <!-- Illustrations -->
                    <div class="card bg-transparent shadow-lg mb-4 border-primary">
                        <div class="card-header bg-transparent py-3 border-dark">
                            <h6 class="m-0 font-weight-bold text-primary"><?= $station['name']; ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-5 align-self-center text-center">
                                    <img class="card-img-top text-center" style="max-width: 100px" src="<?= $station['favicon']; ?>" alt="<?= $station['name']; ?>">
                                </div>
                                <div class="col-7">
                                    <ul class="list-group list-group-flush text-white">
                                        <li class="list-group-item bg-transparent">Počet hlasov: <span class="badge badge-pill badge-primary"><?= $station['votes']; ?></span></li>
                                        <li class="list-group-item bg-transparent">Bitrate: <span class="badge badge-pill badge-primary"><?= $station['bitrate']; ?></span></li>
                                        <li class="list-group-item bg-transparent">Žánre: <span class="badge badge-pill badge-primary"><?php $tags=explode(',',$station['tags']); $tags2 = join(", ", array_splice($tags, count($tags) > 4 ? 3 : 0)); echo $tags2;  ?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top border-dark text-center">
                            <a href="playradio.php?cc=<?= $station['countrycode']; ?>&n=<?= $station['name']; ?>&id=<?= $station['stationuuid']; ?>" class="stretched-link btn btn-sm btn-primary">Pustiť rádio</a>
                        </div>
                    </div>

                </div>
            <?php }  ?>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once ("footer.php");?>
