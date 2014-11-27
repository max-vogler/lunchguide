<?php

/**
 * A meal of the menu of the day.
 * 
 * @property int $id The internal ID
 * @property string $name The name/description
 * @property integer $price The price in cent
 * @property Carbon $date The date of the menu
 * @property string $info Additional information, e.g. the line, location or specials
 * @property boolean $featured Features this meal on the menu of the day. Small meals, expensive meals or sides may be hidden from it.
 * @property restaurant_id the Restaurant ID
 * @property restaurant the Restaurant
 * @property source the unparsed source information for debugging purposes
 * 
 * @author Max Vogler
 */
class Meal extends Eloquent {
    
    protected $dates = ['date'];

    protected $fillable = ['name', 'price', 'date', 'info', 'featured', 'restaurant_id', 'source'];

    /**
     * @return Builder QueryBuilder for the associated Restaurant
     */
    public function restaurant() {
        return $this->belongsTo('Restaurant');
    }

}