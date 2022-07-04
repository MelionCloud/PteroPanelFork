<?php
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * This software is licensed under the terms of the MIT license.
 * https://opensource.org/licenses/MIT
 */

namespace Pterodactyl\Http\Controllers\Admin\Nests;

use Javascript;
use Illuminate\View\View;
use Pterodactyl\Http\Controllers\Controller;

class EggController extends Controller
{

    public function __construct() {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     */
    public function index() {
        return view('admin.addons.index');
    }

    /**
     * Show the details of an Addon
     *
     * @return \Illuminate\Http\Response
     */
    public function view(int $id) {
        return view('admin.addons.view', ['addonid' => $id]);
    }
}
