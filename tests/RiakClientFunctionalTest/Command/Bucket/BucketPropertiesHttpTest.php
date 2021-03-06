<?php

namespace RiakClientFunctionalTest\Command\Bucket;

/**
 * @group http
 * @group functional
 */
class BucketPropertiesHttpTest extends BucketPropertiesTest
{
    /**
     * {@inheritdoc}
     */
    protected function createClient()
    {
        return $this->createRiakHttpClient();
    }
}