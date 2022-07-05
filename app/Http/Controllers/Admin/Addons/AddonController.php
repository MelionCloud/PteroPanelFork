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
use Pterodactyl\Models\Addon;

class AddonController extends Controller
{

    /**
     * @var \Pterodactyl\Contracts\Repository\AddonRepositoryInterface
     */
    private $repository;

    public function _construct(
        AddonRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
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
}
