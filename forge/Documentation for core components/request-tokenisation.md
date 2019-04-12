# Requests Tokenisation (CSRF-protection)

> Certain endpoints in the TAO backend are risks for Cross-Site Request Forgery attacks. In order to protect those endpoints, requests should each be sent with a unique, single-use token which is generated on the backend and validated there on its receipt.

-   AJAX requests will go through a single module, `core/request`, which will attach the tokens
-   A pool of tokens will be managed simultaneously on the backend and frontend, to allow for concurrent requests
-   Forms will still be protected by the old method: a token is rendered by PHP to a hidden input field, and validated when the submitted form is received on the server

## Specifications

-   To call a protected endpoint, the client must provide a token
-   If no token is provided, the request will be logged as a possible CSRF attempt
-   The token will be sent in the HTTP header of a tokenised request, under the `X-CSRF-Token` key
-   Each tokens cannot be used more than once
-   Tokens are stored on a per-user-session basis
-   A token may not live longer than the session of the user to which it belongs

Furthermore, a REST endpoint for such requests is expected to match the following criteria:

-   contentType : `application/json; charset=UTF-8`
-   headers : contains `X-CSRF-Token` value when needed
-   the responseBody:
      `{ success : true, data : [the results]}`
      `{ success : false, data : {Exception}, message : 'Something went wrong' }`
-   returns 204 for empty content

## Frontend

How are the different components of this system related?

![frontend](Requests.png)

### core/request module

At its heart, it is a basic `$.ajax()` request to a given URL. But the logic also includes fetching and attaching a token, and a mechanism which can force requests to run sequentially if desired.

Params:

```
* @param {Object} options
* @param {String} options.url - the endpoint full url
* @param {String} [options.method = 'GET'] - the HTTP method
* @param {Object} [options.data] - additional parameters (if method is 'POST')
* @param {Object} [options.headers] - the HTTP headers
* @param {String} [options.contentType] - what kind of data we're sending - usually 'json'
* @param {String} [options.dataType] - what kind of data expected in response
* @param {Boolean} [options.noToken = false] - if true, disables the token requirement
* @param {Boolean} [options.background] - if true, the request should be done in the background, which in practice does not trigger the global handlers like ajaxStart or ajaxStop
* @param {Boolean} [options.sequential] - if true, the request must join a queue to be run sequentially
* @param {Number}  [options.timeout] - timeout in seconds for the AJAX request
```

It returns:

```
* @returns {Promise} resolves with response, or reject if something went wrong
```

Usage example:

```javascript
request({
    url: '/',
    method: 'POST',
    data: { foo: 'bar' },
    noToken: false
})
.then(function(response) {
    if (response.data && response.data.something) {
        doSomething();
    }
})
.catch(function(err) {
    logger.error(err);
})
```

### tokenHandler

The tokenHandler is the middle-man between the `core/request` module and the `core/tokenStore`. It is not normally accessed directly, except in special cases (e.g. unit tests).

Usage:

```javascript
// Initialise:
var tokenHandler = tokenHandlerFactory();

// Set an initial token:
tokenHandler.setToken('mytoken').then(function() {
    // ready to be used
});

// Retrieve and use a token (outside of a request):
tokenHandler.getToken().then(function(token) {
    // use token...
});
```

### tokenStore

The tokenStore is an interface for the `core/store` browser-based storage component. It has been decided to create the tokenStore using the `memory` store implementation, for maximum security. The alternative `indexeddb` implementation could also be used instead, for example if it is necessary for the tokens to be shared between multiple open tabs of TAO.

### Token format

A token is pretty simple, it looks like this when in storage:

```json
{
    "value": "c8cd47bab63e1a6c4a9a9017252b1166131e996f",
    "ts": "1554907980137"
}
```

The timestamp allows tokens to be expired when they exceed the lifetime of the PHP session (24 minutes by default). This value can also be configured when instantiating the `tokenHandler`. If all the tokens in the frontend `tokenStore` expire, the user will be prompted to reload the page (thus delivering a fresh batch of tokens).

### Token delivery mechanism

The tokens in the backend pool are provided to the frontend via the call to `/tao/ClientConfig/config` which is made on each page load.

## Backend

TODO