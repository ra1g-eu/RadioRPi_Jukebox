<?php
$title = "RadioRPi - O projekte";
include_once("header.php");
include_once("navigation.php");
?>
<div id="content">
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">O čom je tento projekt?</h1>
        </div>
        <div class="row justify-content-center m-5">
            <div class="col-xl-8 col-md-8 col-sm-12 text-white">
                <p>Projekt vznikol pre úspešné ukončenie predmetu Kybernetika, kognitívne systémy a internet vecí na UKF
                    v Nitre. Cieľom projektu je vytvoriť systém
                    na prehrávanie internetových rádií a lokálnych mp3 súborov. Systém bude spustený na platforme
                    Raspberry Pi, preto aj názov RadioRPi.</p>
                <hr class="bg-danger">
                <p>Autori projektu:</p>
                <ul>
                    <li>Bc. Richard G.</li>
                    <li>Bc. Jakub H.</li>
                    <li>Bc. Andrej B.</li>
                </ul>
                <hr class="bg-danger">
                <p>Štart projektu: <span class="font-weight-bold">01.03.2022</span></p>
                <p>Plánované ukončenie projektu: <span class="font-weight-bold">Koniec apríla 2022</span></p>
            </div>
        </div>
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Vývoj projektu:</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-8 col-sm-12">
                <div class="card border-left-danger bg-transparent border-0 shadow-lg mb-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Marec 2022</div>
                                <div class="text-md-left mb-0 font-weight-bold text-white">
                                    <ul>
                                        <li>Vytvorenie prototypu systému <i class="fas fa-check text-success"></i></li>
                                        <li>Vytvoriť dizajn systému <i class="fas fa-check text-success"></i></li>
                                        <li>Použiť verejnú Radio API <i class="fas fa-check text-success"></i></li>
                                        <li>Rozdelenie rádií do kategórií <i class="fas fa-check text-success"></i></li>
                                        <li>Prehrávanie rádií <i class="fas fa-check text-success"></i></li>
                                        <li>Vyhľadávanie rádií <i class="fas fa-check text-success"></i></li>
                                        <li>Vytvoriť dizajn audioprehrávača <i
                                                    class="fas fa-spinner fa-spin text-primary"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-left-danger bg-transparent border-0 shadow-lg mb-3 mt-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Apríl 2022 (plánované)</div>
                                <div class="text-md-left mb-0 font-weight-bold text-white">
                                    <ul>
                                        <li>Vytvoriť prototyp jukeboxu <i
                                                    class="fas fa-check text-success"></i></li>
                                        <li>Vytvoriť systém nahrávania mp3 súborov <i
                                                    class="fas fa-check text-success"></i></li>
                                        <li>Získať metadáta z mp3 súboru <i
                                                    class="fas fa-check text-success"></i></li>
                                        <li>Vytvoriť rozhranie pre zoznam pesničiek <i
                                                    class="fas fa-check text-success"></i></li>
                                        <li>A iné... <i
                                                    class="fas fa-spinner fa-spin text-primary"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-start mb-2">
                    <p class="lead mb-0 text-white">Progres vývoja:</p>
                </div>
                <div class="progress mb-4" style="height: 25px;">
                    <div class="progress-bar bg-danger text-center" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once("footer.php"); ?>
