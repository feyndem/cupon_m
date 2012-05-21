<?php

namespace Cupon\CiudadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cupon\OfertaBundle\Util\Util;

/**
* @ORM\Entity(repositoryClass="Cupon\CiudadBundle\Entity\CiudadRepository") 
*/

class Ciudad {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100) 
     */
    protected $nombre;
    /**
     * @ORM\Column(type="string", length=100) 
     */
    protected $slug;
    
    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getSlug()
    {
        return $this->slug;
    }
    
    // Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->slug = Util::getSlug($nombre);
    }
    
    // to String
    public function __toString()
    {
        return $this->getNombre();
    }
}
