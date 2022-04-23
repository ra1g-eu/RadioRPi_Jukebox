<?php
function containsWord($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}

if (isset($_GET['getSongs']) && isset($_GET['songSearch'])) {
    $searchedStringForm = trim(strtolower($_GET['songSearch']));
    if (file_exists("jukeboxSongs.json")) {
        $allSong = file_get_contents("jukeboxSongs.json");
        $allSongs = json_decode($allSong, true);
        foreach ($allSongs as $key => $songs) {
            $searchedSongTitle = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songTitle'])));
            $searchedSongName = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songName'])));
            $searchedSongBand = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songBand'])));
            $searchedSongArtist = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songArtist'])));
            $searchedSongGenre = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $songs['songGenre'])));
            if (!containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $searchedStringForm))), $searchedSongTitle) &&
                !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $searchedStringForm))), $searchedSongName) &&
                !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $searchedStringForm))), $searchedSongBand) &&
                !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $searchedStringForm))), $searchedSongArtist) &&
                !containsWord(trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $searchedStringForm))), $searchedSongGenre)) {
                unset($allSongs[$key]);
            }
        }
        if (!empty($allSongs)) {
            echo json_encode($allSongs);
        } else {
            echo "SongNotFound";
        }

    }
}

if (isset($_GET['addToPlaylist'])) {
    $playlistId = trim($_GET['addToPlaylist']);
    $songToAdd = $_GET['songAdd'];
    if (!file_exists($playlistId . ".json")) {
        $file = fopen($playlistId . ".json", 'a+');
        fclose($file);
    }
    if (file_exists($playlistId . ".json")) {
        $file = file_get_contents($playlistId . ".json");
        if (empty($file)) {
            file_put_contents($playlistId . ".json", json_encode(['0' => $songToAdd]));
            echo json_encode($songToAdd);
        } else {
            $temparray = json_decode($file, true);
            array_push($temparray, $songToAdd);
            $jsondata = json_encode($temparray);
            file_put_contents($playlistId . ".json", $jsondata);
            echo json_encode($songToAdd);
        }
        updateSongCount($playlistId);
    }
}

function updateSongCount($playlistId){
    $playlistId = trim($playlistId);
    $songCount = json_decode(file_get_contents($playlistId . ".json"), true);
    $playlistList = json_decode(file_get_contents('playlistList.json'), true);
    $tempArrayP = array();
    foreach ($playlistList as $key => $plL) {
        if ($plL['playlistId'] == $playlistId) {
            $plL['playlistSongCount'] = count($songCount);
        }
        array_push($tempArrayP, $plL);
    }
    file_put_contents('playlistList.json', json_encode($tempArrayP));
}

if (isset($_GET['newPlaylist'])) {
    if ($_GET['newPlaylist'] == "true") {
        if (file_exists("playlistList.json")) {
            $file = file_get_contents('playlistList.json');
            if (empty($file)) {
                $defaultContent = [
                    "playlistId" => "vseobecnyplaylist_aaa1",
                    "playlistName" => "V\u0161eobecn\u00fd playlist",
                    "playlistFileName" => "generalPlaylist.json",
                    "playlistDesc" => "Z\u00e1kladn\u00fd playlist JukeboxRPi syst\u00e9mu",
                    "playlistAuthor" => "JukeboxRPi",
                    "playlistSongCount" => 0
                ];
                file_put_contents('playlistList.json', json_encode(['0' => $defaultContent]));
            } else {
                $newPlaylistName = trim(strtolower(str_replace([' ', ',', '&', '?', "'", ':', ';', '.', '#', '-', '_'], "", $_GET['playlistName']))) . "_" . uniqidReal(4);
                $newPlaylistArray = [
                    "playlistId" => $newPlaylistName,
                    "playlistName" => trim($_GET['playlistName']),
                    "playlistFileName" => $newPlaylistName . ".json",
                    "playlistDesc" => trim($_GET['playlistDesc']),
                    "playlistAuthor" => trim($_GET['playlistAuthor']),
                    "playlistSongCount" => 0
                ];
                $temparray = json_decode($file, true);
                array_push($temparray, $newPlaylistArray);
                $jsondata = json_encode($temparray);
                file_put_contents('playlistList.json', $jsondata);
                if (!file_exists($newPlaylistName . ".json")) {
                    $file = fopen($newPlaylistName . ".json", 'a+');
                    fclose($file);
                } else {
                    echo 'errorPlaylistAlreadyExists';
                }
                echo 'playlistSuccessfullyAdded';
            }
        } else {
            echo 'playlistListJsonDoesNotExist';
        }
    }
}

if (isset($_GET['removeFromPlaylist'])) {
    $playlistId = trim($_GET['removeFromPlaylist']);
    $songId = $_GET['songId'];
    if (file_exists($playlistId . ".json")) {
        $file = file_get_contents($playlistId . ".json");
        if (empty($file)) {
            echo 'nothingToRemove';
            //exit;
        } else {
            $allSongsToRemove = json_decode($file, true);
            unset($allSongsToRemove[$songId-1]);
            file_put_contents($playlistId . ".json", json_encode($allSongsToRemove));
        }
        updateSongCount($playlistId);
    }
}


function uniqidReal($lenght = 25)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}
