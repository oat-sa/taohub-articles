How to use Lti User API
=======================

A REST api to convert the **LTI consumer** user id to the **Tao** user uri. Available since Tao 3.1.

Request to API
--------------

The entry point is located in the taoLti extension:

    http://taoLocation.com/taoLti/RestService/getUserId

This API is only available with HTTP GET method for the moment.

It requires two parameters, *user\_id* (LTI user id) and *oauth\_consumer\_key* (LTI consumer key).

The API works in conjunction with the TAO LTI implementation, which is compliant with IMS LTI v1.1.1 specification (http://www.imsglobal.org/specs/ltiv1p1p1)

Response from API
-----------------

All responses are REST compliant responses.

\* 200 - OK

1.  Request was correctly handled, there is an associated user uri.

\* 400 - Bad request

1.  Error on request sent to API, occurs in case of missing parameter(s) (id & consumer key mandatories)\
    *ErrorMsg: At least one mandatory parameter was required but found missing in your request*

\* 401 - Unauthorized

1.  Supplied credentials are not valid

\* 404 - No found

1.  Request was correctly handle, but there are no result for the given consumer key\
    *ErrorMsg: No Credentials for consumer key xxxxx*
2.  Request was correctly handle, but there are no result for the given user id\
    *ErrorMsg: No data found for the given id*

\* 500 - Internal error

1.  Should never happens!

Sample code
-----------


    // Entry point of Lti delivery api
    $apiUrl = 'http://taoLocation.com/taoLti/RestService/getUserId';

    // Parameters required to proceed request, take care to escape uri variable
    $lti_user_id = '12345';
    $lti_consumer_key = '78910';

    // Initialize the cURL request
    $process = curl_init($apiUrl . '?user_id=' . $lti_user_id . '&oauth_consumer_key=' . $lti_consumer_key);

    // Call api with HTTP GET method
    curl_setopt($process, CURLOPT_HTTPGET, 1);

    // Choose your output
    curl_setopt($process, CURLOPT_HTTPHEADER, array("Accept: application/json"));

    // Get response as a string instead of output it directly
    curl_setopt($process, CURLOPT_RETURNTRANSFER , true);

    // Set up your TAO credential
    curl_setopt($process, CURLOPT_USERPWD, "user:password");

    // Proceed the curl request
    $data = curl_exec($process);

    // REST communicate through HTTP code, take care of it
    $httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);

     // Close process handling
    curl_close($process);

Example of Lti User Api resonse
-------------------------------


     //In case of success, http code = 200
    {
      "success": true,
      "data": {
        "id": "http://tao.local/mytao.rdf#xxxxxxxxxxxxx"
      },
      "version": "3.1.0"
    }

    //In case of malformed error, http code = 400
    {
      "success": false,
      "errorCode": 0,
      "errorMsg": "At least one mandatory parameter was required but found missing in your request",
      "version": "3.1.0"
    }

