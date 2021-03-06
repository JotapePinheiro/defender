<?php

namespace Artesaos\Defender\Traits;

use Artesaos\Defender\Pivots\PermissionRolePivot;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HasRolePermissionsTrait.
 */
trait HasRolePermissionsTrait
{
    use HasPermissionsTrait;

    /**
     * Many-to-many permission-user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('defender.permission_model'), config('defender.permission_role_table'), config('defender.role_key'), config('defender.permission_key')
        )->withPivot('value', 'expires');
    }

    /**
     * @param Model  $parent
     * @param array  $attributes
     * @param string $table
     * @param bool   $exists
     *
     * @return PermissionRolePivot|\Illuminate\Database\Eloquent\Relations\Pivot
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        $permissionModel = app()['config']->get('defender.permission_model');

        if ($parent instanceof $permissionModel) {
            return new PermissionRolePivot($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}
