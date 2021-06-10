<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 10/06/2021
     * Time: 13:00
     */

    namespace JuniorE\Versbox\Tests\Endpoints;

    use GuzzleHttp\Psr7\Request;
    use GuzzleHttp\Psr7\Response;
    use JuniorE\Versbox\Resources\Shop;

    class ShopEndpointTest extends BaseEndpointTest
    {

        public function test_get_all_shops()
        {
            $this->mockApiCall(
                new Request('GET', '/v1/shops'),
                new Response(
                    200,
                    [],
                    '{
                          "docs": [
                            {
                              "_id": "5f64a437a359744400eca029",
                              "organisationId": "5f64a2f9a35974b812ec9f69",
                              "name": "Test Locatie",
                              "address": {
                                "id": "e612b01d-b281-4177-93d2-74b2664a1561",
                                "street": "Bogaardestraat",
                                "streetNumber": "230b",
                                "zipcode": "9990",
                                "city": "Maldegem",
                                "state": "East Flanders",
                                "country": "be",
                                "longitude": 3.432766,
                                "latitude": 51.198082
                              },
                              "phonenumber": "+3250691492",
                              "email": "junior@itreflex.be",
                              "updatedAt": "2020-11-24T11:59:58.028Z"
                            }
                          ],
                          "skip": 0,
                          "limit": 20,
                          "count": 1,
                          "total": 1
                        }')
            );

        }

    }
