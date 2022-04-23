<!-- Footer -->
<footer class="sticky-footer bg-gray-900 border-top border-danger">
    <div class="container my-auto">
        <div class="copyright text-center text-white my-auto">
            <span><?= date("Y"); ?> <a href="https://radiorpi.ra1g.eu/" class="text-danger">RadioRPi</a></span> |
            <span>Pi logo: <a href="https://icons8.com" class="text-danger">Icons8</a></span>
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="js/sweetalert2.min.js"></script>

<?php if(containsWord('playradio.php', $_SERVER['PHP_SELF'])){ ?>
<script>
    $(document).ready(function(){
        radioLive.unload();
        radioLive.volume(0.5);
        radioLive.stop();
        $("#volumeRange").val("0.5");
        let playing = false;
        $("#playBtn").on("click", function(){
            if(playing){
                playing = false;
                $("#musicSpinner").removeClass("fa-spin");
                $("#playBtn").removeClass("btn-danger");
                $("#playBtn").addClass("btn-primary");
                $("#playBtn").html("Spustiť rádio");
                radioLive.stop();
            } else {
                playing = true;
                $("#musicSpinner").addClass("fa-spin");
                $("#playBtn").removeClass("btn-primary");
                $("#playBtn").addClass(" btn-danger");
                $("#playBtn").html("Pozastaviť rádio");
                radioLive.play();
                $.getJSON("<?= 'https://de1.api.radio-browser.info/json/url/'. $selectedStation['stationuuid']; ?>", function (result){
                    console.log(result);
                });
            }
        });
        $("#volumeRange").on("input", function() {
            radioLive.volume($("#volumeRange").val());
        });
        $("#newTabRadio").on("click", function() {
            playing = false;
            $("#musicSpinner").removeClass("fa-spin");
            $("#playBtn").removeClass("btn-danger");
            $("#playBtn").addClass("btn-primary");
            $("#playBtn").html("Spustiť rádio");
            radioLive.stop();
            radioLive.unload();
            $.getJSON("<?= 'https://de1.api.radio-browser.info/json/url/'. $selectedStation['stationuuid']; ?>", function (result){
                console.log(result);
            });
        });
    });
</script>
<?php } ?>
<script>
    $("button#refreshStationsBtn").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'refreshstations.php',
            type: 'POST',
            data: "refreshStationsALL200",
            cache: false,
        })
            .done(function (data) {
                console.log(data);
                if(data=='RefreshSuccess'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Úspech!',
                        text: 'Stanice úspešne obnovené!',
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
                } else if(data=='CZErrorTryAgain'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Nastala chyba! Znova obnovte stanice.',
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
                } else if(data=='SKErrorTryAgain'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Nastala chyba! Znova obnovte stanice.',
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
                } else if(data=='RefreshFailNotLongEnough'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Rádiá boli nedávno obnovené. Skús to za 12 hodín.',
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
                }
            });
    });
</script>
</body>

</html>
<?php ?>
