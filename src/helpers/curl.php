<?php

namespace Tortitas\DockerSDK\Helpers;

class Curl
{
    public static function curl(string $url, string $method, array $params = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Windows only, need to check the expose port on docker desktop
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            curl_setopt($ch, CURLOPT_PORT, 2375);
        } else {
            // Linux only
            curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, '/var/run/docker.sock');
        }

        if ($method === 'POST') {
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                json_encode($params)
            );
        }

        $headers = [];
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $resultJson = json_decode($result, true);

        if (isset($resultJson['message'])) {
            throw new \Exception($resultJson['message']);
        }

        return $resultJson;
    }
}

class Command
{
    public static function run(string $command, array $params = [])
    {
        $command = 'docker ' . $command;
        foreach ($params as $key => $value) {
            $command .= ' ' . $key . ' ' . $value;
        }

        return shell_exec($command);
    }
}
