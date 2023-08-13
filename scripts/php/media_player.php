<?php
$media_link_240p_resolution = "";
$media_link_360p_resolution = "";
$media_link_480p_resolution = "";
$media_link_720p_resolution = "";
$media_link_1080p_resolution = "";

echo <<<_END
<div class="container p-0">
	<video class="w-100" controls crossorigin playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg" data-plyr-config='{ "ratio": "16:9" }'>
		 <source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-576p.mp4" type="video/mp4" size="576">
			<source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-720p.mp4" type="video/mp4" size="720">
			<source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-1080p.mp4" type="video/mp4" size="1080">

			<!-- Caption files -->
			<track kind="captions" label="English" srclang="en" src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.en.vtt"
					default>
			<track kind="captions" label="Français" srclang="fr" src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.fr.vtt">
			<!-- Fallback for browsers that don't support the <video> element -->
			<a href="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-576p.mp4" download>Download</a>
	</video>
</div>
<!-- Plyr resources and browser polyfills are specified in the pen settings -->
_END;

// sources: https://github.com/sampotts/plyr / streaming: https://github.com/video-dev/hls.js/ , https://developer.mozilla.org/en-US/docs/Web/Guide/Audio_and_video_delivery/Live_streaming_web_audio_and_video, https://www.hlsplayer.org/