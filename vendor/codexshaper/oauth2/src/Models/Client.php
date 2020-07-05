<?php

namespace CodexShaper\OAuth2\Server\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_clients';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scopes'                    => 'array',
        'personal_access_client'    => 'bool',
        'password_client'           => 'bool',
        'authorization_code_client' => 'bool',
        'revoked'                   => 'bool',
    ];

    /**
     * Get the user that the client belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the authentication codes for the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authCodes()
    {
        return $this->hasMany(AuthCode::class, 'client_id');
    }

    /**
     * Get all of the tokens that belong to the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany(Token::class, 'client_id');
    }

    /**
     * Determine if the client should skip the authorization prompt.
     *
     * @return bool
     */
    public function isSkipsAuthorization()
    {
        return true;
    }

    /**
     * Determine if the client is a confidential client.
     *
     * @return bool
     */
    public function isConfidential()
    {
        return !empty($this->secret);
    }
}
