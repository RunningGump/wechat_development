<?php
namespace app\api\controller; 
use think\Controller; 

class Weather extends Controller
{
  public function read()
  {
    $city = input('city');
    $model = model('Weather');
    $data = $model->getWeather($city);
    return $data;
  }
}
