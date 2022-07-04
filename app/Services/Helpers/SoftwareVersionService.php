<?php

namespace Pterodactyl\Services\Helpers;

use Exception;
use GuzzleHttp\Client;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Pterodactyl\Exceptions\Service\Helper\CdnVersionFetchingException;

class SoftwareVersionService
{
    public const VERSION_CACHE_KEY = 'pterodactyl:versioning_data';
    public const VERSION_ADDON_CACHE_KEY = 'pterodactyl:versioning_data_addons';

    /**
     * @var array
     */
    private static $result;

    /**
     * @var array
     */
    private static $resultAddons;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * SoftwareVersionService constructor.
     */
    public function __construct(
        CacheRepository $cache,
        Client $client
    ) {
        $this->cache = $cache;
        $this->client = $client;

        self::$result = $this->cacheVersionData();
        self::$resultAddons = $this->cacheAddonVersionData();
    }

    /**
     * Get the latest version of the panel from the CDN servers.
     *
     * @return string
     */
    public function getPanel()
    {
        return Arr::get(self::$result, 'panel') ?? 'error';
    }

    /**
     * Get the latest version of the panel from the Addon CDN servers.
     *
     * @return string
     */
    public function getAddonsPanel()
    {
        return Arr::get(self::$resultAddons, 'name') ?? 'error';
    }

    /**
     * Get the latest version of the daemon from the CDN servers.
     *
     * @return string
     */
    public function getDaemon()
    {
        return Arr::get(self::$result, 'wings') ?? 'error';
    }

    /**
     * Get the URL to the discord server.
     *
     * @return string
     */
    public function getDiscord()
    {
        return Arr::get(self::$result, 'discord') ?? 'https://pterodactyl.io/discord';
    }

    /**
     * Get the URL for donations.
     *
     * @return string
     */
    public function getDonations()
    {
        return Arr::get(self::$result, 'donations') ?? 'https://paypal.me/PterodactylSoftware';
    }

    /**
     * Checks if the panel is up a development version.
     *
     * @return bool
     */
    public function isDevVersion()
    {
        return Str::contains($appVersion, '-');
    }

    /**
     * Determine if the current version of the panel is the latest.
     *
     * @return bool
     */
    public function isLatestPanel()
    {
        $appVersion = config()->get('app.version');
        if ($appVersion === 'canary') {
            return true;
        }

        if (Str::contains($appVersion, '-')) {
            return version_compare($appVersion, $this->getPanel()) >= 0;
        }


        return version_compare($appVersion, $this->getPanel()) >= 0;
    }

    /**
     * Determine if a passed daemon version string is the latest.
     *
     * @param string $version
     *
     * @return bool
     */
    public function isLatestDaemon($version)
    {
        if ($version === '0.0.0-canary') {
            return true;
        }

        return version_compare($version, $this->getDaemon()) >= 0;
    }

    /**
     * Keeps the versioning cache up-to-date with the latest results from the CDN.
     *
     * @return array
     */
    protected function cacheVersionData()
    {
        return $this->cache->remember(self::VERSION_CACHE_KEY, CarbonImmutable::now()->addMinutes(config()->get('pterodactyl.cdn.cache_time', 60)), function () {
            try {
                $response = $this->client->request('GET', config()->get('pterodactyl.cdn.url'));

                if ($response->getStatusCode() === 200) {
                    return json_decode($response->getBody(), true);
                }

                throw new CdnVersionFetchingException();
            } catch (Exception $exception) {
                return [];
            }
        });
    }


    /**
     * Keeps the versioning cache up-to-date with the latest results from the Addon CDN.
     *
     * @return array
     */
    protected function cacheAddonVersionData()
    {
        return $this->cache->remember(self::VERSION_ADDON_CACHE_KEY, CarbonImmutable::now()->addMinutes(config()->get('pterodactyl.cdn.cache_time', 60)), function () {
            try {
                $response = $this->client->request('GET', config()->get('pterodactyl.cdn.addons_url'));

                if ($response->getStatusCode() === 200) {
                    return json_decode($response->getBody(), true);
                }

                throw new CdnVersionFetchingException();
            } catch (Exception $exception) {
                return [];
            }
        });
    }
}
