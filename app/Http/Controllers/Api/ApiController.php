<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SpTrans\SpTransController;
use App\Http\Controllers\Weather\WeatherController;

use function PHPUnit\Framework\isEmpty;

class ApiController extends Controller
{
    public function stopName(string $stop_name)
    {
        $api = new SpTransController("/Parada/Buscar?termosBusca={$stop_name}");
        $result = $api->getContent();
        if (empty($result)) {
            return response()->json(['Message' => 'Não foi encontrado nenhuma linha'], 400);
        }
        $apiWeather = new WeatherController($result);
        $response = $apiWeather->getWeatherFromCoordinates();
        return response()->json($response, 200);
    }
}
