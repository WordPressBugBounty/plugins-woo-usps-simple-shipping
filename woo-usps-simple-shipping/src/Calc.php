<?php /** @noinspection PhpMultipleClassesDeclarationsInOneFile */
declare(strict_types=1);

namespace Dgm\UspsSimple;

use Dgm\UspsSimple\Calc\Cache;
use Dgm\UspsSimple\Calc\Request;
use Exception;


class Calc
{
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @throws Exception
     */
    public function calc(Request $request): array
    {
        $pkg = $request->package;

        if (
            !$pkg->dest->isDomestic() ||
            $pkg->dest->zipCode === '' ||
            $pkg->empty() ||
            $request->services->empty()
        ) {
            return [];
        }

        $cacheKey = $request->cacheKey();
        $rates = $this->cache->get($cacheKey);
        if ($rates !== null) {
            return $rates;
        }

        $rates = [];
        $ngrates = Api::rates($request);
        foreach ($request->services->families as $family) {
            if (isset($ngrates[$family->id])) {
                $rates[$family->id] = [
                    'id'    => $family->id,
                    'label' => $family->title,
                    'cost'  => $ngrates[$family->id],
                ];
            }
        }

        $this->cache->set($cacheKey, $rates);

        return $rates;
    }


    /**
     * @var Cache
     */
    private $cache;
}