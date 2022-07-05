<?php

namespace Pterodactyl\Services\Addons\Sharing;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\ConnectionInterface;

class AddonImporterService
{
    protected ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Take an uploaded JSON file and parse it into a new egg.
     *
     * @throws \Pterodactyl\Exceptions\Service\InvalidFileUploadException|\Throwable
     */
    public function handle(UploadedFile $file)
    {
       return $file->getRealPath();
    }
}
