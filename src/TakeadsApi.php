<?php

namespace Muscobytes\Laravel\TakeadsApi;

use Generator;
use Muscobytes\Laravel\TakeadsApi\Interfaces\SettingsInterface;
use Muscobytes\TakeadsApi\Client;
use Muscobytes\TakeadsApi\Dto\V1\Api\Stats\Click\ClickRequest;
use Muscobytes\TakeadsApi\Dto\V1\Api\Stats\Click\ClickRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Api\Stats\Click\ClickResponse;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\Coupons\CouponsRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\Coupons\CouponsRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\Coupons\CouponsResponse;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponSearchRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponSearchRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponSearchResponse;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantResponse;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Resolve\ResolveRequest;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Resolve\ResolveRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Resolve\ResolveResponse;
use Muscobytes\TakeadsApi\Dto\V3\Api\Stats\Action\ActionRequest;
use Muscobytes\TakeadsApi\Dto\V3\Api\Stats\Action\ActionRequestParameters;
use Muscobytes\TakeadsApi\Dto\V3\Api\Stats\Action\ActionResponse;
use Muscobytes\TakeadsApi\Exceptions\ClientErrorException;
use Muscobytes\TakeadsApi\Exceptions\ResponseMetaIsMissingException;
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


    /**
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     */
    public function resolve(
        string $public_key_id,
        ResolveRequestParameters $parameters
    ): ResolveResponse
    {
        /** @var ResolveResponse */
        return $this->call($public_key_id, $parameters);
    }


    /**
     * @throws ResponseMetaIsMissingException
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     */
    public function iterateWithMetaNext(
        string $public_key_id,
        MerchantRequestParameters $parameters
    ): Generator
    {
        do {
            /** @var MerchantResponse $response */
            $response = $this->call($public_key_id, $parameters);
            $parameters->next = $response->getMeta()->next;
            yield $response;
        } while ($parameters->next);
    }


    /**
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     * @throws ResponseMetaIsMissingException
     */
    public function merchant(
        string $public_key_id,
        MerchantRequestParameters $parameters
    ): Generator
    {
        return $this->iterateWithMetaNext($public_key_id, $parameters);
    }


    /**
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     */
    public function couponSearch(
        string $public_key_id,
        CouponSearchRequestParameters $parameters
    ): CouponSearchResponse
    {
        /** @var CouponSearchResponse */
        return $this->call($public_key_id, $parameters);
    }


    /**
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     */
    public function coupons(
        string $public_key_id,
        CouponsRequestParameters $parameters
    ): CouponsResponse
    {
        /** @var CouponsResponse */
        return $this->call($public_key_id, $parameters);
    }


    /**
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     */
    public function clickReport(
        string $public_key_id,
        ClickRequestParameters $parameters
    ): ClickResponse
    {
        /** @var ClickResponse */
        return $this->call($public_key_id, $parameters);
    }


    /**
     * @throws ClientErrorException
     * @throws UnknownErrorException
     * @throws ServerErrorException
     * @throws ServiceUnavailableException
     */
    public function actionReport(
        string $public_key_id,
        ActionRequestParameters $parameters
    ): ActionResponse
    {
        /** @var ActionResponse */
        return $this->call($public_key_id, $parameters);
    }
}
