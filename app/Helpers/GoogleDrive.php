<?php

namespace App\Helpers;

use Google\Service\Drive\DriveFile;

class GoogleDrive
{
    protected $APPLICATION_NAME;
    protected $CREDENTIALS_PATH;
    protected $CLIENT_SECRET_PATH;
    protected $SCOPES;

    protected $client;
    protected $service;

    public function __construct()
    {
        $this->APPLICATION_NAME   = 'KingsEducation';
        $this->CREDENTIALS_PATH   = app_path("../jsons/".config('custom.google.drive.user'));
        $this->CLIENT_SECRET_PATH = app_path("../jsons/".config('custom.google.drive.client'));

        // If modifying these scopes, delete your previously saved credentials
        // at ~/.credentials/drive-php-quickstart.json
        $this->SCOPES = implode(' ', [
//            \Google_Service_Drive::DRIVE_APPDATA,
            \Google_Service_Drive::DRIVE_FILE,
        ]);

        $this->client  = $this->__get_client();
        $this->service = $service = new \Google_Service_Drive($this->client);
    }

    public function readFolder($debugOnly = false)
    {
        $optParams = [
            'pageSize' => 10,
            'fields'   => 'nextPageToken, files(id, name)'
        ];
        $results   = $this->service->files->listFiles($optParams);

        return $results->getFiles();
    }

    public function storeAndGetURL($path, $name)
    {
        $file = new DriveFile();
        $file->setParents([config('custom.google.drive.upload_folder_id')]);
        $file->setName($name);

        $result = $this->service->files->create(
            $file,
            [
                'data'       => file_get_contents($path),
                'mimeType'   => 'application/octet-stream',
                'uploadType' => 'multipart',
            ],
        );
        $fileId = $result->getId();

        return 'https://drive.google.com/file/d/'.$fileId.'/view';
    }

    private function __get_client()
    {
        $client = new \Google_Client();
        $client->setApplicationName($this->APPLICATION_NAME);
        $client->setScopes($this->SCOPES);
        $client->setAuthConfig($this->CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $client->setRedirectUri('http://127.0.0.1/test');
        $client->setPrompt('select_account consent');

        //return $client;

        // Load previously authorized credentials from a file.
        $credentialsPath = $this->CREDENTIALS_PATH;
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
            $client->setAccessToken($accessToken);
        }

        if ($client->isAccessTokenExpired()){
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
            } else {
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
                file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
            }
        }
        return $client;
    }


}
