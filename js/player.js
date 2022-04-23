/*!
 *  Howler.js Audio Player Demo
 *  howlerjs.com
 *
 *  (c) 2013-2020, James Simpson of GoldFire Studios
 *  goldfirestudios.com
 *
 *  MIT License
 */

// Cache references to DOM elements.
var elms = ['track', 'timer', 'duration', 'playBtn', 'pauseBtn', 'prevBtn', 'muteBtn', 'nextBtn', 'volumeBtnRange', 'progress', 'playlist', 'list', 'shuffleBtn'];
elms.forEach(function(elm) {
  window[elm] = document.getElementById(elm);
});

let isShuffle = false;

/**
 * Player class containing the state of our playlist and where we are in it.
 * Includes all methods for playing, skipping, updating the display, etc.
 * @param {Array} playlist Array of objects with playlist song details ({title, file, howl}).
 */
var Player = function(playlist) {
  this.playlist = playlist;
  this.index = 0;

  // Display the title of the first track.
  track.innerHTML = '1. ' + playlist[0].title;

  // Setup the playlist display.
  playlist.forEach(function(song) {
    var div = document.createElement('li');
    div.className = 'list-group-item bg-gray-900 rounded-0 border-success text-white btn text-left';
    div.innerHTML = playlist.indexOf(song)+1 + ". " +song.title;
    div.onclick = function() {
      player.skipTo(playlist.indexOf(song));
    };
    list.appendChild(div);
  });
};
Player.prototype = {
  /**
   * Play a song in the playlist.
   * @param  {Number} index Index of the song in the playlist (leave empty to play the first or current).
   */
  play: function(index) {
    var self = this;
    var sound;

    index = typeof index === 'number' ? index : self.index;
    var data = self.playlist[index];

    // If we already loaded this track, use the current one.
    // Otherwise, setup and load a new Howl.
    if (data.howl) {
      sound = data.howl;
    } else {
      sound = data.howl = new Howl({
        src: ['./music/' + data.file],
        html5: true, // Force to HTML5 so that the audio can stream in (best for large files).
        onplay: function() {
          // Display the duration.
          duration.innerHTML = self.formatTime(Math.round(sound.duration()));

          // Start updating the progress of the track.
          requestAnimationFrame(self.step.bind(self));
        },
        onend: function() {
          if(isShuffle){
            self.shuffle(true);
          } else {
            self.skip('next');
          }
        }
      });
    }

    // Begin playing the sound.
    sound.play();

    // Update the track display.
    track.innerHTML = (index + 1) + '. ' + data.title;


    // Keep track of the index we are currently playing.
    self.index = index;
    playBtn.disabled = true;
    pauseBtn.disabled = false;
  },

  /**
   * Pause the currently playing track.
   */
  pause: function() {
    var self = this;

    // Get the Howl we want to manipulate.
    var sound = self.playlist[self.index].howl;

    // Puase the sound.
    sound.pause();
    pauseBtn.disabled = true;
    playBtn.disabled = false;
  },

  /**
   * Skip to the next or previous track.
   * @param  {String} direction 'next' or 'prev'.
   */
  skip: function(direction) {
    var self = this;

    // Get the next track based on the direction of the track.
    var index = 0;
    if (direction === 'prev') {
      index = self.index - 1;
      if (index < 0) {
        index = self.playlist.length - 1;
      }
    } else {
      index = self.index + 1;
      if (index >= self.playlist.length) {
        index = 0;
      }
    }
    if(isShuffle){
      self.shuffle(true);
    } else {
      self.skipTo(index);
    }
  },

  shuffle: function(isActive) {
    var self = this;

    // Get the next track based on the direction of the track.
    var index = 0;
    if (isActive) {
      index = Math.floor(Math.random() * self.playlist.length);
      if(index<0)
      {
        index = self.playlist.length - 1;
      }
      if(index>=self.playlist.length)
      {
        index = 0;
      }
    }
    self.skipTo(index);
  },

  /**
   * Skip to a specific track based on its playlist index.
   * @param  {Number} index Index in the playlist.
   */
  skipTo: function(index) {
    var self = this;

    // Stop the current track.
    if (self.playlist[self.index].howl) {
      self.playlist[self.index].howl.stop();
    }

    // Reset progress.
    progress.style.width = '0%';

    // Play the new track.
    self.play(index);
  },

  /**
   * Set the volume and update the volume slider display.
   * @param  {Number} val Volume between 0 and 1.
   */
  volume: function(val) {
    var self = this;
    Howler.volume(val);
  },
  mute: function(val) {
    var self = this;
    Howler.volume(val);
  },
  /**
   * The step called within requestAnimationFrame to update the playback position.
   */
  step: function() {
    var self = this;

    // Get the Howl we want to manipulate.
    var sound = self.playlist[self.index].howl;

    // Determine our current seek position.
    var seek = sound.seek() || 0;
    timer.innerHTML = self.formatTime(Math.round(seek));
    progress.style.width = (((seek / sound.duration()) * 100) || 0) + '%';

    // If the sound is still playing, continue stepping.
    if (sound.playing()) {
      requestAnimationFrame(self.step.bind(self));
    }
  },
  /**
   * Format the time from seconds to M:SS.
   * @param  {Number} secs Seconds to format.
   * @return {String}      Formatted time.
   */
  formatTime: function(secs) {
    var minutes = Math.floor(secs / 60) || 0;
    var seconds = (secs - minutes * 60) || 0;

    return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
  }
};

// Bind our player controls.
playBtn.addEventListener('click', function() {
  player.play();
});
pauseBtn.addEventListener('click', function() {
  player.pause();
});
prevBtn.addEventListener('click', function() {
  player.skip('prev');
});
nextBtn.addEventListener('click', function() {
  player.skip('next');
});
volumeBtnRange.addEventListener('input', function(){
    player.volume(document.getElementById("volumeBtnRange").value);
})
let isMuted = false;
muteBtn.addEventListener('click', function(){
  if(isMuted){
    player.volume(document.getElementById("volumeBtnRange").value);
    muteBtn.classList.remove("fa-volume-mute");
    muteBtn.classList.add("fa-volume-up");
    isMuted = false;
  } else {
    player.volume(0);
    muteBtn.classList.remove("fa-volume-up");
    muteBtn.classList.add("fa-volume-mute");
    isMuted = true;
  }
})
shuffleBtn.addEventListener('click', function(){
  if(!isShuffle){
    shuffleBtn.classList.remove("btn-outline-primary");
    shuffleBtn.classList.add("btn-primary");
    isShuffle = true;
  } else {
    shuffleBtn.classList.remove("btn-primary");
    shuffleBtn.classList.add("btn-outline-primary");
    isShuffle = false;
  }
})