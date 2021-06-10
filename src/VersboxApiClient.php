<?php

    namespace JuniorE\Versbox;

    use GuzzleHttp\Client;
    use GuzzleHttp\ClientInterface;
    use GuzzleHttp\Exception\GuzzleException;
    use GuzzleHttp\Psr7\Request;
    use JuniorE\Versbox\Endpoints\CustomerEndpoint;
    use JuniorE\Versbox\Exceptions\ApiException;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\StreamInterface;


    class VersboxApiClient
    {

        const API_ENDPOINT = 'https://api.viresmo.com';
        const API_VERSION  = 'v1';

        const HTTP_GET    = "GET";
        const HTTP_POST   = "POST";
        const HTTP_DELETE = "DELETE";
        const HTTP_PATCH  = "PATCH";

        /**
         * Default response timeout (in seconds).
         */
        const TIMEOUT = 10;

        /**
         * @var ClientInterface
         */
        protected $httpClient;

        /**
         * @var string
         */
        protected $apiEndpoint = self::API_ENDPOINT;

        /**
         * RESTful Customers resource.
         *
         * @var CustomerEndpoint
         */
        public $customers;

        /**
         * @var ReservationEndpoint
         */
        private $reservations;

        /**
         * @var string
         */
        protected $apiKey;

        /**
         * @var string
         */
        protected $organisationKey;



        public function __construct(ClientInterface $httpClient = null)
        {
            $this->httpClient = $httpClient ?: new Client([
                \GuzzleHttp\RequestOptions::VERIFY  => \Composer\CaBundle\CaBundle::getBundledCaBundlePath(),
                \GuzzleHttp\RequestOptions::TIMEOUT => self::TIMEOUT,
            ]);

            $this->initializeEndpoints();
        }

        public function initializeEndpoints()
        {
            $this->customers = new CustomerEndpoint($this);
        }

        public function setApiEndpoint($url)
        {
            $this->apiEndpoint = rtrim(trim($url), '/');
            return $this;
        }

        public function getApiEndpoint()
        {
            return $this->apiEndpoint;
        }

        public function setApiKey($apiKey)
        {
            $apiKey = trim($apiKey);

            if ( !preg_match('/^(apiKey).\w{32,}$/', $apiKey)) {
                throw new ApiException("Invalid API key: '{$apiKey}'. An API key must start with 'apiKey' and must be at least 32 characters long.");
            }

            $this->apiKey = $apiKey;

            return $this;
        }

        /**
         * @param  string  $organisationKey  The Versbox organisation key
         *
         * @return VersboxApiClient
         * @throws ApiException
         */
        public function setOrganisationKey($organisationKey)
        {
            $organisationKey = trim($organisationKey);

            if ( !preg_match('/\w{24,}$/', $organisationKey)) {
                throw new ApiException("Invalid API key: '{$organisationKey}'. An organisation key must be at least 24 characters long.");
            }

            $this->organisationKey = $organisationKey;

            return $this;
        }

        public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
        {
            $url = $this->apiEndpoint."/".self::API_VERSION."/".$apiMethod;

            return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
        }

        /**
         * Perform an http call to a full url. This method is used by the resource specific classes.
         *
         * @param  string  $httpMethod
         * @param  string  $url
         * @param  string|null|resource|StreamInterface  $httpBody
         *
         * @return \stdClass|null
         * @throws ApiException
         * @codeCoverageIgnore
         * @see $isuers
         *
         * @see $payments
         */
        public function performHttpCallToFullUrl(
            string $httpMethod,
            string $url,
            $httpBody = null
        )
        {
            if (empty($this->apiKey)) {
                throw new ApiException("You have not set an API key or OAuth access token. Please use setApiKey() to set the API key.");
            }
            if (empty($this->organisationKey)) {
                throw new ApiException("You have not set an organisation key. Please use setOrganisationKey() to set the organisation key.");
            }

            $headers = [
                'Accept'        => "application/json",
                'Authorization' => (string) ($this->apiKey),
                'organisation'    => (string) ($this->organisationKey),
            ];

            $request = new Request($httpMethod, $url, $headers, $httpBody);

            try {
                $response = $this->httpClient->send($request, ['http_errors' => false]);
            } catch (GuzzleException $e) {
                throw ApiException::createFromGuzzleException($e, $request);
            }

            if ( !$response) {
                throw new ApiException("Did not receive API response.", 0, null, $request);
            }

            return $this->parseResponseBody($response);
        }

        private function parseResponseBody(ResponseInterface $response)
        {
            $body = (string) $response->getBody();
            if (empty($body)) {
                if ($response->getStatusCode() === self::HTTP_NO_CONTENT) {
                    return null;
                }

                throw new ApiException("No response body found.");
            }

            $object = @json_decode($body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException("Unable to decode Mollie response: '{$body}'.");
            }

            if ($response->getStatusCode() >= 400) {
                throw ApiException::createFromResponse($response, null);
            }

            return $object;
        }

    }
