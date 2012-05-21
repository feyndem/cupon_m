<?php

namespace Cupon\CiudadBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cupon\CiudadBundle\Entity\Ciudad;

class Ciudades implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ciudades = array (
            array ('nombre'=>'Madrid'),
            array ('nombre'=>'Barcelona'),
            array ('nombre'=>'Alicante'),
            array ('nombre'=>'Málaga'),            
        );
        foreach ($ciudades as $ciudad)
        {
            $entidad = new Ciudad();
            $entidad->setNombre($ciudad['nombre']);
            $manager->persist($entidad);
        }
        $manager->flush();
    }
}