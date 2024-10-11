<?php

namespace Muscobytes\Laravel\TakeadsApi\Settings;

use Muscobytes\Laravel\TakeadsApi\Exceptions\PublicKeyNotFound;
use Muscobytes\Laravel\TakeadsApi\Interfaces\SettingsInterface;

class ConfigSettings implements SettingsInterface
{
    /**
     * @throws PublicKeyNotFound
     */
    public function findById(
        string $id,
        array $platforms
    ): string
    {
        $index = array_search(
            $id,
            array_column(
                $platforms,
                'id'
            )
        );

        if (false === $index) {
            throw new PublicKeyNotFound('Public Key not found for id = ' . $id);
        }

        return $platforms[$index]['public_key'];
    }


    /**
     * @throws PublicKeyNotFound
     */
    public function getById(string $id): string
    {
        return $this->findById(
            $id,
            config('takeads.keys')
        );
    }
}
