<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 10/06/2021
     * Time: 16:26
     */

    namespace JuniorE\Versbox\Endpoints;


    use JuniorE\Versbox\Resources\Shop;
    use JuniorE\Versbox\Resources\ShopCollection;

    class ShopEndpoint extends CollectionEndpointAbstract
    {
        protected $resourcePath = "shops";

        protected function getResourceObject()
        {
            return new Shop($this->client);
        }

        protected function getResourceCollectionObject($count, $_links)
        {
            return new ShopCollection($this->client, $count, $_links);
        }

        public function create(array $data = [], array $filters = [])
        {
            return $this->rest_create($data, $filters);
        }

        public function get(string $customerId, array $parameters = [])
        {
            return $this->rest_read($customerId, $parameters);
        }

        public function delete(string $customerId, array $data = [])
        {
            return $this->rest_delete($customerId, $data);
        }

        public function page($from = null, $limit = null, array $parameters = [])
        {
            return $this->rest_list($from, $limit, $parameters);
        }
    }
