<?php

namespace App\Http\Controllers\Weather;

use Illuminate\Support\Facades\Http;

class WeatherController
{
    protected $stops;

    public function __construct($stops)
    {
        $this->stops = $stops;
    }

    public function getWeatherFromCoordinates()
    {
        $information = [];
        $kelvin = 273.15;
        $url = env('OPEN_WEATHER_URL');
        $token = env('OPEN_WEATHER_TOKEN');
        foreach ($this->stops as $stop) {
            $response = Http::get("{$url}lat={$stop['py']}&lon={$stop['px']}&lang=pt_br&appid={$token}");
            $data = $response->json();
            $parada = [
                'codigo_parada'       => $stop['cp'],
                'nome_parada'         => $stop['np'],
                'descrição'           => $stop['ed'],
                'resumo'              => ucwords($data['weather'][0]['description']),
                'temperatura'         => $data['main']['temp'] - $kelvin,
                'sensacao_termica'    => $data['main']['feels_like'] - $kelvin,
                'temp_min'            => $data['main']['temp_min'] - $kelvin,
                'temp_max'            => $data['main']['temp_max'] - $kelvin,
            ];
            array_push($information, $parada);
        }
        return $information;
    }
}
