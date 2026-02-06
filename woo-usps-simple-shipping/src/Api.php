<?php declare(strict_types=1);
namespace Dgm\UspsSimple;


use Dgm\UspsSimple\Calc\Error\Error;
use Dgm\UspsSimple\Calc\Error\TransportError;
use Dgm\UspsSimple\Calc\Request;


class Api {

    public static $url = 'https://uspsapi.aikinomi.io/';

    /**
     * @throws TransportError
     * @throws Error
     */
    public static function rates(Request $request): array {

        $jsonreq = [
            'apiUserId' => $request->apiUserId,
            'package' => [
                'orig' => [
                    'countryCode' => $request->package->orig->countryCode,
                    'zipCode' => $request->package->orig->zipCode,
                ],
                'dest' => [
                    'countryCode' => $request->package->dest->countryCode,
                    'zipCode' => $request->package->dest->zipCode,
                ],
                'items' => array_map(function($item) {
                    return [
                        'product' => [
                            'name' => $item->product->name,
                            'price' => $item->product->price,
                            'weight' => $item->product->weight,
                            'dim' => [
                                'length' => $item->product->dim->length,
                                'width' => $item->product->dim->width,
                                'height' => $item->product->dim->height,
                            ],
                        ],
                        'quantity' => $item->quantity,
                    ];
                }, array_values($request->package->items)),
            ],
            'services' => [
                'families' => array_map(function($family) {
                    return [
                        'id' => $family->id,
                        'title' => $family->title,
                        'sort' => $family->sort,
                        'services' => array_map(function($service) {
                            return [
                                'id' => $service->id,
                                'title' => $service->title,
                                'enabled' => $service->enabled,
                                'alwaysUseCommercialRate' => $service->alwaysUseCommercialRate,
                            ];
                        }, array_values($family->services))
                    ];
                }, array_values($request->services->families)),
                'retailGroundEnabled' => $request->services->retailGroundEnabled,
            ],
            'groupByWeight' => $request->groupByWeight,
            'commercialRates' => $request->commercialRates,
        ];

        $resp = self::httpget($jsonreq);

        return $resp['rates'];
    }

    /**
     * @throws Error
     * @throws TransportError
     */
    private static function httpget(array $req): array {

        $resp = null;
        $success = function() use (&$resp): bool {
            return is_array($resp) && (int)$resp['response']['code'] === 200;
        };

        $tries = 3;
        while ($tries--) {
            $resp = wp_remote_post(self::$url, [
                'timeout'   => 15,
                'sslverify' => true,
                'body'      => json_encode($req),
            ]);
            if ($success()) {
                break;
            }
            sleep(1);
        }

        $errctx = [
            "response_type" => gettype($resp),
            "response"      => $resp,
        ];
        if (!is_array($resp)) {
            throw new TransportError("API request transport error", $errctx);
        }
        if (!$success()) {
            throw new Error("API request HTTP error", $errctx);
        }

        $resp = (string)$resp["body"];
        if ($resp === '') {
            throw new Error("API response is empty", $errctx);
        }

        $resp = json_decode($resp, true);
        if ($resp === false) {
            throw new Error("failed to parse response: " . json_last_error_msg(), $errctx);
        }
        if (!is_array($resp)) {
            throw new Error("returned json is not an object", $errctx);
        }

        return $resp;
    }
}
