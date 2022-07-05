<?php
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * This software is licensed under the terms of the MIT license.
 * https://opensource.org/licenses/MIT
 */

namespace Pterodactyl\Http\Requests\Admin\Addons;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class AddonImportFormRequest extends AdminFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'import_file' => 'bail|required|file|max:100000|mimetypes:application/zip',
        ];
    }
}
