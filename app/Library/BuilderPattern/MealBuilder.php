<?php
namespace App\Library\BuilderPattern;

class MealBuilder
{
   public function prepareVegMeal (){
      $meal = new Meal();
      $meal->addItem(new VegBurger());
      $meal->addItem(new Coke());
      return $meal;
   }   

   public function prepareNonVegMeal (){
      $meal = new Meal();
      $meal->addItem(new ChickenBurger());
      $meal->addItem(new Pepsi());
      return $meal;
   }
}
