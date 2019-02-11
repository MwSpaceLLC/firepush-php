<?php namespace Agent\Firepush;

/**
 *  Copyright © 2019 MwSpace s.r.l <https://mwspace.com>
 *
 *  Developers (C) 2019 Aleksandr Ivanovitch <https://www.facebook.com/Aleksandr.Ivanovitch.Brunelli/>
 *
 *  This file is part of telematici-php.
 *
 * You should have received a copy of the MIT License
 * along with telematici-php.  If not, see <https://it.wikipedia.org/wiki/Licenza_MIT/>.
 *
 */

use GuzzleHttp\Client;

/**
 * Class Service
 * @package Agent\Firepush
 */
final class Service
{
    /**
     * @var
     */
    private $token;
    private $client;
    private $response;
    private $notification;
    private $responses = array();

    /**
     * Service constructor.
     * @param $filepath
     */
    public final function __construct($uthorization)
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fcm.googleapis.com/fcm/send',
            // You can set any number of default request options.
            'timeout' => 5.0,
            'cookies' => true
        ]);
    }

    /**
     * @param $token
     * @return $this
     */
    public function to($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param $paramArray
     * @return $this
     * @throws \Exception
     */
    public function notification($paramArray)
    {

        if (!array_key_exists("title", $paramArray)) {
            throw new \Exception('Key title are required for Notification Firebase');
        }

        if (!array_key_exists("body", $paramArray)) {
            throw new \Exception('Key body are required for Notification Firebase');
        }

        $this->notification = array();
        return $this;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function send()
    {

        if (!isset($this->token)) {
            throw new \Exception('Param token are required for Notification Firebase');
        }

        if (!isset($this->notification)) {
            throw new \Exception('Key title are required for send request');
        }

        if (is_array($this->token)) {

            foreach ($this->token as $token) {

                $response = $this->client->request('POST', 'https://fcm.googleapis.com/fcm/send', array(
                    'headers' => array(
                        'Authorization' => 'key=' . $this->token,
                        'Content-Type' => 'application/json'
                    ),
                    'json' => array(
                        'to' => $token,
                        'notification' => $this->notification
                    )
                ));

                $this->responses[] = json_decode($response->getBody()->getContents());
            }

        } else {

            $response = $this->client->request('POST', 'https://fcm.googleapis.com/fcm/send', array(
                'headers' => array(
                    'Authorization' => 'key=' . $this->token,
                    'Content-Type' => 'application/json'
                ),
                'json' => array(
                    'to' => $this->token,
                    'notification' => $this->notification
                )
            ));

            $this->response = json_decode($response->getBody()->getContents());

        }
    }

    public function response()
    {
        return $this->response;
    }

    /**
     * @throws \Exception
     */
    public function getMessageIds()
    {

        if (is_array($this->token)) {
            $results = array();

            foreach ($this->responses as $res) {
                $results[] = $res->results;
            }
            return $results;

        } else {

            return $this->responses->results;
        }
    }

    /**
     * @return array
     */
    public function dump()
    {
        return dump($this->response);
    }

}