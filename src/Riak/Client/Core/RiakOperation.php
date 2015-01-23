<?php

namespace Riak\Client\Core;


/**
 * Riak Operation
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
interface RiakOperation
{
    /**
     * Execute the operation.
     *
     * @param \Riak\Client\Core\RiakAdapter $adapter
     *
     * @return \Riak\Client\RiakResponse
     */
    public function execute(RiakAdapter $adapter);
}
