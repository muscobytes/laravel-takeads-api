<?php

namespace Muscobytes\Laravel\TakeadsApi;

use Muscobytes\Laravel\TakeadsApi\Interfaces\SettingsInterface;
use Muscobytes\TakeadsApi\Client;
use Muscobytes\TakeadsApi\Dto\V1\Api\Stats\Click\ClickRequest;
use Muscobytes\TakeadsApi\Dto\V1\Api\Stats\Click\ClickRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\Coupons\CouponsRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\Coupons\CouponsRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponSearchRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponSearchRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Resolve\ResolveRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Resolve\ResolveRequestParameters;
use Muscobytes\TakeadsApi\Dto\V3\Api\Stats\Action\ActionRequest;
use Muscobytes\TakeadsApi\Dto\V3\Api\Stats\Action\ActionRequestParameters;
use Muscobytes\TakeadsApi\Exceptions\ClientErrorException;
use Muscobytes\TakeadsApi\Exceptions\ServerErrorException;
use Muscobytes\TakeadsApi\Exceptions\ServiceUnavailableException;
use Muscobytes\TakeadsApi\Exceptions\UnknownErrorException;
use Muscobytes\TakeadsApi\Interfaces\RequestInterface;
use Muscobytes\TakeadsApi\Interfaces\RequestParametersInterface;
use Muscobytes\TakeadsApi\Interfaces\ResponseInterface;

readonly class TakeadsApi
{
    public function __construct(
        private SettingsInterface $settings,
        private Client $client
    )
    {
        //
    }


    /**
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     */
    public function call(
        string $public_key_id,
        RequestParametersInterface $parameters
    ): ResponseInterface
    {
        /** @var RequestInterface $requestClass */
        $requestClass = match(get_class($parameters)) {
            ResolveRequestParameters::class => ResolveRequest::class,
            MerchantRequestParameters::class => MerchantRequest::class,
            CouponsRequestParameters::class => CouponsRequest::class,
            CouponSearchRequestParameters::class => CouponSearchRequest::class,
            ClickRequestParameters::class => ClickRequest::class,
            ActionRequestParameters::class => ActionRequest::class,
        };

        return $this->client->call(
            new $requestClass(
                $this->settings->getById($public_key_id),
                $parameters
            )
        );
    }
}
