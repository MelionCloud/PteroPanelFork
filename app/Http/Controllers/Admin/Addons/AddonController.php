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

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view('admin.addons.index');
    }
}
