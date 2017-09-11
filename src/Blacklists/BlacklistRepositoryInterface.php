<?php
namespace CakeTracking\Blacklists;

/**
 * BlacklistRepositoryInterface
 *
 * Specifies an interface for searching of a blacklist repository.
 *
 * @author Travis Anthony Torres
 * @version September 11, 2017
 */

interface BlacklistRepositoryInterface
{
    public function contains($ip);
}
