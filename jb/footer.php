<!-- Footer -->
<footer class="sticky-footer bg-gray-900 border-top border-success">
    <div class="container my-auto">
        <div class="copyright text-center text-white my-auto">
            <span><?= date("Y"); ?> <a href="https://radiorpi.ra1g.eu/jb" class="text-success">JukeboxRPi</a></span> |
            <span>Pi logo: <a href="https://icons8.com" class="text-success">Icons8</a></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../js/sb-admin-2.min.js"></script>
<script src="../js/sweetalert2.min.js"></script>

<?php if (containsWord('createPlaylist.php', $_SERVER['PHP_SELF'])) { ?>
    <script>
        $("button#submitNewPlaylist").click(function (e) {
            e.preventDefault();
            let plName = $("#playlistName");
            let plDesc = $("#playlistDesc");
            let plAuthor = $("#playlistAuthor");
            if (plName.val().length > 41 || plName.val().length < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Názov playlistu musí byť väčší ako 1 a menší ako 40. Tvoj názov má dĺžku: ' + plName.val().length,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.close();
                    } else {
                        Swal.close();
                    }
                })
            } else if (plDesc.val().length > 61 || plDesc.val().length < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Popis playlistu musí byť väčší ako 1 a menší ako 60. Tvoj popis má dĺžku: ' + plDesc.val().length,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.close();
                    } else {
                        Swal.close();
                    }
                })
            } else if (plAuthor.val().length > 21 || plAuthor.val().length < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Autor playlistu musí byť väčší ako 1 a menší ako 20. Tvoj autor má dĺžku: ' + plAuthor.val().length,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.close();
                    } else {
                        Swal.close();
                    }
                })
            } else {
                let formData = {
                    playlistName: plName.val(),
                    playlistDesc: plDesc.val(),
                    playlistAuthor: plAuthor.val(),
                };
                $.ajax({
                    url: 'playlistconfig.php?newPlaylist=true',
                    type: 'GET',
                    data: formData,
                    cache: false,
                })
                    .done(function (data) {
                        if (data == 'playlistSuccessfullyAdded') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Úspech!',
                                text: 'Tvoj playlist bol vytvorený!',
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "./myplaylists.php";
                                } else {
                                    window.location = "./myplaylists.php";
                                }
                            })
                        } else if (data == 'playlistListJsonDoesNotExist') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Súbor playlistList.json neexistuje! Vytvor ho v priečinku /jb/',
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                } else {
                                    window.location.reload();
                                }
                            })
                        } else if (data == 'errorPlaylistAlreadyExists') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Playlist už existuje. Skúste znova.',
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                } else {
                                    window.location.reload();
                                }
                            })
                        }
                    });
            }
        });
    </script>
<?php } ?>
<?php if (containsWord('myplaylists.php', $_SERVER['PHP_SELF']) && empty($_GET)) { ?>
    <script>
        $(document).ready(function () {
            $("#choosePlaylistModal").modal('show');
        });
    </script>
<?php } else if (containsWord('myplaylists.php', $_SERVER['PHP_SELF']) && !empty($_GET)) { ?>
    <script src="../js/player.js"></script>
    <script>
        let playlistArray = [];
        let player;
        $.getJSON("<?= trim($_GET['p']) ?>.json", function (data) {
            $.each(data, function (key, val) {
                playlistArray.push({
                    title: '' + val.songTitle + '',
                    file: '' + val.songFileName + '',
                    howl: null
                });
            });
            player = new Player(playlistArray);
            player.volume(document.getElementById("volumeBtnRange").value);
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#searchResult").empty();
            $("input#songSearchName").val('');
        });
    </script>
    <script>
        let playlistList = $("#playlistList");
        let playlistStatus = $("#playlistListStatus");

        function AddToPlaylist(string, songID) {
            if (string != null) {
                $.ajax({
                    url: 'playlistconfig.php?addToPlaylist=<?= trim($_GET['p']) ?>',
                    type: 'GET',
                    data: {"songAdd": string},
                    cache: false,
                })
                    .done(function (data) {
                        if ($('#playlistListStatus').length > 0) {
                            $('#playlistListStatus').hide();
                        }
                        let song = JSON.parse(data);
                        playlistList.append("<div class='col-12 m-0 p-0 d-flex'>" +
                            "<div class='card border-left-success bg-transparent border-0 shadow-lg mb-2 flex-fill'>" +
                            "<div class='card-body'>" +
                            "<div class='row align-items-center'>" +
                            "<div class='col-10'>" +
                            "<div class = 'font-weight-bold text-white text-uppercase mb-1'>" + song.songTitle + "</div>" +
                            "<div class = 'text-left mb-0 text-white ml-3'>" +
                            "<li>Dĺžka: <span class='badge badge-pill badge-primary'>" + toTime(song['songSeconds']) + "</span></li>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-2 text-right'>" +
                            "<span class='font-weight-bold text-lg text-white'>.</span>" +
                            "</div>" +
                            "</div></div></div></div>");
                        $("#songID" + songID + "").remove();
                    });
            }
        }

        function RemoveFromPlaylist(songId) {
            if (songId != null) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pozor!',
                    text: 'Skutočne vymazať pesničku?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Nie'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'playlistconfig.php?removeFromPlaylist=<?= trim($_GET['p']) ?>',
                            type: 'GET',
                            data: {"songId": songId},
                            cache: false,
                        })
                            .done(function (data) {
                                console.log(data);
                                if (data == 'nothingToRemove') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops!',
                                        text: 'Nie je nič na vymazanie!',
                                        showDenyButton: false,
                                        showCancelButton: false,
                                        confirmButtonText: 'OK',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        } else {
                                            window.location.reload();
                                        }
                                    })
                                } else {
                                    if ($('#playlistListStatus').length < 1) {
                                        $('#playlistListStatus').show();
                                    }
                                    $("#playlistSongId" + songId + "").remove();
                                }
                            });
                    } else {
                        Swal.close();
                    }
                })
            }
        }

        function toTime(seconds) {
            let date = new Date(null);
            date.setSeconds(seconds);
            return date.toLocaleTimeString("sk-SK").substr(3, 5);
        }
    </script>
    <script>
        $("input#songSearchName").keyup(function (e) {
            let songSearch = $("input#songSearchName").val();
            let searchRes = $("#searchResult");
            //console.log(songSearch);
            e.preventDefault();
            if (songSearch.length > 2 && songSearch.length < 21) {
                $.ajax({
                    url: 'playlistconfig.php?getSongs=true',
                    type: 'GET',
                    data: {"songSearch": songSearch},
                    cache: false,
                })
                    .done(function (data) {
                        searchRes.empty();
                        if (data === "SongNotFound") {
                            searchRes.html("<span class='text-center text-danger font-weight-bold text-lg'>Pesnička nenájdená!</span>");
                        } else {
                            $.each(JSON.parse(data), function (i, value) {
                                searchRes.append("<div class='col-xl-4 col-lg-6 col-md-8 col-sm-12 d-flex' id='songID" + i + "'>" +
                                    "<div class='card border-left-success bg-transparent border-0 shadow-lg mb-4 flex-fill'>" +
                                    "<div class='card-body'>" +
                                    "<div class='row align-items-center'>" +
                                    "<div class='col'>" +
                                    "<div class='font-weight-bold text-white text-uppercase mb-1'>" + value.songTitle +
                                    "</div>" +
                                    "<div class='text-left mb-0 text-white ml-3'>" +
                                    "<li>Názov: <span class='badge badge-pill badge-primary'>" + value.songTitle + "</span></li>" +
                                    "<li>Autor(i): <span class='badge badge-pill badge-primary'>" + value.songArtist + "</span></li>" +
                                    "<li>Žáner: <span class='badge badge-pill badge-primary'>" + value.songGenre + "</span></li>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "<div class='card-footer bg-transparent border-0 text-center mt-0 p-0 mb-2'>" +
                                    "<button class='btn btn-success' onclick='AddToPlaylist(" + JSON.stringify(value) + "," + i + ")'>Pridať do playlistu</button>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>");
                            })
                        }
                    });
            } else if (songSearch.length < 2) {
                searchRes.empty();
            }
        });
    </script>
<?php }
if (containsWord('index.php', $_SERVER['PHP_SELF'])) { ?>
    <script>
        $(document).ready(function () {
            $("form#songUploadForm").submit(function (e) {
                e.preventDefault();
                console.log($("input#songFileInput")[0].files.length);
                if ($("input#songFileInput")[0].files.length >= 1 || $("input#songFileInput")[1].files.length >=1) {
                    $.ajax({
                        xhr: function () {
                            let xhr = new window.XMLHttpRequest();
                            Swal.fire({
                                icon: 'info',
                                title: 'Nahrávam...',
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                html: '<div class="progress" style=" height: 30px;">' +
                                    '<div class="progress-bar bg-success" role="progressbar"></div>' + '</div>',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.close();
                                } else {
                                    Swal.close();
                                }
                            })
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    let percentComplete = ((evt.loaded / evt.total) * 100);
                                    $(".progress-bar").width(percentComplete + '%');
                                    //$(".progress-bar").html(percentComplete+'%');
                                } else {
                                    Swal.close();
                                }
                            }, false);
                            return xhr;
                        },
                        url: 'uploadmusic.php',
                        type: 'POST',
                        data: new FormData(this),
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $(".progress-bar").width('0%');
                        },
                    })
                        .done(function (data) {
                            console.log(data);
                            if (data === "uploadComplete") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Wow!',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'OK',
                                    text: 'Pesničky nahrané!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    } else {
                                        window.location.reload();
                                    }
                                })
                            } else if (data === "error") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'OK',
                                    text: 'Nastala chyba!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    } else {
                                        window.location.reload();
                                    }
                                })
                            } else if (data === "emptyUpload") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'OK',
                                    text: 'Nevybral si žiadne súbory na nahratie!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    } else {
                                        window.location.reload();
                                    }
                                })
                            }
                        });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        text: 'Vyber pesničky, ktoré chceš nahrať.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.close();
                        } else {
                            Swal.close();
                        }
                    })
                }
            });
        });
    </script>
<?php } ?>
</body>

</html>
<?php ?>
