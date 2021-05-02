<?php


namespace App\Tests\Functional\Infrastructure;


use App\Tests\Functional\DataFixtures\CoinsControllerTestFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CoinsControllerTest extends WebTestCase
{
    use FixturesTrait;

    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        // Arrange
        $this->client = static::createClient();
        $this->loadFixtures([
            CoinsControllerTestFixtures::class
        ]);
    }

    public function test_it_returns_the_list_of_coins(): void
    {
        // Act
        $this->client->request('GET', '/coins');
        $response = $this->client->getResponse();

        // Assert
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($response->getContent());
        $content = json_decode($response->getContent());
        self::assertCount(3, $content);
    }

    public function test_it_saves_and_retrieves_a_coin(): void
    {
        // Act
        $this->client->request(
            'POST', '/coins', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "description" => "A beautiful coin",
                "amount" => "2",
                "currency" => "USD",
                "year" => "2007"
            ])
        );
        $response = $this->client->getResponse();

        // Assert
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertNotEmpty($response->getContent());

        $coinId = $response->getContent();
        $this->client->request('GET', "/coins/{$coinId}");
        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function test_it_returns_error_when_invalid_body(): void
    {
        // Act
        $this->client->request(
            'POST', '/coins', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "invalid_body" => null
            ])
        );
        $response = $this->client->getResponse();

        // Assert
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function test_it_deletes_a_coin(): void
    {
        // Act
        $this->client->request('DELETE', "/coins/63f125dd-7597-46d9-951e-271c8a815df9");
        $response = $this->client->getResponse();

        // Assert
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->client->request('GET', "/coins/63f125dd-7597-46d9-951e-271c8a815df9");
        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function test_it_returns_error_when_deleting_non_existent_coin(): void
    {
        // Act
        $this->client->request('DELETE', "/coins/non-existent-coin");
        $response = $this->client->getResponse();

        // Assert
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}