"use strict";

/**
 * The iframe holding a YouTube video lazy-loading is done by replacing the respective iframe with a component, in this case a thumbnail image.
 * Once the user clicks over the thumbnail image the respective iframe is built and plays the video.
 *
 * @constructor
 */
function ImgVideoLazyLoader() {

    let videos = [];

    $(document).on('click', '.lazy-loaded .embed-youtube-play', function () {
        const videoId = $(this).data('video-id');
        if (!videos.includes($(this).data('video-id'))) {

            const $img = $(this).closest('.lazy-loaded').find('img.thumb');

            let iframe = document.createElement("iframe");
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allowfullscreen", "");
            iframe.setAttribute("allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture");
            // Important: add the autoplay GET parameter, otherwise the user would need to click over the YouTube video again to play it
            iframe.setAttribute("src", "https://www.youtube.com/embed/" + $img.data('videoId') + "?rel=0&showinfo=0&autoplay=1");
            $(this).closest('.lazy-loaded').append(iframe);
            $img.remove();
            $(this).remove();
            videos.push(videoId);
        }
    });

    $(document).on('click', '.lazy-loaded img.thumb', function () {
        const videoId = $(this).data('video-id');
        if (!videos.includes($(this).data('video-id'))) {
            let iframe = document.createElement("iframe");
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allowfullscreen", "");
            iframe.setAttribute("allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture");
            // Important: add the autoplay GET parameter, otherwise the user would need to click over the YouTube video again to play it
            iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.videoId + "?rel=0&showinfo=0&autoplay=1");
            // Clear Thumbnail and load the YouTube iframe
            $(this).closest('.lazy-loaded').append(iframe);
            $(this).closest('.lazy-loaded').find('.embed-youtube-play').remove();
            $(this).remove();
            videos.push(videoId);
        }
    });

    // Lazy Load Images Via lozad library.
    // @link: https://apoorv.pro/lozad.js/
    const observer = lozad();
    observer.observe();
}