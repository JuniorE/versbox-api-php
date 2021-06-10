<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 23/09/2020
     * Time: 09:33
     */

    namespace JuniorE\Versbox\Tests\Endpoints;

    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;
    use GuzzleHttp\Psr7\Response;
    use JuniorE\Versbox\Endpoints\EndpointAbstract;
    use JuniorE\Versbox\VersboxApiClient;
    use PHPUnit\Framework\TestCase;

    abstract class BaseEndpointTest extends TestCase
    {

        /**
         * @var Client|\PHPUnit_Framework_MockObject_MockObject
         */
        protected $guzzleClient;

        /**
         * @var VersboxApiClient
         */
        protected $apiClient;

        protected function mockApiCall(Request $expectedRequest, Response $response)
        {
            $this->guzzleClient = $this->createMock(Client::class);

            $this->apiClient = new VersboxApiClient($this->guzzleClient);

            $this->apiClient->setApiKey("apiKey.f2cb05f203c8498fa3d25da9ecb159ae");
            $this->apiClient->setOrganisationKey("5f64a2f9a35974b812ec9f69");

            $this->guzzleClient
                ->expects($this->once())
                ->method('send')
                ->with($this->isInstanceOf(Request::class))
                ->willReturnCallback(function (Request $request) use ($expectedRequest, $response) {
                    $this->assertEquals($expectedRequest->getMethod(), $request->getMethod(), "HTTP method must be identical");

                    $this->assertEquals(
                        $expectedRequest->getUri()->getPath(),
                        $request->getUri()->getPath(),
                        "URI path must be identical"
                    );

                    $this->assertEquals(
                        $expectedRequest->getUri()->getQuery(),
                        $request->getUri()->getQuery(),
                        'Query string parameters must be identical'
                    );

                    $requestBody = $request->getBody()->getContents();
                    $expectedBody = $expectedRequest->getBody()->getContents();

                    if (strlen($expectedBody) > 0 && strlen($requestBody) > 0) {
                        $this->assertJsonStringEqualsJsonString(
                            $expectedBody,
                            $requestBody,
                            "HTTP body must be identical"
                        );
                    }

                    return $response;
                });
        }

        protected function copy($array, $object)
        {
            foreach ($array as $property => $value) {
                $object->$property = $value;
            }

            return $object;
        }

    }
