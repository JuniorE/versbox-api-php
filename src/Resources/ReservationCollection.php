<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 22/09/2020
     * Time: 09:57
     */

    namespace JuniorE\Versbox\Resources;


    class ReservationCollection extends CursorCollection
    {


        public function getCollectionResourceName()
        {
            return "reservations";
        }

        protected function createResourceObject()
        {
            return new Reservation($this->client);
        }

    }
