<?php

namespace Pterodactyl\Contracts\Repository;

use Pterodactyl\Exceptions\Repository\RecordNotFoundException;
use Pterodactyl\Models\Addon;

interface AddonRepositoryInterface extends RepositoryInterface
{
    /**
     * Return an Addon by Name.
     *
     * @throws RecordNotFoundException
     */
    public function getByName(string $name): Addon;

}
