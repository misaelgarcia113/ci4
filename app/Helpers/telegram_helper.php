<?php
 
/**
 * Helper de Telegram
 * 
 * Permite enviar mensajes a un chat o grupo de Telegram
 * usando la API del bot.
 * 
 * Uso:
 *   helper('telegram');
 *   enviarMensajeTelegram($chat_id, $mensaje);
 */
 
if (!function_exists('enviarMensajeTelegram'))
{
    /**
     * Envía un mensaje a un chat de Telegram
     *
     * @param string $chat_id   ID del chat o grupo de Telegram
     * @param string $mensaje   Texto del mensaje a enviar
     * @return bool             true si se envió correctamente, false si falló
     */
    function enviarMensajeTelegram(string $chat_id, string $mensaje): bool
    {
        // Coloca aquí el token de tu bot de Telegram
        // Lo obtienes hablando con @BotFather en Telegram
        $token = '8579253305:AAF7qvHStRrQJ2VuBAttgbSX0VC5z6vmj3E';
 
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
 
        $data = 
        [
            'chat_id'    => $chat_id,
            'text'       => $mensaje,
            'parse_mode' => 'Markdown', // Permite usar *negrita* y _cursiva_
        ];
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $url);
        curl_setopt($ch, CURLOPT_POST,           true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);
 
        if ($error)
        {
            log_message('error', 'Telegram cURL error: ' . $error);
            return false;
        }
 
        $result = json_decode($response, true);
 
        if (!$result || !$result['ok'])
        {
            log_message('error', 'Telegram API error: ' . $response);
            return false;
        }
 
        return true;
    }
}