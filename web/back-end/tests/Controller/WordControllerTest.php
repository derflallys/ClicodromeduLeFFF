<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordControllerTest extends WebTestCase
{
    /*public function testGetComments() {
        $client = $this->createAuthenticatedClient('api@api.com', 'api');
        $this->execQuery($client, 'GET', null, '/api/comments');$response = $client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = json_decode($response->getContent(), true);
        $this->assertInternalType('array', $content);
        $this->assertCount(3, $content);

        $comment = $content[0];
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('status', $comment);
        $this->assertArrayNotHasKey('content', $comment);
        $this->assertArrayNotHasKey('password', $comment['user']);
    }

    public function testPostNewComment()
    {
        $data = array
        (
            "body"  => "This is a comment",
            "status"  => "1",
            "user_id" => "1",
            "movie_id"  => "4",
        );

        $client = $this->createAuthenticatedClient('api@api.com', 'api');
        $this->postData($client, $data, '/api/comments');
        $response = $client->getResponse();
        $this->assertStatusCodeResponse($response, 201);
        $comment = json_decode($response->getContent(), true);

        $this->assertInternalType('array', $comment);
        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('movie_id', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayNotHasKey('password', $comment['user']);
    }

    public function testPostNewCommentWithoutMovieId()
    {
        $data = array
        (
            "body" => 'My new simple comment',
        );

        $client = $this->createAuthenticatedClient('api@api.com', 'api');
        $this->postData($client, $data, '/api/comments');

        $response = $client->getResponse();
        $this->assertStatusCodeResponse($response, 410);
    }
    public function setUp()
    {
        parent::setup();
        $fixtures = array(
            'App\DataFixtures\AppFixtures',
        );
        $this->loadFixtures($fixtures);
    }*/

    /**
     * @dataProvider provideUrls
     */
    public function testUrlStatus($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // asserts that the "Content-Type" header is "application/json"
        /*$this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );*/
    }

    public function provideUrls()
    {
        return [
            ['/list/word/a'],
            ['/get/word/1'],
        ];
    }
}