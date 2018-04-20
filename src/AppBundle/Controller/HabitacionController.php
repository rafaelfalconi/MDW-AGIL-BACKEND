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

/**
 * @Rest\Route("api/v1/habitaciones")
 */
class HabitacionController extends FOSRestController
{
    /**
     * @Rest\Get()
     */
    public function getAction(Request $request)
    {
        $habitaciones = $this->getDoctrine()->getRepository('AppBundle:Habitacion')->findAll();
        if ($habitaciones === null) {
            return new View("No hay habitaciones registrados", Response::HTTP_NOT_FOUND);
        }
        $fecha = $request->get('fecha');
        $hora = $request->get('hora');
        $arrayresult=array();
        foreach ($habitaciones as $habitacion){
            $repository = $this->getDoctrine()
                ->getRepository(Reserva::class);
            $query = $repository->createQueryBuilder('r')
                ->where('r.entrada >= :entrada and r.fecha= :fecha and r.habitacion= :habitacion')
                ->setParameters(array("entrada" => $hora,"fecha" => $fecha, "habitacion"=>$habitacion))
                ->orderBy('r.salida', 'ASC')
                ->setMaxResults(1)
                ->getQuery();
            $restseult = $query->getResult();
            if(empty($restseult)){
                $restseult= new Reserva();
                $restseult->setEstado(false);
                $restseult->setEntrada($hora);
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