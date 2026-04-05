<?php

namespace App\Controllers;
use Config\Services;

class Api extends BaseController
{
    public function geolocation()
    {
       if ($this->request->is('post')) 
        {
            $ip = $this->request->getPost('infoIp');
            return $this->getInfoByIp($ip);
            
            /*$response = array
            (
                'ip' => $ip
            );
            
            return $this->response->setJSON($response);*/
        }
    
       return view('apis/geolocation');   
    }

    public function getInfoByIp($ip)
    {
        $client = Services::curlrequest();
        $url    = "https://ipapi.co/{$ip}/json/";

        try 
        {
            $response = $client->get($url, 
            [
                'headers' => 
                [
                    'User-Agent' => 'CodeIgniter4-App' 
                ]
            ]);

            $body = $response->getBody();
            $datos = json_decode($body);

            if (isset($datos->error)) 
            {
                return "Error de la API: " . $datos->reason;
            }

            $response = array
            (
                'ip'      => $ip,
                'city'    => $datos->city,
                'country' => $datos->country_name,
                'carrier' => $datos->org        
            );         

        } 
        catch (\Exception $e) 
        {
            return "Error al conectar con la API: " . $e->getMessage();
        }

        return $this->response->setJSON($response);
    }

    public function telegram()
    {
        
        //$token   = "8550380651:AAFLaseVTDG6Erme4MuX71wJvpUqeg7sSrU"; //Muller
        //$chatId  = "5980273236"; 
        $token   = "8579253305: AAF7qvHStRrQJ2VuBAttgbSX0VC5z6vmj3E"; //Villa
        $chatId  = "7779376191"; 
        $mensaje = "¡Hola desde CodeIgniter 4!\nEste es un aviso automático [Villa].";

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $client = \Config\Services::curlrequest();

        try 
        {
            $response = $client->post($url, [
                'form_params' => [
                    'chat_id'    => $chatId,
                    'text'       => $mensaje,
                    'parse_mode' => 'Markdown' 
                ]
            ]);

            $resultado = json_decode($response->getBody());

            if ($resultado->ok) 
            {
                return "Mensaje enviado con éxito.";
            } 
            else 
            {
                return "Error de Telegram: " . $resultado->description;
            }
        } 
        catch (\Exception $e) 
        {
            return "Error en la conexión: " . $e->getMessage();
        }
    }
}

