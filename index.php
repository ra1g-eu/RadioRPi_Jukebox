<?php
$title = "RadioRPi - České a Slovenské rádiá";
include_once ("header.php");
include_once ("navigation.php");
$allStation = file_get_contents("allStations.json");
$allStations = json_decode($allStation, true);

$allTag = file_get_contents("allTags.json");
$allTags = json_decode($allTag, true);
?>
<div id="content">

    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Vitaj na RadioRPi</h1>
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
                                <div class="h5 mb-0 font-weight-bold text-white"><?= count($allStations); ?></div>
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
            <h1 class="h3 mb-0 text-white">Všetky dostupné rádiá:</h1>
        </div>
        <div class="row justify-content-center">
            <?php foreach($allStations as $key => $stations){  ?>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 d-flex">
                <div class="card border-left-danger bg-transparent border-0 shadow-lg mb-4 flex-fill">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="font-weight-bold text-white text-uppercase mb-1">
                                    <?= $stations['countrycode'] == 'CZ' ? '🇨🇿' : '🇸🇰'?> <?= $stations['name'] ?>
                                </div>
                                <div class="text-left mb-0 text-white ml-3">

                                        <?php if(strlen($stations['tags']) > 1){ ?>
                                        <li>Žánre: <span class="badge badge-pill badge-primary text-wrap"><?php $tags=explode(',',$stations['tags']); $tags2 = join(", ", array_splice($tags, count($tags) > 4 ? 3 : 0)); echo $tags2;  ?></span></li>
                                        <?php } ?>
                                        <li>Počet hlasov: <span class="badge badge-pill badge-primary"><?= $stations['votes']; ?></span></li>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center mt-0 p-0 mb-2">
                        <a href="playradio.php?cc=<?= $stations['countrycode']; ?>&n=<?= $stations['name']; ?>&id=<?= $stations['stationuuid']; ?>" class="stretched-link btn btn-block btn-link p-0 align-content-center"><i class="fas fa-play-circle fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once ("footer.php");?>
