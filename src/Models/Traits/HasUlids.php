<?php

namespace Txd\XPay\Models\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Ulid\Ulid;

trait HasUlids
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasUlids()
    {
        static::creating(function (self $model) {
            foreach ($model->uniqueIds() as $column) {
                if (empty($model->{$column})) {
                    $model->{$column} = $model->newUniqueId();
                }
            }
        });
    }

    /**
     * Generate a new ULID for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        return Ulid::generate(true);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $validUlid = function (string $ulid): bool
        {
            if (26 !== \strlen($ulid)) {
                return false;
            }
    
            if (26 !== strspn($ulid, '0123456789ABCDEFGHJKMNPQRSTVWXYZabcdefghjkmnpqrstvwxyz')) {
                return false;
            }
    
            return $ulid[0] <= '7';
        };
        if ($field && in_array($field, $this->uniqueIds()) && ! $validUlid($value)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        if (! $field && in_array($this->getRouteKeyName(), $this->uniqueIds()) && ! $validUlid($value)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return [$this->getKeyName()];
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return 'string';
        }

        return $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return false;
        }

        return $this->incrementing;
    }
}
