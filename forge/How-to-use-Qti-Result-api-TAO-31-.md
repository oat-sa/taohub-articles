---
tags: Forge
---

How to use QTI Result API (\>=TAO 3.1)
======================================

A REST api to explore TAO results is available. All results follow QTI 2.1 standard describe on *https://www.imsglobal.org/question/index.html\#version2.1*

Request to API
--------------

The entry point is located on taoResultServer extension:

    http://taoLocation.com/taoResultServer/QtiRestResults

This API is only available with HTTP GET method for the moment.

It accepts two scenarios:

-   By testtaker and delivery uri, it requires two parameters, testtaker uri and delivery uri.
-   By deliveryExecution, it requires one parameter, deliveryExecution uri

Response from API
-----------------

All responses are REST compliant responses.

\* 200 - OK

1.  Request was correctly handled, there are some results

\* 400 - Bad request

1.  Error on request sent to API, occurs in case of missing parameter(s) (testtaker and delivery mandatory or deliveryExecution mandatory)\
    *Error message: At least one mandatory parameter was required but found missing in your request*

\* 401 - Unauthorized

1.  Supplied credentials are not valid

\* 404 - Not Found

1.  Request was correctly handled, there are no result\
    *Error message: Provided parameters don’t match with any delivery execution.*

\* 500 - Internal error

1.  Should never happens!

Sample code
-----------


    // Entry point of QTI results api
    $apiUrl = 'http://taoLocation.com/taoResultServer/QtiRestResults';

    // Parameters required to proceed request, take care to escape uri variable
    $testtakerUri = urlencode('http://tao.local/mytao.rdf#xxxxxxxxxxxx');
    $deliveryUri = urlencode('http://tao.local/mytao.rdf#xxxxxxxxxxxx');
    $deliveryExecution = urlencode('http://tao.local/mytao.rdf#xxxxxxxxxxxx');

    // Initialize the cURL request by testtaker & delivery
    $process = curl_init($apiUrl . '?testtaker=' . $testtakerUri . '&delivery=' . $deliveryUri);

    // OR Initialize the cURL request by deliveryExecution
    $process = curl_init($apiUrl . '?deliveryExecution=' . $deliveryExecution);

    // Call api with HTTP GET method
    curl_setopt($process, CURLOPT_HTTPGET, 1);

    // Choose your output, QTI data is based on XML
    curl_setopt($process, CURLOPT_HTTPHEADER, array("Accept: application/xml"));

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

Example of QTI result
---------------------
