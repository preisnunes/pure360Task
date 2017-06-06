<?php

use \GuzzleHttp\Client as Client;
use Alchemy\Zippy\Zippy;

/**
 * Using Guzzle GET method to download file and save it inside DOWNLOAD_TO path
 * @param string $downloadUrl
 * @return string
 */
function downloadFile($downloadUrl = ''){

    if( empty($downloadUrl)){
        $downloadUrl = DOWNLOAD_URL;
    }

    $filePath = DOWNLOAD_TO . ZIPNAME;

    $handle = fopen($filePath, 'w');
    $client = new Client();
    $client->get($downloadUrl,['save_to' => $filePath]);

    fclose($handle);
    return $filePath;

}

/**
 * Extract zip and return the csv path that result from it
 * @param $path
 * @return mixed
 * @throws Exception
 */
function unzipFile( $path ){

    $zippy = Zippy::load();
    $archive = $zippy->open($path);

    $extract = $archive->extract(DOWNLOAD_TO);
    $csv = glob(DOWNLOAD_TO . '*.csv');

    if ( empty( $csv ) ){
        throw new Exception('The zip extract does not produce any csv file');
    }

    return $csv[0];

}