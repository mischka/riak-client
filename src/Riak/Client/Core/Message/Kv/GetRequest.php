<?php

namespace Riak\Client\Core\Message\Kv;

use Riak\Client\Core\Message\Request;

/**
 * This class represents a get request.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class GetRequest extends Request
{
    public $bucket;
    public $key;
    public $r;
    public $pr;
    public $basicQuorum;
    public $notfoundOk;
    public $ifModified;
    public $head;
    public $deletedvclock;
    public $timeout;
    public $sloppyQuorum;
    public $nVal;
    public $type;
}
