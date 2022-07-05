<?php

namespace Pterodactyl\Repositories\Eloquent;

use Pterodactyl\Models\Addon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Pterodactyl\Exceptions\Repository\RecordNotFoundException;
use Pterodactyl\Contracts\Repository\AddonRepositoryInterface;

class AddonRepository extends EloquentRepository implements AddonRepositoryInterface
{
    /**
     * Return the model backing this repository.
     *
     * @return string
     */
    public function model()
    {
        return Addon::class;
    }

    /**
     * Return an Addon by Name.
     *
     * @throws RecordNotFoundException
     */
    public function getByName(string $name): Addon
    {
        try {
            /** @var Addon $model */
            $model = $this->getBuilder()
                ->where('name', '=', $name)
                ->firstOrFail($this->getColumns());

            return $model;
        } catch (ModelNotFoundException $exception) {
            throw new RecordNotFoundException();
        }
    }
}
