<?php
require '../vendor/getid3/getid3.php';


function parseAndUploadSongs($songFile, $songFileName, $songPath, $songFileNameExtensionLess){
    $getID3 = new getID3;
    $ThisFileInfo = $getID3->analyze($songFile); //INFO PESNICKY
    $songTitle = !isset($ThisFileInfo['tags']['id3v2']['title'][0]) ? 'Nedostupné' : trim($ThisFileInfo['tags']['id3v2']['title'][0]);
    $songName = !isset($ThisFileInfo['tags']['id3v2']['subtitle'][0]) ? 'Nedostupné' : trim($ThisFileInfo['tags']['id3v2']['subtitle'][0]);
    $songBand = !isset($ThisFileInfo['tags']['id3v2']['band'][0]) ? 'Nedostupné' : trim($ThisFileInfo['tags']['id3v2']['band'][0]);
    $songGenre = !isset($ThisFileInfo['tags']['id3v2']['genre'][0])? 'Nedostupné' : trim($ThisFileInfo['tags']['id3v2']['genre'][0]);
    $songArtist = !isset($ThisFileInfo['tags']['id3v2']['artist'][0]) ? 'Nedostupné' : trim($ThisFileInfo['tags']['id3v2']['artist'][0]);
    $songSeconds = !isset($ThisFileInfo['playtime_seconds']) ? 'Nedostupné' : round($ThisFileInfo['playtime_seconds'], 0, PHP_ROUND_HALF_UP); //ZAOKRUHLI NAHOR

    if(file_exists('jukeboxSongs.json')){
        $file = file_get_contents('jukeboxSongs.json');
        if(empty($file)){ //TOTO POLE SA MOZNO DA INAK VYRIESIT // AK JE PRAZDNY JSON SUBOR TAK SPRAV TOTO, TO KVOLI FORMATOVANIU
            $songInfoArray = ['songTitle' => $songTitle == 'Nedostupné' ? $songFileNameExtensionLess : $songTitle,
                'songName' => $songName == 'Nedostupné' ? $songFileNameExtensionLess : $songName,
                'songBand' => $songBand,
                'songGenre' => $songGenre,
                'songArtist' => $songArtist,
                'songSeconds' => $songSeconds,
                'songFileName' => $songFileName,
                'songPath' => $songPath];
            file_put_contents('jukeboxSongs.json', json_encode(['0' => $songInfoArray]));
        } else {
            $songInfoArray = ['songTitle' => $songTitle == 'Nedostupné' ? $songFileNameExtensionLess : $songTitle,
                'songName' => $songName == 'Nedostupné' ? $songFileNameExtensionLess : $songName,
                'songBand' => $songBand,
                'songGenre' => $songGenre,
                'songArtist' => $songArtist,
                'songSeconds' => $songSeconds,
                'songFileName' => $songFileName,
                'songPath' => $songPath];
            $temparray = json_decode($file,true);
            array_push($temparray, $songInfoArray); //NACITAJ CELY JSON A HOD NA KONIEC NOVE POLE S NOVYM SONGOM
            $jsondata = json_encode($temparray);
            file_put_contents('jukeboxSongs.json', $jsondata); //ULOZ SUBOR
        }

    } else {
        $file = fopen('jukeboxSongs.json', 'a+');
        fclose($file);
    }

}

if(!empty($_FILES)){
    try {
        $jukeboxFile = fopen('jukeboxSongs.json', 'a+'); //??
            $totalFiles = count($_FILES['musicdir']['name']);
            //var_dump($_FILES);
            for( $i=0 ; $i < $totalFiles ; $i++ ) { //PRECHADZANIE KAZDEHO SUBORU PODLA POCTU SUBOROV
                if($_FILES['musicdir']['type'][$i] == 'audio/mpeg' || $_FILES['musicdir']['type'][$i] == 'audio/x-m4a'){ //AK JE AUDIO
                    if($_FILES['musicdir']['size'][$i] < 10182632){ //AK JE MENSIE AKO 10MB +/-
                        $inf = pathinfo($_FILES['musicdir']['name'][$i]); // KONCOVKA SUBORU (MP3 ALEBO MP4 ??)
                        $fileName = $_FILES['musicdir']['name'][$i]; //NAZOV (mojapesnicka.mp3)
                        parseAndUploadSongs($_FILES['musicdir']['tmp_name'][$i], $fileName, '/jb/music/'.$fileName, $inf['filename']); //FUNKCIA VYSSIE
                        move_uploaded_file($_FILES['musicdir']['tmp_name'][$i], '../jb/music/'.$fileName); //PRESUN DOCASNEHO SUBORU DO PRIECINKA NATRVALO
                    }
                }
            }
        fclose($jukeboxFile);
        //header("Location: ./?result=success"); //VYUZIJE SA NESKOR
        echo 'uploadComplete';
    } catch (Exception){
        echo 'error';
    }
} else {
    echo 'emptyUpload';
}