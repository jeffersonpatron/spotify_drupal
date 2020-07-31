<?php
/**
 * @file
 * Contains \Drupal\spotify_drupal\Controller\SpotifyDrupalController.
 */

namespace Drupal\spotify_drupal\Controller;

use GuzzleHttp\Client;
use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Exception\GuzzleException;

class SpotifyDrupalController extends ControllerBase
{

    protected $client;

    public function __construct()
    {
        
        $this->client = \Drupal::httpClient();
    }

    /**
     * @return mixed|void
     */
    private function autorization()
    {

        try {
            $autorization = $this->client = new Client(['verify' => false]);
            $autorization = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => '9a07a2848f964daf827e8d4703659fa9',
                    'client_secret' => 'a8d327a581644b7e804aef7ade029cef'
                ]
            ]);

            return $response = json_decode($autorization->getBody());
        } catch (GuzzleException $e) {
            return \Drupal::logger('spotify_drupal_error')->error($e);
        }

    }


    public function newReleases()
    {

        $auth = $this->autorization();

        try {
            $request = $this->client->request('GET', 'https://api.spotify.com/v1/browse/new_releases', [
                'headers' => [
                    'Authorization' => $auth->token_type . ' ' . $auth->access_token
                ]
            ]);

            $releases = json_decode($request->getBody());
        } catch (GuzzleException $e) {
            return \Drupal::logger('spotify_drupal_error')->error($e);
        }

        $build['releases_page'] = [
            '#theme' => 'new_releases_page',
            '#releases' => $releases,
        ];

        return $build;

    }

    /**
     * @param $id
     */
    public function artist($id)
    {

        $auth = $this->autorization();

        try {
            $requestArtist = $this->client->request('GET', 'https://api.spotify.com/v1/artists/' . $id, [
                'headers' => [
                    'Authorization' => $auth->token_type . ' ' . $auth->access_token
                ]
            ]);

            $responseArtist = json_decode($requestArtist->getBody());
        } catch (GuzzleException $e) {
            return \Drupal::logger('spotify_drupal_error')->error($e);
        }

        try {
            $requestTracks = $this->client->request('GET', 'https://api.spotify.com/v1/artists/' . $id . '/top-tracks?country=CO', [
                'headers' => [
                    'Authorization' => $auth->token_type . ' ' . $auth->access_token
                ]
            ]);

            $responseTracks = json_decode($requestTracks->getBody());
        } catch (GuzzleException $e) {
            return \Drupal::logger('spotify_drupal_error')->error($e);
        }

        $build['artist_page'] = [
            '#theme' => 'artist_page',
            '#artist' => $responseArtist,
            '#tracks' => $responseTracks,
        ];
        return $build;

    }

}
