<?php

/**
 * A restaurant, providing Meals.
 * 
 * @property int $id The internal ID
 * @property string $name The name/description
 * @property Meal[] $meals All meals of the menus of the day
 * 
 * @author Max Vogler
 */
class Restaurant extends Eloquent {

    protected $fillable = ['name'];

    /**
     * @return Builder QueryBuilder for the associated Meals
     */
    public function meals() {
        return $this->hasMany('Meal');
    }

    public function __toString() {
        return $this->name;
    }

}