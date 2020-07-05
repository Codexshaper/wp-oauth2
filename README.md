# Description
WordPress OAuth2 Server implementation

# Get access token by `client_credentials` grant

```
endpoint: /cos/oauth/token
method: post
body: {
  "client_id": "YOUR_CLIENT_ID",
  "client_secret": "YOUR_CLIENT_SECRET",
  "grant_type": "client_credentials"
}
```
It'll return `token_type`, `expires_in`, `access_token`


# Get access token by `password` grant

```
endpoint: /cos/oauth/token
method: post
body: {
  "client_id": "YOUR_CLIENT_ID",
  "client_secret": "YOUR_CLIENT_SECRET",
  "grant_type": "password",
  "username": "YOUR_WP_USER_EMAIL",
  "password": "YOUR_WP_USER_PASSWORD"
}
```
It'll return `token_type`, `expires_in`, `access_token`, `refresh_token`

# Refresh and get new access token by `refresh_token` grant

```
endpoint: /cos/oauth/token
method: post
body: {
  "client_id": "YOUR_CLIENT_ID",
  "client_secret": "YOUR_CLIENT_SECRET",
  "grant_type": "refresh_token",
  "refresh_token": "PREVEIOSLY_GENERETED_REFRESH_TOKEN"
}
```
It'll return `token_type`, `expires_in`, `access_token`, `refresh_token`

# Scope - You can restrict your resource by passings `scope`

```
endpoint: /cos/oauth/token
method: post
body: {
  "client_id": "YOUR_CLIENT_ID",
  "client_secret": "YOUR_CLIENT_SECRET",
  "grant_type": "client_credentials",
  "scope": "SCOPE_1 SCOPE_2 SCOPE_3"
}
```

Note: If you choose multiple scope then all scopes must be seperate by space delimeter.
