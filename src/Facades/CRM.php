<?php /** @noinspection PhpUnused */

namespace Donttrythisathome\CRMClient\Facades;

use Donttrythisathome\CRMClient\CRMManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method bool send(array $data)
 * @method \Donttrythisathome\CRMClient\Contracts\CRMDriver driver(?array $data = null)
 */
class CRM extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CRMManager::class;
    }
}