<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 22/09/2020
     * Time: 11:36
     */

    namespace JuniorE\Versbox\Tests\Endpoints;

    use JuniorE\Versbox\Endpoints\CustomerEndpoint;
    use PHPUnit\Framework\TestCase;
    use GuzzleHttp\Psr7\Request;
    use GuzzleHttp\Psr7\Response;
    use JuniorE\Versbox\Resources\Customer;
    use JuniorE\Versbox\Resources\CustomerCollection;

    class CustomerEndpointTest extends BaseEndpointTest
    {

        public function testGet()
        {

        }

        public function testDelete()
        {

        }

        public function testCreate()
        {
            $this->mockApiCall(
                new Request('POST', '/v1/customers'),
                new Response(
                    200,
                    [],
                    '{
                        "shopId": "5f64a437a359744400eca029",
                        "firstName": "Junior",
                        "lastName": "Everaert",
                        "emails": [
                            "junior@itreflex.be"
                        ],
                        "phonenumbers": [
                            "+32494886481"
                        ],
                        "externalId": "1",
                        "pincode": "24020",
                        "language": "nl",
                        "id": 1,
                        "updatedAt": "2021-06-10T11:52:12.000Z",
                        "organisationId": "5f64a2f9a35974b812ec9f69",
                        "_id": "60c1fcecb589c30006545a92"
                    }'
                )
            );

            /** @var Customer $customer */
            $customer = $this->apiClient->customers->create([
                'shopId'       => "5f64a437a359744400eca029",
                'firstName'    => "Junior",
                'lastName'     => "Everaert",
                'emails'       => [
                    "junior@itreflex.be"
                ],
                'phonenumbers' => [
                    "+32494886481"
                ],
                'externalId'   => "1",
                'pincode'      => "24020",
                'language'     => "nl"
            ]);

            $this->assertInstanceOf(Customer::class, $customer);
            $this->assertEquals("Junior", $customer->firstName);
            $this->assertEquals("Everaert", $customer->lastName);
            $this->assertEquals("1", $customer->externalId);
            $this->assertEquals("24020", $customer->pincode);
            $this->assertIsArray($customer->emails);
            $this->assertIsArray($customer->phonenumbers);
            $this->assertEquals("2021-06-10T11:52:12.000Z", $customer->updatedAt);

        }
    }
