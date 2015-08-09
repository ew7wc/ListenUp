var duration = 1; // track the duration of the currently playing track
$(document).ready(function() {


  $('#api').bind('ready.rdio', function() {
  });
  
  $('#api').bind('playingTrackChanged.rdio', function(e, playingTrack, sourcePosition) {
    if (playingTrack) {
      duration = playingTrack.duration;
      $('#art').attr('src', playingTrack.icon);
      $('#track').text(playingTrack.name);
      $('#album').text(playingTrack.album);
      $('#artist').text(playingTrack.artist);
    }
  });
  $('#api').bind('positionChanged.rdio', function(e, position) {
    $('#position').css('width', Math.floor(100*position/duration)+'%');
  });

  $('#api').bind('queueChanged.rdio', function(e, newQueue) { 
    console.log('newQueue', newQueue); 
  }); 
  $('#api').rdio(playback_token);
  $('#previous').click(function() { $('#api').rdio().previous(); });
  $('#play').click(function() {  
    $('#api').rdio().play(); 
  });
  $('#pause').click(function() { $('#api').rdio().pause(); });
  $('#next').click(function() { $('#api').rdio().next(); });


});