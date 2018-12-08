<?php
namespace app\api\model;
use think\Model;
use think\Db;
class Weather extends Model
{
  public function getWeather($city ='北京')
  {
    $weather = Db::name('weather_info') -> where('city', $city)->column('weather');
    $wind = Db::name('weather_info') -> where('city', $city)->column('wind');
    $max = Db::name('weather_info') -> where('city', $city)->column('max');
    $min = Db::name('weather_info') -> where('city', $city)->column('min');
    
    $weather_info = [
      'city' => $city,
      'weather' => $weather[0],
      'wind' => $wind[0],
      'max' => $max[0],
      'min' => $min[0]
    ];
    return json($weather_info);
  }
}