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
            \Google_Service_Drive::DRIVE,
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

        //return $client;

        // Load previously authorized credentials from a file.
        $credentialsPath = $this->CREDENTIALS_PATH;
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            // Store the credentials to disk.
            if ( ! file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }


}
