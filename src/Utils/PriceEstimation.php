<?php 
namespace App\Utils;

class PriceEstimation 
{
    public function getPrice(int $car_year, int $nb_km, int $nb_days): int
    {
        $price = $car_year * $nb_days * 60 / $nb_km;
        return ceil($price);
    }
}