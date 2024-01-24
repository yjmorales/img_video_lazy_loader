# Image and Youtube Video lazy loader

This project lazy loads the videos and images present in html to speed up the loading of web pages. It also parses an
html containing search for images or YouTube videos. If you find them, modify those tags and replace them with
quick-to-load elements.

## How to lazy load a YouTube video.

There are two scenarios:

- To lazy-load the video directly on the web page.
- The html content either is part of a variable or db record, and before it's presented or rendered it must be mutated
  in order to lazy load the video.

### Scenario 1: Lazy-loading the video directly on the web page.

1. Include the following files:
    * `src/css/img_video_lazy_loader.css`
    * `src/js/img_video_lazy_loader.js`
      <br>
      <br>

2. Instantiate the function class **ImgVideoLazyLoader**:
    * `(new ImgVideoLazyLoader())`
      <br>
      <br>

3. Add the YouTube video to the html content:

```
<div class="lazy-loaded" data-video-id="YOUTUBE_VIDEO_ID_HERE" data-loader="youtubeLoader">
    <div class="embed-youtube-play" data-video-id="YOUTUBE_VIDEO_ID_HERE"></div>
    <img src="https://img.youtube.com/vi/YOUTUBE_VIDEO_ID_HERE/default.jpg" class="thumb" data-video-id="YOUTUBE_VIDEO_ID_HERE">
</div>
```     

### Scenario 2: Lazy Loading YouTube videos on a html content saved in a variable or db record.

1. First mutate the html content. 
```
<?php
    // (...)
    
    $html = "Html code here";
    $lazyLoader = new ImgVideoLazyLoader();
    $lazyLoader->lazyLoadIframe($html);
    
    // Now $html is ready to lazy-loading
    
    // (...)
>
```
2. Include the following files:
    * `src/css/img_video_lazy_loader.css`
    * `src/js/img_video_lazy_loader.js`
      <br>
      <br>

3. Instantiate the function class **ImgVideoLazyLoader**:
    * `(new ImgVideoLazyLoader())`
      <br>
      <br>





