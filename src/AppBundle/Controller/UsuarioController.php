<?php
/**
 * Created by Juan Pablo Jimenez.
 * User: Chante
 * Date: 19/04/2018
 * Time: 12:37
 */

namespace AppBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\Id;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Usuario;

/**
 * @Rest\Route("api/v1/users")
 */

class UsuarioController extends FOSRestController
{

    /**
     * @Rest\Post("")
     */
    public function postAction(Request $request)
    {

        $usuario = new Usuario();
        $username = $request->get('username');
        if(empty($username))
        {
            return new View("LOS CAMPOS VACIOS NO ESTAN PERMITIDOS", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getManager();
        $user_exist = $em
            ->getRepository(Usuario::class)
            ->findBy(['email' => $username]);

        if (!count($user_exist)) {

            $usuario->setEmail($username);
            $usuario->setClave($username . mt_rand(0, 1000000));
            $em->persist($usuario);
            $em->flush();
            return new View($usuario->getId(), Response::HTTP_CREATED);
        }
        $usuario = $user_exist[0];
        return new View($usuario->getId(), Response::HTTP_OK);

    }

}