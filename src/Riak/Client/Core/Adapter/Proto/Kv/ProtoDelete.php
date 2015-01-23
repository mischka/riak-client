<?php

namespace Riak\Client\Core\Adapter\Proto\Kv;

use Riak\Client\Core\Message\Request;
use Riak\Client\Core\Message\Kv\DeleteRequest;
use Riak\Client\Core\Message\Kv\DeleteResponse;
use Riak\Client\ProtoBuf\RiakMessageCodes;
use Riak\Client\ProtoBuf\RpbDelReq;

/**
 * rpb delete implementation.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class ProtoDelete extends BaseProtoStrategy
{
    /**
     * @param \Riak\Client\Core\Message\Kv\DeleteRequest $request
     *
     * @return \Riak\Client\ProtoBuf\RpbDelReq
     */
    private function createRpbMessage(DeleteRequest $request)
    {
        $rpbDelReq = new RpbDelReq();

        $rpbDelReq->setBucket($request->bucket);
        $rpbDelReq->setType($request->type);
        $rpbDelReq->setKey($request->key);

        if ($request->r !== null) {
            $rpbDelReq->setR($request->r);
        }

        if ($request->pr !== null) {
            $rpbDelReq->setPr($request->pr);
        }

        if ($request->w !== null) {
            $rpbDelReq->setW($request->w);
        }

        if ($request->rw !== null) {
            $rpbDelReq->setRw($request->rw);
        }

        if ($request->dw !== null) {
            $rpbDelReq->setDw($request->dw);
        }

        if ($request->pw !== null) {
            $rpbDelReq->setPw($request->pw);
        }

        if ($request->vClock !== null) {
            $rpbDelReq->setVclock($request->vClock);
        }

        return $rpbDelReq;
    }

    /**
     * @param \Riak\Client\Core\Message\Kv\DeleteRequest $request
     *
     * @return \Riak\Client\Core\Message\Kv\DeleteResponse
     */
    public function send(Request $request)
    {
        $response   = new DeleteResponse();
        $rpbPutReq  = $this->createRpbMessage($request);

        $this->client->send($rpbPutReq, RiakMessageCodes::DEL_REQ, RiakMessageCodes::DEL_RESP);

        return $response;
    }
}
