<?php

namespace Riak\Client\Converter\Hydrator;

use Riak\Client\Core\Query\RiakObject;
use Riak\Client\Core\Query\RiakLocation;

/**
 * The Converter acts as a bridge between the core and the user level API.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class DomainHydrator
{
    /**
     * @var Riak\Client\Converter\Hydrator\DomainMetadataReader
     */
    private $metadataReader;

    /**
     * @param \Riak\Client\Converter\Hydrator\DomainMetadataReader $metadataReader
     */
    public function __construct(DomainMetadataReader $metadataReader)
    {
        $this->metadataReader = $metadataReader;
    }

    /**
     * @param object                               $domainObject
     * @param \Riak\Client\Core\Query\RiakObject   $riakObject
     * @param \Riak\Client\Core\Query\RiakLocation $location
     */
    public function setDomainObjectValues($domainObject, RiakObject $riakObject, RiakLocation $location)
    {
        $className = get_class($domainObject);
        $metadata  = $this->metadataReader->getMetadataFor($className);

        if (($keyField = $metadata->getRiakKeyField())) {
            $this->setDomainObjectProperty($domainObject, $keyField, $location->getKey());
        }

        if (($bucketNameField = $metadata->getRiakBucketNameField())) {
            $bucketName = $location->getNamespace() ? $location->getNamespace()->getBucketName() : null;
            $this->setDomainObjectProperty($domainObject, $bucketNameField, $bucketName);
        }

        if (($bucketTypeField = $metadata->getRiakBucketTypeField())) {
            $bucketName = $location->getNamespace() ? $location->getNamespace()->getBucketType() : null;
            $this->setDomainObjectProperty($domainObject, $bucketTypeField, $bucketName);
        }

        if (($vClockField = $metadata->getRiakVClockField())) {
            $this->setDomainObjectProperty($domainObject, $vClockField, $riakObject->getVClock());
        }

        if (($lastModifiedField = $metadata->getRiakLastModifiedField())) {
            $this->setDomainObjectProperty($domainObject, $lastModifiedField, $riakObject->getLastModified());
        }

        if (($contentTypeField = $metadata->getRiakContentTypeField())) {
            $this->setDomainObjectProperty($domainObject, $contentTypeField, $riakObject->getContentType());
        }
    }

    /**
     * @param \Riak\Client\Core\Query\RiakObject   $riakObject
     * @param object                               $domainObject
     * @param \Riak\Client\Core\Query\RiakLocation $location
     */
    public function setRiakObjectValues(RiakObject $riakObject, $domainObject, RiakLocation $location)
    {
        $className = get_class($domainObject);
        $metadata  = $this->metadataReader->getMetadataFor($className);

        if (($vClockField = $metadata->getRiakVClockField())) {
            $riakObject->setVClock($this->getDomainObjectProperty($domainObject, $vClockField));
        }

        if (($lastModifiedField = $metadata->getRiakLastModifiedField())) {
            $riakObject->setLastModified($this->getDomainObjectProperty($domainObject, $lastModifiedField));
        }

        if (($contentTypeField = $metadata->getRiakContentTypeField())) {
            $riakObject->setContentType($this->getDomainObjectProperty($domainObject, $contentTypeField));
        }
    }

    /**
     * @param object $domainObject
     * @param string $property
     * @param mixed  $value
     */
    private function setDomainObjectProperty($domainObject, $property, $value)
    {
        call_user_func([$domainObject, 'set' . ucfirst($property)], $value);
    }

    /**
     * @param object $domainObject
     * @param string $property
     *
     * @return mixed
     */
    private function getDomainObjectProperty($domainObject, $property)
    {
        return call_user_func([$domainObject, 'get' . ucfirst($property)]);
    }
}
