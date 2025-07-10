<?php
date_default_timezone_set('Europe/Bratislava');

// Configuration
$refreshEnabled = true;
$refreshInterval = 43200; // 12 hours in seconds
$stationLimit = 200;

// Function to refresh stations
function refreshStations()
{
    // ... (your existing refreshStations function code) ...
}

// Check if we need to refresh stations
if ($refreshEnabled && file_exists('lastRefresh.json')) {
    $lastRefresh = json_decode(file_get_contents('lastRefresh.json'), true);
    $timeSinceRefresh = time() - $lastRefresh[0]['unixtime'];

    if ($timeSinceRefresh >= $refreshInterval) {
        refreshStations();
    }
}

// Load station data
$allStations = [];
if (file_exists('allStations.json')) {
    $allStations = json_decode(file_get_contents('allStations.json'), true);
}

// Get unique tags
$allTags = [];
if (file_exists('allTags.json')) {
    $allTags = json_decode(file_get_contents('allTags.json'), true);
    sort($allTags);
}

// Get unique countries
$countries = array_unique(array_column($allStations, 'countrycode'));
sort($countries);
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RadioRPi - České a Slovenské rádiá</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Howler.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>

    <style>
        :root {
            --primary: #dc3545;
            --dark: #1a1a1a;
            --light: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            color: var(--light);
            min-height: 100vh;
        }

        .station-card {
            background: rgba(30, 30, 30, 0.7);
            border-radius: 10px;
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
        }

        .station-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            border-color: var(--primary);
        }

        .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex: 1;
            padding: 1rem;
        }

        .card-footer {
            padding: 0.75rem;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .country-flag {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .player-container {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
            margin-bottom: 2rem;
        }

        .progress-container {
            height: 5px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin: 1rem 0;
        }

        .progress-bar {
            height: 100%;
            background: var(--primary);
            width: 0%;
            transition: width 0.1s linear;
        }

        .volume-slider {
            width: 100px;
        }

        .tag-badge {
            background: rgba(220, 53, 69, 0.2);
            color: #ff6b7d;
            transition: all 0.2s;
            margin: 0.1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .tag-badge:hover {
            background: var(--primary);
            color: white;
            cursor: pointer;
        }

        .now-playing {
            animation: pulse 2s infinite;
            border-color: var(--primary) !important;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .controls {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-lg {
            padding: 0.5rem 1.5rem;
        }

        .player-info {
            text-align: right;
        }

        .volume-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .station-count {
            font-size: 1.1rem;
        }

        .station-count .badge {
            font-size: 1.2rem;
            padding: 0.5rem 0.8rem;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <!-- Header -->
    <header class="mb-5 text-center">
        <h1 class="display-4 fw-bold mb-3">
            <img src="icon/android-icon-36x36.png" alt="RadioRPi"
                 class="me-2 img-fluid border-bottom border-2 border-danger">RadioRPi
        </h1>
        <p class="lead text-muted">Online rádio pre Českú a Slovenskú republiku</p>

        <div class="station-count mt-4">
            <span class="text-white">Počet staníc:</span>
            <span class="badge bg-danger"><?= count($allStations); ?></span>
        </div>
    </header>

    <!-- Player Controls -->
    <div class="player-container p-4 mb-5" id="playerControls" style="display: none;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 id="stationName" class="mb-3">
                    <span id="countryFlag" class="country-flag"></span>
                    <span id="currentStation">Vyberte stanicu</span>
                </h3>
                <div class="progress-container">
                    <div class="progress-bar" id="bufferProgress"></div>
                </div>
                <div class="controls">
                    <button class="btn btn-danger btn-lg" id="playBtn">
                        <i class="fas fa-play"></i> Prehrať
                    </button>
                    <button class="btn btn-outline-light" id="stopBtn">
                        <i class="fas fa-stop"></i>
                    </button>
                    <div class="volume-control">
                        <i class="fas fa-volume-up text-danger"></i>
                        <input type="range" class="form-range volume-slider" id="volumeSlider" min="0" max="1"
                               step="0.01" value="0.15">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 player-info">
                <div class="mt-4 mt-lg-0">
                    <div class="badge bg-dark text-light p-2 mb-2">
                        <i class="fas fa-headphones me-1"></i>
                        <span id="listenersCount">0</span> poslucháčov
                    </div>
                    <div class="mt-3" id="currentSong">Žiadna informácia o skladbe</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls and Filters -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="input-group">
                    <span class="input-group-text bg-dark border-dark text-light">
                        <i class="fas fa-search"></i>
                    </span>
                <input type="text" id="searchInput" class="form-control bg-dark border-dark text-light"
                       placeholder="Hľadať stanice...">
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-column flex-md-row">
                <select id="countryFilter" class="form-select bg-dark text-light border-dark mb-2 mb-md-0 me-md-2">
                    <option value="all">Všetky krajiny</option>
                    <?php foreach ($countries as $code): ?>
                        <option value="<?= $code ?>"><?= $code === 'CZ' ? 'Česká republika' : 'Slovensko' ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="tagFilter" class="form-select bg-dark text-light border-dark">
                    <option value="all">Všetky žánre</option>
                    <?php foreach ($allTags as $tag): ?>
                        <option value="<?= $tag ?>"><?= ucfirst($tag) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Stations Grid -->
    <div class="row g-4" id="stationsContainer">
        <?php foreach ($allStations as $station): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 station-col"
                 data-name="<?= strtolower($station['name']) ?>"
                 data-country="<?= $station['countrycode'] ?>"
                 data-tags="<?= strtolower($station['tags']) ?>"
                 data-uuid="<?= $station['stationuuid'] ?>">
                <div class="station-card h-100">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                        <span class="country-flag">
                                            <?= $station['countrycode'] === 'CZ' ? '🇨🇿' : '🇸🇰' ?>
                                        </span>
                                    <strong class="station-name"><?= $station['name'] ?></strong>
                                </div>
                                <div class="badge bg-dark">
                                    <i class="fas fa-users me-1"></i> <?= $station['votes'] ?>
                                </div>
                            </div>

                            <?php if (!empty($station['tags'])): ?>
                                <div class="mt-2 mb-2">
                                    <?php
                                    $tags = explode(',', $station['tags']);
                                    foreach (array_slice($tags, 0, 3) as $tag):
                                        ?>
                                        <span class="badge tag-badge"><?= trim($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-sm btn-outline-danger w-100 play-button"
                                    data-uuid="<?= $station['stationuuid'] ?>"
                                    data-name="<?= $station['name'] ?>"
                                    data-country="<?= $station['countrycode'] ?>">
                                <i class="fas fa-play me-1"></i> Prehrať
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Refresh Button -->
    <div class="mt-5 text-center">
        <button id="refreshStationsBtn" class="btn btn-outline-light">
            <i class="fas fa-sync me-1"></i> Obnoviť zoznam staníc
        </button>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>

<script>
    // Global variables
    let radioPlayer = null;
    let currentStation = null;
    let isPlaying = false;
    let reconnectAttempts = 0;
    const maxReconnectAttempts = 3;
    let updateSongInterval = null;

    // DOM elements
    const playerControls = document.getElementById('playerControls');
    const playBtn = document.getElementById('playBtn');
    const stopBtn = document.getElementById('stopBtn');
    const volumeSlider = document.getElementById('volumeSlider');
    const stationName = document.getElementById('currentStation');
    const countryFlag = document.getElementById('countryFlag');
    const bufferProgress = document.getElementById('bufferProgress');
    const listenersCount = document.getElementById('listenersCount');
    const currentSong = document.getElementById('currentSong');
    const searchInput = document.getElementById('searchInput');
    const countryFilter = document.getElementById('countryFilter');
    const tagFilter = document.getElementById('tagFilter');
    const stationsContainer = document.getElementById('stationsContainer');
    const refreshBtn = document.getElementById('refreshStationsBtn');

    // Initialize player
    function initPlayer() {
        // Setup event listeners for play buttons
        document.querySelectorAll('.play-button').forEach(button => {
            button.addEventListener('click', function () {
                const uuid = this.dataset.uuid;
                const name = this.dataset.name;
                const country = this.dataset.country;
                playStation(uuid, name, country);
            });
        });

        // Player controls
        playBtn.addEventListener('click', togglePlayback);
        stopBtn.addEventListener('click', stopPlayback);

        // Volume control
        volumeSlider.addEventListener('input', function () {
            if (radioPlayer) {
                radioPlayer.volume(parseFloat(this.value));
            }
        });

        // Setup filters
        searchInput.addEventListener('input', filterStations);
        countryFilter.addEventListener('change', filterStations);
        tagFilter.addEventListener('change', filterStations);

        // Refresh button
        refreshBtn.addEventListener('click', refreshStations);
    }

    // Play a station
    function playStation(uuid, name, country) {
        // Stop current playback if any
        if (radioPlayer) {
            radioPlayer.stop();
            radioPlayer.unload();
            radioPlayer = null;
        }

        // Clear previous song updates
        if (updateSongInterval) {
            clearInterval(updateSongInterval);
            updateSongInterval = null;
        }

        // Reset reconnect attempts
        reconnectAttempts = 0;

        // Show player controls
        playerControls.style.display = 'block';
        stationName.textContent = name;
        countryFlag.textContent = country === 'CZ' ? '🇨🇿' : '🇸🇰';
        currentStation = uuid;
        bufferProgress.style.width = '0%';

        // Highlight playing station
        document.querySelectorAll('.station-col').forEach(col => {
            col.classList.remove('now-playing');
        });
        document.querySelector(`.station-col[data-uuid="${uuid}"]`).classList.add('now-playing');

        // Get stream URL from Radio Browser API
        fetch(`https://de1.api.radio-browser.info/json/url/${uuid}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    const streamUrl = data.url;
                    startPlayback(streamUrl, name);
                } else {
                    showError('Stream URL not found');
                }
            })
            .catch(error => {
                console.error('Error fetching stream URL:', error);
                showError('Error connecting to radio service');
            });
    }

    // Start audio playback
    function startPlayback(url, name) {
        // Create new Howler instance
        radioPlayer = new Howl({
            src: [url],
            html5: true,
            format: ['mp3', 'aac'],
            volume: parseFloat(volumeSlider.value),
            onplay: () => {
                isPlaying = true;
                playBtn.innerHTML = '<i class="fas fa-pause"></i> Pozastaviť';
                playBtn.classList.remove('btn-danger');
                playBtn.classList.add('btn-warning');
                updateSongInfo();

                // Start periodic updates
                //updateSongInterval = setInterval(updateSongInfo, 30000);
            },
            onload: () => {
                bufferProgress.style.width = '100%';
            },
            onloaderror: (id, error) => {
                console.error('Load error:', error);
                attemptReconnect();
            },
            onplayerror: (id, error) => {
                console.error('Play error:', error);
                attemptReconnect();
            },
            onend: () => {
                console.log('Playback ended');
                attemptReconnect();
            }
        });

        // Start playback
        radioPlayer.play();
    }

    // Toggle play/pause
    function togglePlayback() {
        if (!radioPlayer) return;

        if (isPlaying) {
            radioPlayer.pause();
            playBtn.innerHTML = '<i class="fas fa-play"></i> Prehrať';
            playBtn.classList.remove('btn-warning');
            playBtn.classList.add('btn-danger');
            isPlaying = false;

            // Stop periodic updates
            if (updateSongInterval) {
                clearInterval(updateSongInterval);
                updateSongInterval = null;
            }
        } else {
            radioPlayer.play();
            playBtn.innerHTML = '<i class="fas fa-pause"></i> Pozastaviť';
            playBtn.classList.remove('btn-danger');
            playBtn.classList.add('btn-warning');
            isPlaying = true;

            // Start periodic updates
            updateSongInterval = setInterval(updateSongInfo, 30000);
        }
    }

    // Stop playback
    function stopPlayback() {
        if (radioPlayer) {
            radioPlayer.stop();
            radioPlayer.unload();
            radioPlayer = null;
        }

        isPlaying = false;
        playerControls.style.display = 'none';

        // Remove playing highlights
        document.querySelectorAll('.station-col').forEach(col => {
            col.classList.remove('now-playing');
        });

        playBtn.innerHTML = '<i class="fas fa-play"></i> Prehrať';
        playBtn.classList.remove('btn-warning');
        playBtn.classList.add('btn-danger');

        // Stop periodic updates
        if (updateSongInterval) {
            clearInterval(updateSongInterval);
            updateSongInterval = null;
        }
    }

    // Attempt to reconnect on failure
    function attemptReconnect() {
        if (reconnectAttempts < maxReconnectAttempts && currentStation) {
            reconnectAttempts++;
            console.log(`Reconnecting attempt ${reconnectAttempts}/${maxReconnectAttempts}`);

            // Show reconnecting status
            stationName.textContent = `${stationName.textContent} (pripája sa...)`;

            // Retry after delay
            setTimeout(() => {
                if (currentStation) {
                    const name = stationName.textContent.replace(' (pripája sa...)', '');
                    const country = countryFlag.textContent === '🇨🇿' ? 'CZ' : 'SK';
                    playStation(currentStation, name, country);
                }
            }, 3000);
        } else {
            showError('Connection lost. Please select station again.');
            stopPlayback();
        }
    }

    // Update song information
    function updateSongInfo() {
        if (!currentStation) return;

        fetch(`https://de1.api.radio-browser.info/json/stations/byuuid/${currentStation}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const station = data[0];

                    // Update listeners count
                    if (station.votes) {
                        listenersCount.textContent = station.votes;
                    }

                    // Update current song
                    if (station.title) {
                        currentSong.innerHTML = `<i class="fas fa-music me-1"></i> ${station.title}`;
                    } else {
                        currentSong.textContent = 'Žiadna informácia o skladbe';
                    }

                    // Update favicon
                    if (station.favicon) {
                        updateFavicon(station.favicon);
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching station info:', error);
            });
    }

    // Update favicon
    function updateFavicon(url) {
        const link = document.createElement('link');
        const oldLinks = document.querySelectorAll('link[rel="icon"]');

        link.rel = 'icon';
        link.href = url;

        oldLinks.forEach(oldLink => oldLink.remove());
        document.head.appendChild(link);
    }

    // Filter stations
    function filterStations() {
        const searchTerm = searchInput.value.toLowerCase();
        const country = countryFilter.value;
        const tag = tagFilter.value.toLowerCase();

        document.querySelectorAll('.station-col').forEach(station => {
            const name = station.dataset.name;
            const stationCountry = station.dataset.country;
            const tags = station.dataset.tags;
            const tagMatch = tag === 'all' || tags.includes(tag);
            const countryMatch = country === 'all' || stationCountry === country;
            const nameMatch = name.includes(searchTerm);

            if (nameMatch && countryMatch && tagMatch) {
                station.style.display = 'block';
            } else {
                station.style.display = 'none';
            }
        });
    }

    // Refresh stations
    function refreshStations() {
        refreshBtn.disabled = true;
        refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Obnovujem...';

        const formData = new FormData();
        formData.append('refreshStationsALL200', true);

        fetch('refreshstations.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data === 'RefreshSuccess') {
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showError('Error refreshing stations: ' + data);
                    refreshBtn.disabled = false;
                    refreshBtn.innerHTML = '<i class="fas fa-sync me-1"></i> Obnoviť zoznam staníc';
                }
            })
            .catch(error => {
                showError('Error refreshing stations');
                console.error(error);
                refreshBtn.disabled = false;
                refreshBtn.innerHTML = '<i class="fas fa-sync me-1"></i> Obnoviť zoznam staníc';
            });
    }

    // Show error message
    function showError(message) {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '11';

        toast.innerHTML = `
                <div id="liveToast" class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-danger text-white">
                        <strong class="me-auto">Chyba</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
        document.body.appendChild(toast);

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', initPlayer);
</script>
</body>
</html>