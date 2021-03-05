<?php
$rssURI = 'https://www.nu.nl/rss/Sport';

print_r(getRss($rssURI));

/**
 * @param string $rssURI
 * @return string $data The returned string contains JSON
 */
function getRss(string $rssURI): string
{
    $dirGallery = 'images';
    $destination = __DIR__ . '/' . $dirGallery;
    $issetHashes = getIssetHashes($destination);

    if (!file_exists($destination))
        mkdir($destination, 0777, true);

    $data = [];

    $xml = simplexml_load_file($rssURI);
    foreach ($xml->channel->children()->item as $item) {

        $url = (string)$item->enclosure->attributes()->url;
        $file = file_get_contents($url);
        $hashNewFile = md5($file);

        $uniqueFileName = $hashNewFile . '.' . pathinfo($url)['extension'];

        if (!in_array($hashNewFile, $issetHashes))
            file_put_contents($destination . '/' . $uniqueFileName, $file);

        $data[] = [
            'title' => (string)$item->title,
            'image' => '/' . $dirGallery . '/' . $uniqueFileName,
        ];

    }

    return json_encode($data);
}

/**
 * @param string $dirPath
 * @return array
 */
function getIssetHashes(string $dirPath): array
{
    $res = [];
    foreach (array_diff(scandir($dirPath), ['.', '..']) as $file)
        $res[] = pathinfo($file)['filename'];

    return $res;
}
