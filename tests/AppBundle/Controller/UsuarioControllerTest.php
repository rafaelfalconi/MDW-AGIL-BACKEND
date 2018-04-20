<?php
/**
 * Created by PhpStorm.
 * User: Chante
 * Date: 20/04/2018
 * Time: 9:30
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsuarioControllerTest extends WebTestCase
{
    const RUTA_API1='/user';

    /**
     * Test POST /users 201 Created
     *
     * @return array user data
     *
     * @covers \AppBundle\Controller\ApiUserController::postUserAction()
     */
    public function testPostUserAction201()
    {
        $rand_num = mt_rand(0, 1000000);
        $username = 'userTest' . $rand_num . '@test.com';
        $p_data = [
            'email' => $username,
            'clave'    => $username . $rand_num
        ];

        $client = static::createClient();
        // 201
        $client->request('POST' , self::RUTA_API1, [], [], [], json_encode($p_data));

        $response = self::$_client->getResponse();
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());


    }


}