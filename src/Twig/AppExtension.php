<?php


namespace  App\Twig;

use App\Entity\LikeNotification;

class AppExtension extends \Twig_Extension
{


    public function getFilter(){

        return array(
            'price' => new \Twig_Filter($this, 'priceFilter'),
        );
    }

    public function priceFilter($number){

        return '$' . number_format($number , 2 , '.',',');
    }


    public function getTests()
    {
        return [
          new \Twig_SimpleTest(
              'like',
              function($obj){
                  return $obj instanceof LikeNotification;
              }
          )
        ];
    }
}