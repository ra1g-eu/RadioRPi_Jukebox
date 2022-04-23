<?php
function containsWord($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}
?>
<div id="wrapper" class="">
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-music"></i>
            </div>
            <div class="sidebar-brand-text mx-3">RadioRPi</div>
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
            <a class="nav-link" href="oprojekte.php">
                <i class="fas fa-fw fa-info-circle"></i>
                <span>O projekte</span></a>
        </li>
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="jb/">
                <i class="fas fa-fw fa-play-circle"></i>
                <span>JukeboxRPi</span></a>
        </li>
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Stanice
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-broadcast-tower"></i>
                <span>Slovenské rádiá</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Vyber si rádio:</h6>
                    <a class="collapse-item <?php if (containsWord("cc=sk&n=Slovensk",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radia.php?cc=sk&n=Slovenské">Všetky rádiá</a>
                    <a class="collapse-item <?php if (containsWord("radiobytag.php?cc=SK",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radiobytag.php?cc=SK">Podľa žánru</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-broadcast-tower"></i>
                <span>České rádiá</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Vyber si rádio:</h6>
                    <a class="collapse-item <?php if (containsWord("cc=cz&n=%C4%8Cesk%C3%A9",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radia.php?cc=cz&n=České">Všetky rádiá</a>
                    <a class="collapse-item <?php if (containsWord("radiobytag.php?cc=CZ",$_SERVER['REQUEST_URI'])) { echo 'active'; } else { echo ''; } ?>" href="radiobytag.php?cc=CZ">Podľa žánru</a>
                </div>
            </div>
        </li>
        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <i class="fas fa-fw fa-3x fa-retweet sidebar-card-illustration mb-2"></i>
            <p class="text-center mb-2 text-white">Nevidíš žiadne stanice? Obnov ich tu!</p>
            <button type="button" class="btn btn-light btn-sm" id="refreshStationsBtn">Obnoviť stanice</button>
        </div>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="sidebar-card d-none d-lg-flex">
            <i class="fas fa-fw fa-3x fa-search sidebar-card-illustration mb-2"></i>
            <p class="text-center mb-2 text-white">Vyhľadaj si svoju obľúbenú stanicu!</p>
        <form class="navbar-search" action="searchradio.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Zadaj názov"
                       aria-label="Search" aria-describedby="basic-addon2" name="searchRadioInput" required>
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

        <nav class="navbar navbar-expand navbar-light bg-danger topbar mb-4 static-top shadow">
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="searchradio.php" method="post">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Zadaj názov stanice..."
                           aria-label="Search" aria-describedby="basic-addon2" name="searchRadioInput" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars text-dark"></i>
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
                    <form class="form-inline mr-auto w-100 navbar-search" action="searchradio.php" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                   placeholder="Zadaj názov stanice..." aria-label="Search"
                                   aria-describedby="basic-addon2" name="searchRadioInput" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            </ul>
            <!-- Topbar Navbar -->
             </nav>
<?php
