<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DefaultController extends Controller
{
    public function portadaAction ($ciudad=null)
    {
        if (null == $ciudad)
        {
            $ciudad = $this->container->getParameter('cupon.ofertabundle.ciudad_por_defecto');
            return new RedirectResponse($this->generateURL('portada', array('ciudad'=>$ciudad)));
        }
        $em = $this->getDoctrine()->getEntityManager();
        //$ciudad = $this->container->getParameter('cupon.ofertabundle.ciudad_por_defecto');
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOfertaDelDia($ciudad);
        
        if (!$oferta) {
            throw $this->createNotFoundException('No se ha encontrado ninguna oferta del día en la ciudad seleccionada');
        }

        return $this->render(
            'OfertaBundle:Default:portada.html.twig',
            array('oferta'=>$oferta)    
        );
    }
    
    public function ofertaAction($ciudad, $slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOferta($ciudad, $slug);
        if (!$oferta) {
            throw $this->createNotFoundException('No se ha encontrado la oferta');
        }
        $relacionadas = $em->getRepository('OfertaBundle:Oferta')->findRelacionadas($ciudad);
        
        return $this->render('OfertaBundle:Default:detalle.html.twig', array(
            'oferta' => $oferta,
            'relacionadas' => $relacionadas
        ));
    }
     
}
