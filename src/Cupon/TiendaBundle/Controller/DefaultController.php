<?php

namespace Cupon\TiendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    
    public function portadaAction($ciudad, $tienda)
    {
        $formato = $this->get('request')->getRequestFormat();
        $em = $this->getDoctrine()->getEntityManager();
        
        $ciudad = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        $tienda = $em->getRepository('TiendaBundle:Tienda')->findOneBy(
                array(
                    'slug' => $tienda,
                    'ciudad' => $ciudad->getId()
                ));
        if (!$tienda)
        {
            throw $this->createNotFoundException('No existe la tienda');
        }
        $ofertas = $em->getRepository('TiendaBundle:Tienda')
                ->findUltimasOfertasPublicadas($tienda->getId());
        $cercanas = $em->getRepository('TiendaBundle:Tienda')
                ->findCercanas(
                        $tienda->getSlug(),
                        $tienda->getCiudad()->getSlug()
                        );
         return $this->render('TiendaBundle:Default:portada.'.$formato.'.twig', array(
            'tienda' => $tienda,
            'ofertas' => $ofertas,
            'cercanas' => $cercanas             
         ));
    }
}
