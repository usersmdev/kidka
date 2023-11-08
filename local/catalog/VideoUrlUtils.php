<?php

class VideoUrlUtils {
    private static function parseUrl($url) {
        $urlData = parse_url($url);
        $urlData['params'] = array();

        $paramsPairs = preg_split('/&/', $urlData['query'], -1, PREG_SPLIT_NO_EMPTY);
        foreach($paramsPairs as $paramsPair){
            $pair = preg_split('/=/', $paramsPair, -1, PREG_SPLIT_NO_EMPTY);
            $urlData['params'][$pair[0]] = $pair[1]; // {this:true}
        }

        $urlData['pathParts'] = preg_split('/\//', substr($urlData['path'], 1), -1);
        return $urlData;
    }
    
    public static  function getUrl($video) {
        if ($video) {
            $url =static::parseUrl($video);
            if (($url['host'] == 'www.youtube.com')
                || ($url['host'] == 'youtu.be')
                || ($url['host'] == 'youtube.com')
                || ($url['host'] == 'www.youtu.be'))
            {
                $videoCode = '';
                $time = $url['params']['t'];
                if (($url['host'] == 'www.youtube.com')
                    || ($url['host'] == 'youtube.com'))
                {
                    if ((count($url['pathParts']) == 1) && ($url['pathParts'][0] == 'watch') && $url['params']['v']) {
                        $videoCode = $url['params']['v'];
                    }
                    else if ((count($url['pathParts']) == 2) && ($url['pathParts'][0] == 'embed')) {
                        $videoCode = $url['params'][1];
                    }
                }

                if (($url['host'] == 'youtu.be')
                    || ($url['host'] == 'youtube.com'))
                {
                    $videoCode = substr($url['path'], 1);
                }
                if ($videoCode) {
                    return 'https://www.youtube.com/embed/'.$videoCode.'?rel=0'.($time?'&t='.$time:'');
                }
            }
            if (($url['host'] == 'www.vimeo.com')
                || ($url['host'] == 'vimeo.com')
                || ($url['host'] == 'player.vimeo.com'))
            {
                $videoCode = '';
                if ($url['host'] == 'player.vimeo.com') {
                    if ((count($url['pathParts']) == 2) && ($url['pathParts'][0] == 'video') && ($url['pathParts'][1])) {
                        $videoCode = $url['pathParts'][1];
                    }
                }
                if (($url['host'] == 'www.vimeo.com')
                    || ($url['host'] == 'vimeo.com'))
                {
                    if ((count($url['pathParts']) == 1) && ($url['pathParts'][0])) {
                        $videoCode = $url['pathParts'][0];
                    }
                }
                if ($videoCode) {
                    return 'https://player.vimeo.com/video/'.$videoCode;
                }
            }
        }
        return $video;
    }

    public static function getImg($video)
    {
        if ($video) {
            $url =static::parseUrl($video);
            if (($url['host'] == 'www.youtube.com')
                || ($url['host'] == 'youtu.be')
                || ($url['host'] == 'youtube.com')
                || ($url['host'] == 'www.youtu.be'))
            {
                $videoCode = '';
                $time = $url['params']['t'];
                if (($url['host'] == 'www.youtube.com')
                    || ($url['host'] == 'youtube.com'))
                {
                    if ((count($url['pathParts']) == 1) && ($url['pathParts'][0] == 'watch') && $url['params']['v']) {
                        $videoCode = $url['params']['v'];
                    }
                    else if ((count($url['pathParts']) == 2) && ($url['pathParts'][0] == 'embed')) {
                        $videoCode = $url['params'][1];
                    }
                }

                if (($url['host'] == 'youtu.be')
                    || ($url['host'] == 'youtube.com'))
                {
                    $videoCode = substr($url['path'], 1);
                }
                if ($videoCode) {
                    return '//img.youtube.com/vi/'.$videoCode.'/hqdefault.jpg';
                }
            }
        }
        return '';
        
    }
}