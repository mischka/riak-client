<?php

namespace Riak\Client\Core\Adapter\Proto\Bucket;

use Riak\Client\Core\Message\Request;
use Riak\Client\ProtoBuf\RpbGetBucketReq;
use Riak\Client\ProtoBuf\RpbBucketProps;
use Riak\Client\ProtoBuf\RiakMessageCodes;
use Riak\Client\Core\Adapter\Proto\ProtoStrategy;
use Riak\Client\Core\Message\Bucket\GetRequest;
use Riak\Client\Core\Message\Bucket\GetResponse;

/**
 * rpb get implementation.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class ProtoGet extends ProtoStrategy
{
    /**
     * @param \Riak\Client\Core\Message\Bucket\GetRequest $request
     *
     * @return \Riak\Client\ProtoBuf\RpbGetBucketReq
     */
    private function createRpbMessage(GetRequest $request)
    {
        $rpbGetReq = new RpbGetBucketReq();

        $rpbGetReq->setBucket($request->bucket);
        $rpbGetReq->setType($request->type);

        return $rpbGetReq;
    }

    /**
     * @param \Riak\Client\ProtoBuf\RpbBucketProps $props
     *
     * @return \Riak\Client\Core\Message\Bucket\GetResponse
     */
    private function createGetResponse(RpbBucketProps $props)
    {
        $response = new GetResponse();

        $response->allowMult     = $props->allow_mult;
        $response->basicQuorum   = $props->basic_quorum;
        $response->bigVclock     = $props->big_vclock;
        $response->dw            = $props->dw;
        $response->lastWriteWins = $props->last_write_wins;
        $response->notfoundOk    = $props->notfound_ok;
        $response->nVal          = $props->n_val;
        $response->oldVclock     = $props->old_vclock;
        $response->pr            = $props->pr;
        $response->pw            = $props->pw;
        $response->r             = $props->r;
        $response->rw            = $props->rw;
        $response->w             = $props->w;
        $response->smallVclock   = $props->small_vclock;
        $response->youngVclock   = $props->young_vclock;

        // optional values
        $response->search       = $props->search;
        $response->searchIndex  = $props->search_index;
        $response->backend      = $props->backend;
        $response->consistent   = $props->consistent;
        $response->datatype     = $props->datatype;

        return $response;
    }

    /**
     * @param \Riak\Client\Core\Message\Bucket\GetRequest $request
     *
     * @return \Riak\Client\Core\Message\Bucket\GetResponse
     */
    public function send(Request $request)
    {
        $rpbGetReq  = $this->createRpbMessage($request);
        $rpbGetResp = $this->client->send($rpbGetReq, RiakMessageCodes::GET_BUCKET_REQ, RiakMessageCodes::GET_BUCKET_RESP);
        $rpbProps   = $rpbGetResp->getProps();

        return $this->createGetResponse($rpbProps);
    }
}
