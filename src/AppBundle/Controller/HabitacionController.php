<?php
/**
 * Created by PhpStorm.
 * User: rafaelfalconi
 * Date: 19/4/18
 * Time: 16:31
 */

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Reserva;


class HabitacionController extends FOSRestController
{
    /**
     * @Rest\GET("/habitaciones")
     */
    public function getAction(Request $request)
    {
        $habitaciones = $this->getDoctrine()->getRepository('AppBundle:Habitacion')->findAll();
        if ($habitaciones === null) {
            return new View("No hay habitaciones registrados", Response::HTTP_NOT_FOUND);
        }
        $fecha = $request->get('fecha');
        $porciones = explode("/", $fecha);
        $entrada=$porciones[2]."-".$porciones[0]."-".$porciones[1];
        $hora = $request->get('hora')-2;
        $arrayresult=array();
        foreach ($habitaciones as $habitacion){
            $repository = $this->getDoctrine()
                ->getRepository(Reserva::class);
            $query = $repository->createQueryBuilder('r')
                ->where('r.salida >= :entrada and r.fecha= :fecha and r.habitacion= :habitacion')
                ->setParameters(array("entrada" => $hora,"fecha" => $entrada, "habitacion"=>$habitacion))
                ->orderBy('r.entrada', 'ASC')
                ->setMaxResults(1)
                ->getQuery();
            $restseult = $query->getResult();
            if(empty($restseult)){
                $restseult= new Reserva();
                $restseult->setEntrada(24);
                $restseult->setSalida(24);
                $restseult->setCodigo(0);
                $restseult->setHabitacion($habitacion);
                array_push($arrayresult, $restseult);
            }else{
                array_push($arrayresult, $restseult[0]);
            }
        }
        if(count($arrayresult)==0){
            return new View("No hay habitaciones para esa fecha", Response::HTTP_NOT_FOUND);
        }
        return $arrayresult;

    }
}