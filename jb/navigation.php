<div id="wrapper" class="">
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
            <div class="sidebar-brand-icon">
                <i class="fas fa-play-circle"></i>
            </div>
            <div class="sidebar-brand-text mx-3">JukeboxRPi</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?php if (preg_match("~\bindex.php\b~", $_SERVER['PHP_SELF'])) { echo 'active'; } else { echo ''; } ?>">
            <a class="nav-link" href="./">
                <i class="fas fa-fw fa-home"></i>
                <span>Domov</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <li class="nav-item <?php if (preg_match("~\boprojekte.php\b~", $_SERVER['PHP_SELF'])) { echo 'active'; } else { echo ''; } ?>">
            <a class="nav-link" href="../oprojekte.php">
                <i class="fas fa-fw fa-info-circle"></i>
                <span>O projekte</span></a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Jukebox
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-list"></i>
                <span>Playlist</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Vyber si playlist:</h6>
                    <a class="collapse-item <?php if (preg_match("~\bcreatePlaylist.php\b~", $_SERVER['PHP_SELF'])) { echo 'active'; } else { echo ''; } ?>" href="createPlaylist.php">Vytvori?? playlist</a>
                    <a class="collapse-item <?php if (preg_match("~\bmyplaylists.php\b~", $_SERVER['PHP_SELF'])) { echo 'active'; } else { echo ''; } ?>" href="myplaylists.php">Moje playlisty</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="../">
                <i class="fas fa-fw fa-arrow-left"></i>
                <span>RadioRPi</span></a>
        </li>
        <!--
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Stanice
        </div>

         Nav Item - Pages Collapse Menu
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-broadcast-tower"></i>
                <span>Slovensk?? r??di??</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Vyber si r??dio:</h6>
                    <a class="collapse-item <?php if (containsWord("cc=sk&n=Slovensk",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radia.php?cc=sk&n=Slovensk??">V??etky r??di??</a>
                    <a class="collapse-item" href="buttons.html">Pod??a po??tu hlasov</a>
                    <a class="collapse-item <?php if (containsWord("radiobytag.php?cc=SK",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radiobytag.php?cc=SK">Pod??a ????nru</a>
                </div>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-broadcast-tower"></i>
                <span>??esk?? r??di??</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Vyber si r??dio:</h6>
                    <a class="collapse-item <?php if (containsWord("cc=cz&n=%C4%8Cesk%C3%A9",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radia.php?cc=cz&n=??esk??">V??etky r??di??</a>
                    <a class="collapse-item" href="buttons.html">Pod??a po??tu hlasov</a>
                    <a class="collapse-item <?php if (containsWord("radiobytag.php?cc=CZ",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radiobytag.php?cc=CZ">Pod??a ????nru</a>
                </div>
            </div>
        </li>

        <div class="sidebar-card d-none d-lg-flex">
            <i class="fas fa-fw fa-3x fa-retweet sidebar-card-illustration mb-2"></i>
            <p class="text-center mb-2 text-white">Nevid???? ??iadne stanice? Obnov ich tu!</p>
            <button type="button" class="btn btn-light btn-sm" id="refreshStationsBtn">Obnovi?? stanice</button>
        </div>

        <hr class="sidebar-divider d-none d-md-block">
-->
        <div class="sidebar-card d-none d-lg-flex">
            <i class="fas fa-fw fa-3x fa-search sidebar-card-illustration mb-2"></i>
            <p class="text-center mb-2 text-white">Vyh??adaj si svoju ob????ben?? pesni??ku!</p>
        <form class="navbar-search" action="searchmusic.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Zadaj n??zov"
                       aria-label="Search" aria-describedby="basic-addon2" name="searchSongInput" required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column bg-gray-900">

        <nav class="navbar navbar-expand navbar-light bg-success topbar mb-4 static-top shadow">
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="searchmusic.php" method="post">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Zadaj n??zov pesni??ky..."
                           aria-label="Search" aria-describedby="basic-addon2" name="searchSongInput" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fas fa-bars text-dark"></i>
            </button>

            <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-2x fa-fw text-gray-900"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                     aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search" action="searchmusic.php" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                   placeholder="Zadaj pesni??ku" aria-label="Search"
                                   aria-describedby="basic-addon2" name="searchSongInput" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
                <button type="button" class="btn btn-sm bg-transparent" data-toggle="modal" data-target="#searchHelpModal">
                   <i class="fas fa-question-circle fa-2x fa-fw text-gray-900"></i>
                </button>
            </ul>
            <!-- Topbar Navbar -->
             </nav>
        <div class="modal fade" id="searchHelpModal" tabindex="-1" aria-labelledby="searchHelpModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-gray-900 border-0">
                    <div class="modal-header border-bottom-success">
                        <h5 class="modal-title text-white" id="searchHelpModalLabel">N??vod na vyh??ad??vanie pesni??iek pod??a k??????ov??ch slov</h5>
                    </div>
                    <div class="modal-body border-0">
                        <ul class="nav nav-tabs border-0 justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="nazov-tab" data-toggle="tab" data-target="#nazov" type="button" role="tab" aria-controls="nazov" aria-selected="true">Titulok</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pesnicka-tab" data-toggle="tab" data-target="#pesnicka" type="button" role="tab" aria-controls="pesnicka" aria-selected="false">Cel?? n??zov</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="zaner-tab" data-toggle="tab" data-target="#zaner" type="button" role="tab" aria-controls="zaner" aria-selected="false">????ner</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="skupina-tab" data-toggle="tab" data-target="#skupina" type="button" role="tab" aria-controls="skupina" aria-selected="false">Skupina</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="autor-tab" data-toggle="tab" data-target="#autor" type="button" role="tab" aria-controls="autor" aria-selected="false">Autor</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active text-white-50 ml-3" id="nazov" role="tabpanel" aria-labelledby="nazov-tab">
                                <hr class="bg-success">
                                <p class="mt-3">Vyh??adanie pod??a titulku pesni??ky:</p>
                                <ul>
                                    <li>nazov:</li>
                                </ul>
                                <p>Pr??klady pou??itia:</p>
                                <ul>
                                    <li class="font-weight-bold">nazov: Radioactive</li>
                                    <li class="font-weight-bold">nazov:radioact</li>
                                    <li class="font-weight-bold">nazov:radioactive</li>
                                    <li class="font-weight-bold">nazov:radio</li>
                                </ul>
                            </div>
                            <div class="tab-pane fade text-white-50 ml-3" id="pesnicka" role="tabpanel" aria-labelledby="pesnicka-tab">
                                <hr class="bg-success">
                                <p class="mt-3">Vyh??adanie pod??a cel??ho n??zvu pesni??ky:</p>
                                <ul>
                                    <li>pesnicka:</li>
                                </ul>
                                <p>Pr??klady pou??itia:</p>
                                <ul>
                                    <li class="font-weight-bold">pesnicka:imagine dragon radioactive</li>
                                    <li class="font-weight-bold">pesnicka:imaginedragonsradioactive</li>
                                    <li class="font-weight-bold">pesnicka:Radioactive</li>
                                    <li class="font-weight-bold">pesnicka:radio</li>
                                    <li class="font-weight-bold">pesnicka: Radio</li>
                                </ul>
                            </div>
                            <div class="tab-pane fade text-white-50 ml-3" id="zaner" role="tabpanel" aria-labelledby="zaner-tab">
                                <hr class="bg-success">
                                <p class="mt-3">Vyh??adanie pod??a ????nru pesni??ky:</p>
                                <ul>
                                    <li>zaner:</li>
                                </ul>
                                <p>Pr??klady pou??itia:</p>
                                <ul>
                                    <li class="font-weight-bold">zaner:hiphop</li>
                                    <li class="font-weight-bold">zaner:hip</li>
                                    <li class="font-weight-bold">zaner: hipho</li>
                                    <li class="font-weight-bold">zaner:rock</li>
                                    <li class="font-weight-bold">zaner: Pop</li>
                                </ul>
                            </div>
                            <div class="tab-pane fade text-white-50 ml-3" id="skupina" role="tabpanel" aria-labelledby="skupina-tab">
                                <hr class="bg-success">
                                <p class="mt-3">Vyh??adanie pod??a n??zvu skupiny:</p>
                                <ul>
                                    <li>skupina:</li>
                                </ul>
                                <p>Pr??klady pou??itia:</p>
                                <ul>
                                    <li class="font-weight-bold">skupina:dragons</li>
                                    <li class="font-weight-bold">skupina:imaginedragons</li>
                                    <li class="font-weight-bold">skupina: Imagine Dragons</li>
                                </ul>
                            </div>
                            <div class="tab-pane fade text-white-50 ml-3" id="autor" role="tabpanel" aria-labelledby="autor-tab">
                                <hr class="bg-success">
                                <p class="mt-3">Vyh??adanie pod??a autora pesni??ky:</p>
                                <ul>
                                    <li>autor:</li>
                                </ul>
                                <p>Pr??klady pou??itia:</p>
                                <ul>
                                    <li class="font-weight-bold">autor:ed sheeran</li>
                                    <li class="font-weight-bold">autor: Ed Sheeran</li>
                                    <li class="font-weight-bold">autor: sheeran</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Rozumiem</button>
                    </div>
                </div>
            </div>
        </div>
<?php
