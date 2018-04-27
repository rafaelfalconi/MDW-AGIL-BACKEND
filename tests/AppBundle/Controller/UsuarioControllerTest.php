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
    const RUTA_API1='api/v1/users';

    public function testPostUserCreateAction201()
    {
        $rand_num = mt_rand(0, 1000000);
        $username = 'userTest' . $rand_num . '@test.com';
        $p_data = array('username' => $username);
        $client = static::createClient();
        $client->request('POST' , self::RUTA_API1,$p_data );
        $response = $client->getResponse();
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());

    }

    public function testPostUserExistNotCreateAction200()
    {
        $rand_num = mt_rand(0, 1000000);
        $username = 'userTest' . $rand_num . '@test.com';
        $p_data = array('username' => $username);
        $client = static::createClient();
        $clientTemp = static::createClient();
        $client->request('POST' , self::RUTA_API1,$p_data );
        $clientTemp->request('POST' , self::RUTA_API1,$p_data );
        $response = $client->getResponse();
        $this->assertEquals(200, $clientTemp->getResponse()->getStatusCode());
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());

    }

}