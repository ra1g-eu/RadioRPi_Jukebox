<?php

// TO DO:
/*
 * createPlaylist.php
 *  - po vstupe zobrazit Swal alebo Modal okno s formularom na vytvorenie playlistu alebo vybratie existujuceho
 *  - po vytvoreni noveho -> vytvorit .json s nazvom playlistu, pridat detaily playlistu do playlistList.json
 *  - po vytvoreni noveho -> presmerovat na createPlaylist.php?pl=nazovplaylistu
 *  - po vybrati existujuceho -> presmerovat na createPlaylist.php?pl=nazovplaylistu
 *  - ulozit nazov playlistu do Cookies pre lepsi pristup -> pomocou cookies manipulovat s playlistom
 *  - vzdy existuje len jeden Cookie -> pouzivatel nemoze obsluhovat viacero playlistov naraz
 *  - ak chce obsluhovat iny, tak sa Cookie prepise
 *  - skopirovat playlist.php funkcionality pre pridavanie pesniciek, vymazavanie
 *  - pridat nove funkcie na editovanie nazvu playlistu, popisu, pridat tlacidlo na vymazanie playlistu
 *
 * myplaylists.php
 *  - po vstupe zobrazit Swal alebo Modal okno s formularom na vybratie playlistu
 *  - nacitat HowlerJs player, songy z .json playlistu
 *  - prehravat pesnicky dookola 👍
 */
?>
<?php
$title = "JukeboxRPi - Vytvoriť playlist";
include_once("header.php");
include_once("navigation.php");

?>
<div id="content">

    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class="h3 mb-0 text-white">Vytvor si nový playlist</h1>
        </div>
        <!-- Content Row -->
        <div class="row justify-content-center">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-12 col-sm-12 mb-4">
                <div class="card border-left-primary bg-transparent border-0 shadow-lg">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                    <form id="createPlaylist">
                                        <label for="playlistName" class="form-label mt-2 mb-0">Názov playlistu</label>
                                        <input type="text" class="form-control bg-transparent text-success border-success" id="playlistName" name="playlistName" placeholder="Relax..." maxlength="40" required >
                                        <label for="playlistDesc" class="form-label mt-2 mb-0">Popis playlistu</label>
                                        <input type="text" class="form-control bg-transparent text-success border-success" id="playlistDesc" name="playlistDesc" placeholder="Playlist na relaxačné večery..." maxlength="60" required>
                                        <label for="playlistAuthor" class="form-label mt-2 mb-0">Autor playlistu</label>
                                        <input type="text" class="form-control bg-transparent text-success border-success" id="playlistAuthor" name="playlistAuthor" placeholder="Ja, Michal, Rodina...." max="20" required>
                                        <button type="button" id="submitNewPlaylist" class="btn btn-success mt-3 float-right">Vytvoriť</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<?php include_once("footer.php");?>

