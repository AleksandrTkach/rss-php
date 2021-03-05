<?php
$rssURI = 'https://www.nu.nl/rss/Sport';

print_r(getRss($rssURI));

function getRss($rssURI)
{
    $dirGallery = 'images';
    $destination = __DIR__ . '/' . $dirGallery;
    $issetHashes = getIssetHashes($destination);

    if (!file_exists($destination))
        mkdir($destination, 0777, true);

    $res = [];
    $xml = simplexml_load_file($rssURI);

    foreach ($xml->channel->children()->item as $item) {
        $url = (string)$item->enclosure->attributes()->url;
        $pathInfo = pathinfo($url);
        $file = file_get_contents($url);

        $uniqueFileName = md5($file) . '.' . $pathInfo['extension'];

        if (!in_array(md5($file), $issetHashes))
            file_put_contents($destination . '/' . $uniqueFileName, $file);

        $res[] = [
            'title' => (string)$item->title,
            'image' => '/' . $dirGallery . '/' . $uniqueFileName,
        ];

    }

    return json_encode($res);
}

function getIssetHashes($dirPath)
{
    $res = [];
    foreach (array_diff(scandir($dirPath), ['.', '..']) as $file)
        $res[] = pathinfo($file)['filename'];

    return $res;
}