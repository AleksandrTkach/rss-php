# RUN 
```
$ php index.php
```

# TASK

Folder structure of the project:
Project
- images\
- index.php


Here is an rss feed:
https://www.nu.nl/rss/Sport


Write a method, that can get rss feed, parse it, and return array with parsed data.

Example:

function getRss($rssURI){

    //your logic
    
    return $dataJson;
}

Requirements to logic:

1. All item->enclosure url images must be downloaded into our images folder.

2. We need to rename image file into a unique hash (md5, sha1, etc... you decide which approach to use here).
- if image is already in our images folder, it is used, and we do NOT download duplicate
- we use this image hash in response, instead of original url

3. We need a response ($dataJson) in JSON format, that will contain an array of item->title and item->enclosure url attribute. Example:
   [
   'title'=>'Test title',
   'image'=>'/images/{image hashed name}'
   ]
