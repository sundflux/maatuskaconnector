<?php

/**
 * The Initial Developer of the Original Code is
 * Tarmo Alexander Sundström <ta@sundstrom.im>.
 *
 * Portions created by the Initial Developer are
 * Copyright (C) 2017 Tarmo Alexander Sundström <ta@sundstrom.im>
 *
 * All Rights Reserved.
 *
 * Contributor(s):
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
namespace Mconnector\Connection;

use Webvaloa\Configuration;

class Connection
{
    private $endpoint;
    private $username;
    private $password;
    private $token;

    const CONNECTION_TOKEN_URL = '/index.php/rest/V1/integration/admin/token';

    public function __construct()
    {
        $this->token = null;

        $configuration = new Configuration();

        $this->endpoint = $configuration->mconnector_endpoint->value;
        $this->username = $configuration->mconnector_username->value;
        $this->password = $configuration->mconnector_password->value;
    }

    public function setEndpoint($v)
    {
        $this->endpoint = $v;
    }

    public function setUsername($v)
    {
        $this->endpoint = $v;
    }

    public function setPassword($v)
    {
        $this->endpoint = $v;
    }

    public function getEndpoint()
    {
        if (substr($this->endpoint, -1) == '/') {
            return substr($this->endpoint, 0, -1);
        }

        return $this->endpoint;
    }

    public function getUsername()
    {
        return $this->username;
    }

    private function getPassword()
    {
        return $this->password;
    }

    public function getToken()
    {
        if (!$this->token) {
            $this->getAuthenticationToken();
        }

        return $this->token;
    }

    public function setToken($v)
    {
        $this->token = $v;
    }

    public function getAuthenticationToken()
    {
        $credentials = array(
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
        );

        $token = $this->call($this->getEndpoint().CONNECTION_TOKEN_URL, $credentials);
        $token = json_decode($token);

        $this->setToken($token);

        return $this->getToken();
    }

    public function call($endpoint, $payload = false)
    {
        $ch = curl_init($endpoint);

        $headers = false;

        if ($payload) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CUsRLOPT_POSTFIELDS, json_encode($payload));

            $headers = array('Content-Type: application/json', 'Content-Lenght: '.strlen(json_encode($payload)));

            if ($token = $this->getToken()) {
                array_merge($headers, array("Authorization: Bearer {$token}"));
            }
        } else {
            if ($token = $this->getToken()) {
                $headers = array("Authorization: Bearer {$token}");
            }
        }

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}
