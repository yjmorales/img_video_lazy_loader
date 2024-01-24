<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Core\LazyLoad;

use DOMDocument;
use DOMException;

/**
 * This class parses an HTML and replaces the images and videos tags by the respective lazy-loader content.
 */
class ImgVideoLazyLoader
{
    /**
     * Adds the respective static component that replace the iframe generated by those YouTube videos.
     *
     * @param string|null $html
     *
     * @return string|null
     * @throws DOMException
     */
    public static function lazyLoadIframe(?string $html): ?string
    {
        // Sanitizing html
        if (null === $html) {
            return null;
        }
        if ('' === $html) {
            return $html;
        }

        // Adding .lazy class and data-src
        $doc = new DOMDocument();
        @$doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $iFrames = $doc->getElementsByTagName('iframe');

        if (!$iFrames->count()) {
            return $html;
        }

        foreach ($iFrames as $iframe) {
            if (!$iframe->hasAttribute('src')) {
                continue;
            }
            $src = "{$iframe->getAttribute('src')}?enablejsapi=1&version=3&playerapiid=ytplayer";
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                $src, $match);
            $videoId = $match[1] ?? null;

            if (!$videoId) {
                return $html;
            }

            $iframe->removeAttribute('src');
            $iframe->setAttribute('data-src', $src);
            $iframe->setAttribute('data-video', $videoId);
            $div = $doc->createElement('div');
            $div->setAttribute('class', 'lazy-loaded');
            $div->setAttribute('data-video-id', $videoId);
            $div->setAttribute('data-loader', 'youtubeLoader');
            if ($style = $iframe->getAttribute('style')) {
                $div->setAttribute('style', $style);
            }
            $divYoutubeIcon = $doc->createElement('div');
            $divYoutubeIcon->setAttribute('class', 'embed-youtube-play');
            $divYoutubeIcon->setAttribute('data-video-id', $videoId);

            $img = $doc->createElement('img');
            $img->setAttribute('src', "https://img.youtube.com/vi/{$videoId}/default.jpg");
            $img->setAttribute('class', 'thumb');
            $img->setAttribute('data-video-id', $videoId);

            $div->appendChild($divYoutubeIcon);
            $div->appendChild($img);

            $iframe->parentNode->replaceChild($div, $iframe);
        }

        return $doc->saveHTML();
    }

    /**
     * This adds to all images the respective css class to perform the lazy load.
     *
     * @param string|null $html Html holding the image tags.
     *
     * @return string|null Formatted html
     */
    public static function lazyLoadImage(?string $html): ?string
    {
        // Sanitizing html
        if (null === $html) {
            return null;
        }
        if ('' === $html) {
            return $html;
        }

        // Adding .lazy class and data-src
        $doc = new DOMDocument();
        @$doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $doc->getElementsByTagName('img');

        if (!$images->count()) {
            return $html;
        }

        foreach ($images as $img) {
            if (!$img->hasAttribute('src')) {
                continue;
            }
            $src   = $img->getAttribute('src');
            $class = "img-lazy lozad {$img->getAttribute('class')}";
            $img->removeAttribute('src');
            $img->setAttribute('data-src', $src);
            $img->setAttribute('class', $class);
        }

        return $doc->saveHTML();
    }
}