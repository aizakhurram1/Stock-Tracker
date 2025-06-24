<?php

namespace App\Clients;

use App\Models\Retailer;
use Str;

class ClientFactory
{
    public function make(Retailer $retailer): Client
    {
        // // work for every type for eg, target, walmart etc, donot have to write code for every type explicitly
        $class = 'App\\clients\\'.Str::studly($retailer->name);

        if (! class_exists($class)) {
            throw new ClientsException('Client not found for '.$retailer->name.'');
        }

        return new $class;
    }
}
