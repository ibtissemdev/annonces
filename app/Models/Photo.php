<?php 
namespace App\Models;

class Photo extends Model {

    protected $table='photos'; 
    protected $chemin;

    /**
     * Get the value of chemin
     */ 
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * Set the value of chemin
     *
     * @return  self
     */ 
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
    }
}