<?php
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * This software is licensed under the terms of the MIT license.
 * https://opensource.org/licenses/MIT
 */

namespace Pterodactyl\Http\Controllers\Admin\Addons;

use Javascript;
use Illuminate\View\View;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Contracts\Repository\AddonRepositoryInterface;
use Pterodactyl\Http\Requests\Admin\Addons\AddonImportFormRequest;
use Illuminate\Http\RedirectResponse;
use Pterodactyl\Services\Eggs\Sharing\AddonImporterService;

class AddonController extends Controller
{

    /**
     * @var \Pterodactyl\Contracts\Repository\AddonRepositoryInterface
     */
    private $repository;

    /**
     * @var AddonImporterService $importer
     */
    private$importerService;

    public function __construct(
        AddonRepositoryInterface $repository,
        AddonImporterService $importerService
    ) {
        $this->repository = $repository;
        $this->importerService = $importerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addons = $this->repository->all();

        return view('admin.addons.index', [
            'addons' => $addons,
        ]);
    }

    /**
     * Import a new service option using an XML file.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     * @throws \Pterodactyl\Exceptions\Service\Egg\BadJsonFormatException
     * @throws \Pterodactyl\Exceptions\Service\InvalidFileUploadException
     */
    public function import(AddonImportFormRequest $request): RedirectResponse
    {
        $filePath = $this->importerService->handle($request->file('import_file'));
        $this->alert->success('Addon imported: ' . $filePath)->flash();

        return redirect()->route('admin.addons');
    }
}
