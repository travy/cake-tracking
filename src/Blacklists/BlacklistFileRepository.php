<?php
namespace CakeTracking\Blacklists;

use CakeTracking\Blacklists\BlacklistRepositoryInterface;

/**
 * BlacklistFileRepository
 *
 * Used for identifying IP addresses which have been logged into a blacklist
 * on the servers file system.
 *
 * @author Travis Anthony Torres
 * @version September 10, 2017
 */

class BlacklistFileRepository implements BlacklistRepositoryInterface
{
    protected $filename;
    
    /**
     * Specifies the filename for the blacklist repository.
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Searches the repository for the specified IP address.
     *
     * @param string $ip
     *
     * @return Boolean
     */
    public function contains($ip)
    {
        $blacklist = $this->readIntoArray();
        $position = $this->binarySearch($ip, $blacklist);
        
        return $position > 0;
    }
    
    /**
     * Searches an array for a specified value.
     *
     * @param string $needle
     * @param array $haystack
     *
     * @return integer Index of the needle in the array or -1 if it is not
     *         contained in the array
     */
    public function binarySearch($needle, array $haystack)
    {
        $needlePosition = -1;
        $firstElementIndex = 0;
        $lastElementIndex = count($haystack) - 1;
        
        while($needlePosition === -1 && ($length = $lastElementIndex - $firstElementIndex) >= 0) {
            $middleIndex = (int)($firstElementIndex + ($length / 2));
            
            $sortOrder = strnatcasecmp($needle, $haystack[$middleIndex]);
            if ($sortOrder === 0) {
                $needlePosition = $middleIndex;
            } else if ($sortOrder < 0) {
                $lastElementIndex = $middleIndex - 1;
            } else {
                $firstElementIndex = $middleIndex + 1;
            }
        }
        
        return $needlePosition;
    }
    
    /**
     * Reads the contents of the blacklist into a sorted array.
     *
     * @return array
     */
    public function readIntoArray()
    {
        // return empty array if no blacklist exists
        if (!file_exists($this->filename)) {
            return [];
        }
        
        //  read contents of file into array, each line representing an ip
        $blacklist = [];
        $file = fopen($this->filename, 'r');
        while (($line = fgets($file)) !== false) {
            $blacklist[] = $line;
        }
        fclose($file);
        
        //  sort the blacklist in order as strings in case ip 6 is utilized
        sort($blacklist, SORT_STRING);
        
        return $blacklist;
    }
}
