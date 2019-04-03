<?php

namespace App\Tests\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordControllerTest extends WebTestCase
{
    /**
     * @var Client $client
     */
    protected $client;


    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);
    }

    /**
     * @dataProvider provideSearchValues
     */
    public function testSearchWords($searchValue)
    {
        $response = $this->client->get('/list/word/' . $searchValue);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeader('content-type')[0]);

        $content = json_decode($response->getBody(), true);
        $this->assertInternalType('array', $content);
        // Si des mots ont été trouvés
        if(count($content) >= 1) {
            $word = $content[0];
            $this->assertArrayHasKey('id', $word);
            $this->assertArrayHasKey('value', $word);
            $this->assertArrayHasKey('category', $word);
            $this->assertArrayHasKey('tags', $word);
            $this->assertArrayHasKey('inflectedForms', $word);
        } else {
            $this->assertArrayNotHasKey('id', $content);
            $this->assertArrayNotHasKey('value', $content);
            $this->assertArrayNotHasKey('category', $content);
            $this->assertArrayNotHasKey('tags', $content);
            $this->assertArrayNotHasKey('inflectedForms', $content);
        }
    }

    public function testGetWordWithExistingId()
    {
        $response = $this->client->get('/get/word/100');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeader('content-type')[0]);

        $content = json_decode($response->getBody(), true);
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('value', $content);
        $this->assertArrayHasKey('category', $content);
        $this->assertArrayHasKey('tags', $content);
        $this->assertArrayHasKey('inflectedForms', $content);

        //Vérification des données du mot
        $this->assertEquals('100', $content['id']);
        $this->assertEquals('xaridan', $content['value']);
        $this->assertEquals('persian', $content['category']["code"]);
        $this->assertEquals('mots perses', $content['category']["name"]);
        $this->assertEmpty($content['tags']);
        $this->assertCount(2, $content['inflectedForms']);
        $this->assertEquals('nemixarid', $content['inflectedForms'][0]['value']);
        $this->assertEquals('ind;pst;evdir;ipfv;neg;3sg', $content['inflectedForms'][0]['tags']);
        $this->assertEquals('naxarideast', $content['inflectedForms'][1]['value']);
        $this->assertEquals('ind;pst;pfv;evind;nonprf;neg;3sg', $content['inflectedForms'][1]['tags']);
    }

    public function testGetWordWithUnknowId()
    {
        $response = $this->client->get('/get/word/9482654');

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);

        $this->assertEquals('Aucun mot ne correspond à l\'identifiant : 9482654', $response->getBody());
    }

    /**
     * @dataProvider provideAddWord
     */
    public function testAddWord($data) {
        $response = $this->client->post('/add/word', [
            'body' => json_encode($data),
        ]);

        switch ($data["expected"]) {
            case "success" :
                $this->assertEquals(201, $response->getStatusCode());

                $this->assertEquals('application/json', $response->getHeader('content-type')[0]);
                $content = json_decode($response->getBody(), true);
                $this->assertInternalType('array', $content);
                $this->assertArrayHasKey('id', $content);
                $this->assertArrayHasKey('value', $content);
                $this->assertArrayHasKey('category', $content);
                $this->assertArrayHasKey('tags', $content);
                $this->assertArrayHasKey('inflectedForms', $content);

                $this->assertNotEmpty($content['id']);
                $this->assertEquals($data["value"], $content['value']);
                $this->assertEquals($data["category"]["id"], $content['category']["id"]);
                $this->assertEquals($data["category"]["code"], $content['category']["code"]);
                $this->assertEquals($data["category"]["name"], $content['category']["name"]);
                $this->assertEquals($data["tags"], $content['tags']);
                $this->assertEmpty($content['inflectedForms']);
                break;
            case "errorCategory" :
                $this->assertEquals(500, $response->getStatusCode());
                $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
                $this->assertEquals('Aucune categorie ne correspond à l\'identifiant : ' . $data["category"]["id"], $response->getBody());
                break;
            case "errorData" :
                $this->assertEquals(500, $response->getStatusCode());
                $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
                $this->assertNotEquals('Aucune categorie ne correspond à l\'identifiant : ' . $data["category"]["id"], $response->getBody());
                break;
            case "alreadyExist" :
                $this->assertEquals(400, $response->getStatusCode());
                $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
                $this->assertEquals("Echec : Ce mot existe déjà avec les tags {" . $data['tags'] . "} dans la catégorie renseignée.", $response->getBody());
                break;
            default :
                break;
        }
    }

    /**
     * @dataProvider provideEditWord
     */
    public function testEditWord($data)
    {
        $response = $this->client->put('/update/word/' . $data["id"], [
            'body' => json_encode($data),
        ]);
        switch ($data["expected"]) { //Tests des différents cas
            case "success" :
                $this->assertEquals(200, $response->getStatusCode());

                $this->assertEquals('application/json', $response->getHeader('content-type')[0]);
                $content = json_decode($response->getBody(), true);
                $this->assertInternalType('array', $content);
                $this->assertArrayHasKey('id', $content);
                $this->assertArrayHasKey('value', $content);
                $this->assertArrayHasKey('category', $content);
                $this->assertArrayHasKey('tags', $content);
                $this->assertArrayHasKey('inflectedForms', $content);

                $this->assertEquals($data["id"], $content['id']);
                $this->assertEquals($data["value"], $content['value']);
                $this->assertEquals($data["category"]["id"], $content['category']["id"]);
                $this->assertEquals($data["category"]["code"], $content['category']["code"]);
                $this->assertEquals($data["category"]["name"], $content['category']["name"]);
                $this->assertEquals($data["tags"], $content['tags']);
                $this->assertEmpty($content['inflectedForms']);
                break;
            case "errorCategory" :
                $this->assertEquals(500, $response->getStatusCode());
                $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
                $this->assertEquals("La catégorie  " . $data['category']['name'] . " n'existe pas.", $response->getBody());
                break;
            case "errorData" :
                $this->assertEquals(500, $response->getStatusCode());
                $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
                $this->assertNotEquals("La catégorie  " . $data['category']['name'] . " n'existe pas.", $response->getBody());
                break;
            case "alreadyExist" :
                $this->assertEquals(400, $response->getStatusCode());
                $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
                $this->assertEquals("Echec : Ce mot existe déjà avec les tags {" . $data['tags'] . "} dans la catégorie renseignée.", $response->getBody());
                break;
            default :
                break;
        }
    }

    public function testDeleteExistingWord()
    {
        $response = $this->client->delete('/delete/word/4');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);

        //Vérification que le mot n'existe plus
        $response = $this->client->get('/get/word/4');
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
        $this->assertEquals('Aucun mot ne correspond à l\'identifiant : 4', $response->getBody());
    }

    public function testDeleteUnknownWord()
    {
        $response = $this->client->delete('/delete/word/9482654');

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals('application/json', $response->getHeader('content-type')[0]);
        $this->assertEquals('Aucun mot ne correspond à l\'identifiant : 9482654', $response->getBody());
    }

    /**
     * PROVIDERS
     */
    public function provideSearchValues()
    {
        return [
            ['a'],
            ['couper'],
            ['zers'],
        ];
    }
    public function provideAddWord()
    {
        return [
            [
                [
                    "expected" => "success",
                    "value"  => "tester",
                    "category"  => [
                        "id" => "7",
                        "code" => "v",
                        "name" => "verbe"
                    ],
                    "tags" => "groupe1;tagTest"
                ]
            ],
            [
                [
                    "expected" => "errorCategory",
                    "value"  => "errorTest",
                    "category"  => [
                        "id" => "12",
                        "code" => "?",
                        "name" => "unknown"
                    ],
                    "tags" => "tagTest;error"
                ]
            ],
            [
                [
                    "expected" => "errorData",
                    "value"  => null,
                    "category"  => [
                        "id" => "7",
                        "code" => "v",
                        "name" => "verbe"
                    ],
                    "tags" => "noValue;tagTest"
                ]
            ],
            [
                [
                    "expected" => "alreadyExist",
                    "value"  => "ouvrir",
                    "category"  => [
                        "id" => "7",
                        "code" => "v",
                        "name" => "verbe"
                    ],
                    "tags" => "groupe3"
                ]
            ],
        ];
    }
    public function provideEditWord()
    {
        return [
            [
                [
                    "expected" => "success",
                    "id" => 4,
                    "value"  => "abolirModifié",
                    "category"  => [
                        "id" => "7",
                        "code" => "v",
                        "name" => "verbe"
                    ],
                    "tags" => "groupe2;nouveauTagModifié"
                ]
            ],
            [
                [
                    //Modification du mot dégainer en une catégorie inexistante
                    "expected" => "errorCategory",
                    "id" => 3,
                    "value"  => "errorTest",
                    "category"  => [
                        "id" => "12",
                        "code" => "?",
                        "name" => "unknown"
                    ],
                    "tags" => "tagTest;error"
                ]
            ],
            [
                [
                    //Modification du mot crier avec une valeur impossible
                    "expected" => "errorData",
                    "id" => 2,
                    "value"  => null,
                    "category"  => [
                        "id" => "7",
                        "code" => "v",
                        "name" => "verbe"
                    ],
                    "tags" => "noValue;tagTest"
                ]
            ],
            [
                [
                    //Modification du mot couper en un mot existant
                    "expected" => "alreadyExist",
                    "id" => 1,
                    "value"  => "ouvrir",
                    "category"  => [
                        "id" => "7",
                        "code" => "v",
                        "name" => "verbe"
                    ],
                    "tags" => "groupe3"
                ]
            ],
        ];
    }
}