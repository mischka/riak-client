<?php

namespace Riak\Client\Core\Message\Bucket;

use Riak\Client\Core\Message\Response;

/**
 * This class represents a get response.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class GetResponse extends Response
{
    public $nVal;
    public $allowMult;
    public $lastWriteWins;
    public $preCommitList;
    public $postcommitList;
    public $oldVclock;
    public $youngVclock;
    public $bigVclock;
    public $smallVclock;
    public $pr;
    public $r;
    public $w;
    public $pw;
    public $dw;
    public $rw;
    public $basicQuorum;
    public $notfoundOk;
    public $backend;
    public $search;
}
