<?php

namespace Pterodactyl\Models;

/**
 * Pterodactyl\Models\Addon.
 *
 * @property int $id
 * @property string $uuid
 * @property string $uuid_short
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $version
 * @property string $author
 * @property string $website
 * @property string $license
 * @property bool $enabled
 * @property bool $installed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method statis \Database\Factories\AddonFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereUuidShort($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereLicense($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereEnabled($value)
 * @method static \Illuminate\Database\Query\Builder|\Pterodactyl\Models\Addon whereInstalled($value)
 * @mixin \Eloquent
 */
class Addon extends Model
{
    /**
     * The resource name for this model when it is transformed into an
     * API representation using fractal.
     */
    public const RESOURCE_NAME = 'addon';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addons';

    /**
     * Fields that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Rules ensuring that the raw data stored in the database meets expectations.
     *
     * @var array
     */
    public static $validationRules = [
        'name' => 'required|string|between:1,255',
        'description' => 'string|nullable|between:1,255',
        'version' => 'required|string|between:1,255',
        'author' => 'string|nullable|between:1,255',
        'website' => 'string|nullable|between:1,255',
        'license' => 'string|nullable|between:1,255',
        'enabled' => 'boolean',
        'installed' => 'boolean',
        'created_at' => 'date|nullable',
        'updated_at' => 'date|nullable'
    ];
}
