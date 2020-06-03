<?php

class FoodModel
{
    private $restaurantId;
    private $name;
    private $kitchen;
    private $stars;
    private $fish;
    private $text;
    private $price;
    private $location;
    private $img;

    function __construct($restaurantId, $name, $kitchen, $stars, $fish, $text, $price, $location, $img)
    {
        $this->restaurantId = $restaurantId;
        $this->name = $name;
        $this->kitchen = $kitchen;
        $this->stars = $stars;
        $this->fish = $fish;
        $this->text = $text;
        $this->price = $price;
        $this->location = $location;
        $this->img = $img;
    }

    public function get_RestaurantID()
    {
        return $this->restaurantId;
    }

    public function setRestaurantID($restaurantId)
    {
        $this->restaurantId = $restaurantId;
    }

    public function get_Name()
    {
        return $this->name;
    }

    public function setNames($name)
    {
        $this->name = $name;
    }

    public function get_Kitchen()
    {
        return $this->kitchen;
    }

    public function setKitchen($kitchen)
    {
        $thiskitchen = $kitchen;
    }

    public function get_Stars()
    {
        return $this->stars;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    public function get_Fish()
    {
        return $this->fish;
    }

    public function setFish($fish)
    {
        $this->fish = $fish;
    }

    public function get_Text()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function get_Price()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function get_Location()
    {
        return $this->location;
    }

    public function setLoactionxt($location)
    {
        $this->location = $location;
    }

    public function get_Img()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }

}

?>
