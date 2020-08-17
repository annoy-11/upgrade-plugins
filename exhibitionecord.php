<link href="application/modules/Exhibition/externals/styles/video-js.min.css" rel="stylesheet">
<link href="application/modules/Exhibition/externals/styles/videojs.record.css" rel="stylesheet">
<link href="application/modules/Exhibition/externals/styles/style_webvideo.css" rel="stylesheet">
<?php if($_GET['media_type'] == 'video' || $_GET['media_type'] == 'audio'):?>
  <script src="application/modules/Exhibition/externals/scripts/video.min.js"></script>
  <script src="application/modules/Exhibition/externals/scripts/RecordRTC.js"></script>
  <script src="application/modules/Exhibition/externals/scripts/wavesurfer.min.js"></script>
  <script src="application/modules/Exhibition/externals/scripts/wavesurfer.microphone.min.js"></script>
  <script src="application/modules/Exhibition/externals/scripts/videojs.wavesurfer.min.js"></script>
  <script src="application/modules/Exhibition/externals/scripts/videojs.record.js"></script>
<?php elseif($_GET['media_type'] == 'image'):?>
  <script src="application/modules/Exhibition/externals/scripts/photo.min.js"></script>
  <script src="application/modules/Exhibition/externals/scripts/photojs.record.min.js"></script>
<?php endif;?>
  
  <style>
  /* change player background color */
  #myAudio {
      background-color: #f00;
  }
  </style>
  
<?php if($_GET['media_type'] == 'audio'):?>
<audio id="myAudio" class="video-js vjs-default-skin"></audio>

<script>
var player = videojs("myAudio",
{
    controls: true,
    width: 600,
    height: 300,
    plugins: {
        wavesurfer: {
            src: "live",
            waveColor: "black",
            progressColor: "#2E732D",
            debug: true,
            cursorWidth: 1,
            msDisplayMax: 20,
            hideScrollbar: true
        },
        record: {
            audio: true,
            video: false,
            maxLength: 20,
            debug: true
        }
    }
});
// error handling
player.on('deviceError', function()
{
    console.log('device error:', player.deviceErrorCode);
});

// user clicked the record button and started recording
player.on('startRecord', function()
{
    console.log('started recording!');
});

// user completed recording and stream is available
player.on('finishRecord', function()
{
    // the blob object contains the recorded data that
    // can be downloaded by the user, stored on server etc.
    if(parent.document.getElementById('exhibition_audio_file'))
    parent.document.getElementById('exhibition_audio_file').value = '';
    parent.recordedDataExhibition = player.recordedData;
    player.recorder.stopDevice(); 
    parent.removeImage();
    parent.removeLinkImage();
});
</script>
<?php elseif($_GET['media_type'] == 'video'):?>
  <video id="myVideo" class="video-js vjs-default-skin"></video>
  <script>
  var player = videojs("myVideo",
  {
      controls: true,
      width: 320,
      height: 240,
      controlBar: {
          volumeMenuButton: false
      },
      plugins: {
          record: {
              audio: false,
              video: true,
              maxLength: 50,
              debug: true
          }
      }
  });
  // error handling
  player.on('deviceError', function()
  {
      console.warn('device error:', player.deviceErrorCode);
  });
  player.on('error', function(error)
  {
      console.log('error:', error);
  });
  // user clicked the record button and started recording
  player.on('startRecord', function()
  {
      console.log('started recording!');
  });
  // user completed recording and stream is available
  player.on('finishRecord', function()
  {
      // the blob object contains the recorded data that
      // can be downloaded by the user, stored on server etc.
      console.log('finished recording: ', player.recordedData);
      if(parent.document.getElementById('exhibition_video_file'))
      parent.document.getElementById('exhibition_video_file').value = '';
      parent.recordedDataExhibition = player.recordedData;
      //parent.removeImage();
    //  parent.removeLinkImage();
      parent.document.getElementById('exhibition_video_file').value = '';
      parent.resetLinkData();
      player.recorder.stopDevice(); 
  });
  </script>
 <?php else:?>
  <video id="myImage" class="video-js vjs-default-skin"></video>
<script>
var player = videojs("myImage",
{
    controls: true,
    width: 320,
    height: 240,
    controlBar: {
        volumeMenuButton: false,
        fullscreenToggle: false
    },
    plugins: {
        record: {
            image: true,
            debug: true
        }
    }
});
// error handling
player.on('deviceError', function()
{
    console.warn('device error:', player.deviceErrorCode);
});
player.on('error', function(error)
{
    console.log('error:', error);
});
// snapshot is available
player.on('finishRecord', function(e)
{
    // the blob object contains the image data that
    // can be downloaded by the user, stored on server etc.
    parent.recordedDataExhibition = player.recordedData;
    player.recorder.stopDevice(); 
    parent.removeImage();
    parent.removeLinkImage();
    parent.removeFromurlImage();
});
</script>
<?php endif; ?>


