<?php
$title = "RadioRPi - Vyhľadávanie názvu rádia";
include_once ("header.php");

?>
<?php include_once ("navigation.php");
$allStation = file_get_contents("allStations.json");
$allStations = json_decode($allStation, true);
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
            <h1 class="h3 mb-0 text-white">Všetky nájdené rádiá:</h1>
        </div>
        <div class="row justify-content-center">
            <?php foreach($allStations as $key => $stations){
                if(isset($_POST['searchRadioInput'])){
                    if(containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'],"",$_POST['searchRadioInput']))),trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'],"",$stations['name']))))){ ?>
                <div class="col-xl-8 col-md-8 col-sm-12">
                    <div class="card border-left-danger bg-transparent border-0 shadow-lg mb-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">
                                        <?= $stations['countrycode'] == 'CZ' ? '🇨🇿' : '🇸🇰'?> <?= $stations['name'] ?></div>
                                    <div class="text-md-left mb-0 font-weight-bold text-white"><?= strlen($stations['tags']) > 1 ? 'Tagy:' : '' ?>
                                        <span class="badge badge-pill badge-primary"><?php $tags=explode(',',$stations['tags']); $tags2 = join(", ", array_splice($tags, count($tags) > 4 ? 3 : 0)); echo $tags2;  ?></span>
                                        <?= strlen($stations['tags']) > 1 ? '<i class="fas fa-minus"></i>' : '' ?> Počet hlasov: <span class="badge badge-pill badge-primary"><?= $stations['votes']; ?></span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="playradio.php?cc=<?= $stations['countrycode']; ?>&n=<?= $stations['name']; ?>&id=<?= $stations['stationuuid']; ?>" class="stretched-link btn btn-sm btn-primary">Pustiť rádio</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } } } ?>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once ("footer.php");?>
