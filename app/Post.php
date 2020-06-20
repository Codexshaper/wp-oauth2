<?php

namespace CodexShaper\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $primaryKey = 'ID';

    protected static $type_scope = 'post';
    protected static $status_scope = 'publish';
    protected static $author_scope = null;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'post_date';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'post_modified';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // foreach (['PostTypeScope', 'PostStatusScope'] as $scope) {
        // 	$namespace = '\\CodexShaper\\WP\Database\\Eloquent\\Scopes';
        // 	$defaultPostScopeClass = $namespace.'\\'.$scope;
        // 	static::addGlobalScope(new $defaultPostScopeClass);
        // }

        // static::addGlobalScope(new PostTypeScope);
        // static::addGlobalScope(new PostStatusScope);
        // static::addGlobalScope(new PostAuthorScope);
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('post_type', '=', static::$type_scope);
        });
        // static::addGlobalScope('scope', function (Builder $builder) {
        //     $builder->where('post_status', '=', static::$status_scope);
        // });
        // static::addGlobalScope('author', function (Builder $builder) {
        //     $builder->where('post_author', '=', static::$author_scope);
        // });
    }

    // public static function all($columns = ['*'])
    // {
    // 	return static::query()->where('post_type', '=', 'post')->get();
    // }

    /**
     * Filter by post type
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $status
     *
     * @return mixed
     */
    public function scopeType(Builder $builder, $type)
    {
    	self::$type_scope = $type;
        return $builder->where('post_type', '=', $type);
    }

    /**
     * Filter by post status
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $status
     *
     * @return mixed
     */
    public function scopeStatus(Builder $builder, $status)
    {
        return $builder->where('post_status', '=', $status);
    }

    /**
     * Filter by post author
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string|null $author
     *
     * @return mixed
     */
    public function scopeAuthor(Builder $builder, $author)
    {
        if ($author) {
            return $builder->where('post_author', '=', $author);
        }
    }
}