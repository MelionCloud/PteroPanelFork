<?php

namespace Pterodactyl\Contracts\Repository;

use Pterodactyl\Models\Addon;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AddonRepositoryInterface extends RepositoryInterface
{
    /**
     * Return a Addon by Name.
     *
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function getByName(string $name): Addon;

}
