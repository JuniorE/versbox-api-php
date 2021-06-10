<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 19/09/2020
     * Time: 16:29
     */

    namespace JuniorE\Versbox\Endpoints;


    use JuniorE\Versbox\Exceptions\ApiException;
    use JuniorE\Versbox\Resources\BaseCollection;
    use JuniorE\Versbox\Resources\Reservation;
    use JuniorE\Versbox\Resources\ReservationCollection;
    use JuniorE\Versbox\VersboxApiClient;

    class ReservationEndpoint extends CollectionEndpointAbstract
    {

        protected $resourcePath = "reservations";


        protected function getResourceObject()
        {
            return new Reservation($this->client);
        }

        protected function getResourceCollectionObject($count, $_links)
        {
            return new ReservationCollection($this->client, $count, $_links);
        }

        public function create(array $data = [], array $filters = [])
        {
            return $this->rest_create($data, $filters);
        }

        public function get($paymentId, array $parameters = [])
        {
            if (empty($paymentId)) {
                throw new ApiException("Invalid payment ID: '{$paymentId}'");
            }

            return parent::rest_read($paymentId, $parameters);
        }

        public function delete($paymentId, array $data = [])
        {
            return $this->rest_delete($paymentId, $data);
        }

    }
