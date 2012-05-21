<?php

namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository
{
    public function findOfertaDelDia($ciudad)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, c FROM OfertaBundle:Oferta o
            JOIN o.ciudad c
            WHERE c.slug = :ciudad
            AND o.revisada = true
            AND o.fecha_publicacion < :fecha
            ORDER BY o.fecha_publicacion DESC
        ');
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setParameter('fecha', new \DateTime('now'));
        
        $consulta->setMaxResults(1);
        return $consulta->getSingleResult();
    }
    
    public function findOferta($ciudad, $slug)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery(
                'SELECT o, c, t FROM OfertaBundle:Oferta o
                JOIN o.ciudad c
                JOIN o.tienda t
                WHERE o.revisada = true
                AND o.slug = :slug
                AND c.slug = :ciudad'
                );
        $consulta->setParameter('slug', $slug);
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);
        
        return $consulta->getSingleResult();        
    }
    
    public function findRelacionadas($ciudad)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, c FROM OfertaBundle:Oferta o
            JOIN o.ciudad c
            WHERE o.revisada = true
            AND o.fecha_publicacion <= :fecha
            AND c.slug != :ciudad
            ORDER BY o.fecha_publicacion DESC');
        $consulta->setMaxResults(5);
        $consulta->setParameter('fecha', new \DateTime('today'));
        $consulta->setParameter('ciudad', $ciudad);
        
        return $consulta->getResult();
    }
    
    public function findRecientes($ciudad_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, t FROM OfertaBundle:Oferta o
            JOIN o.tienda t
            WHERE o.revisada = true
            AND o.fecha_publicacion < :fecha
            AND o.ciudad = :id
            ORDER BY o.fecha_publicacion DESC');
        $consulta->setMaxResults(5);
        $consulta->setParameter('fecha', new \DateTime('today'));
        $consulta->setParameter('id', $ciudad_id);
        
        return $consulta->getResult();
    }
}
