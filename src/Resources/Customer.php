<?php

namespace JuniorE\Versbox\Resources;

use JuniorE\Versbox\VersboxApiClient;

class Customer extends BaseResource
{

    public $_id;

    public $id;

    public $firstName;

    public $lastName;

    public $emails;

    public $phoneNumbers;

    public $externalId;

    public $pinCode;

    public $language;

    public $metadata;

    public $organisationId;

    public $updatedAt;

    public function createReservation() {

        return $this->client->customerPayments->createFor($this, $this->withPresetOptions($options), $filters);

    }




}
