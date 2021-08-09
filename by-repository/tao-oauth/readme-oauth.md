# Readme: Oauth

Extension to easily configure an OAuth client for OAT platform.

### Setting up OAuth{#setting-up-oauth}

1. At host server run console script to generate credentials:
`php index.php '\oat\taoOauth\scripts\tools\GenerateCredentials'  -r $role` . (final bash inliner may vary according to your server);
It will return $key, $secret and $tokenUrl, which should be used to generate auth token. This data should be stored in your client env. 

Response:
    
    Client generated with credentials :
     - client key  : c35b263b78fa20aa560702a232fff5fc
     - client secret  : GSJ2z6xH3E3MelJbXA6AmQeQeYfCRueg3af9a92aba6bfc28559a8c5689adbc87fd901f18b00671e3bc5d5566f5af5e38
     - token url  : https://taotesting.com/taoOauth/TokenApi/requestToken
    

2. If your client server works with Tao, you can run script which will import credentials to allow authentication against host server:
`php index.php '\oat\taoOauth\scripts\tools\ImportConsumer' -k $key -s $secret -tu $tokenUrl -r $role`.

### Using OAuth authentication{#using-oauth-authentication}

After generate of credentials you need to generate token for connections to the tao endpoints. For this you need to make request:

    curl -X POST \
      https://taotesting.com/taoOauth/TokenApi/requestToken \
      -H 'Accept: application/json' \
      -H 'Cache-Control: no-cache' \
      -H 'Content-Type: application/json' \
      -d 'client_id=c35b263b78fa20aa560702a232fff5fc&client_secret=GSJ2z6xH3E3MelJbXA6AmQeQeYfCRueg3af9a92aba6bfc28559a8c5689adbc87fd901f18b00671e3bc5d5566f5af5e38'
where `$key` and `$secret` your credentials from previous example.

It will return `$access_token` and `$expires`, which should be used to generate `Authorization` header:

      {
          "access_token": "hJFpTCo9Bvd30b7eb63ef28af1a7ce081252e9844053a9a4a38112ecb8c41eeedfd58f8907",
          "expires": 1521475157
      }
      
##### Request with OAuth `Authorization` header{#request-with-oauth-authorization-header}

Example:

       curl -X GET \
            'https://taotesting.com/taoDeliveryRdf/RestDelivery/getStatus?id=https%3A%2F%2Ftaotesting.com%2Ftao.rdf%23i15203488932024127 \
            -H 'Accept: application/json' \
            -H 'Authorization: Bearer hJFpTCo9Bvd30b7eb63ef28af1a7ce081252e9844053a9a4a38112ecb8c41eeedfd58f8907' \
            -H 'Cache-Control: no-cache' \
            -H 'Content-Type: application/json' \