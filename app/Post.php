<?php

namespace Codexshaper_Oauth_Server\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post model.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/app
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Post extends Model {

	/**
	 * The primary key of the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'ID';

	/**
	 * The type of the model.
	 *
	 * @var string
	 */
	protected static $type_scope = 'post';

	/**
	 * The publish status of the model.
	 *
	 * @var string
	 */
	protected static $status_scope = 'publish';

	/**
	 * The author of the model.
	 *
	 * @var string
	 */
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
	protected static function boot() {
		parent::boot();
		static::addGlobalScope(
			'type',
			function ( Builder $builder ) {
				$builder->where( 'post_type', '=', static::$type_scope );
			}
		);
	}

	/**
	 * Filter by post type
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder The eloquent builder.
	 * @param string                                $type The type of model.
	 *
	 * @return mixed
	 */
	public function scopeType( Builder $builder, $type ) {
		self::$type_scope = $type;
		return $builder->where( 'post_type', '=', $type );
	}

	/**
	 * Filter by post status
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder $builder The eloquent builder.
	 * @param string                                $status $builder The model status.
	 *
	 * @return mixed
	 */
	public function scopeStatus( Builder $builder, $status ) {
		return $builder->where( 'post_status', '=', $status );
	}

	/**
	 * Filter by post author
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder $builder The eloquent builder.
	 * @param string|null                           $author $builder The author.
	 *
	 * @return mixed
	 */
	public function scopeAuthor( Builder $builder, $author ) {
		if ( $author ) {
			return $builder->where( 'post_author', '=', $author );
		}
	}
}
