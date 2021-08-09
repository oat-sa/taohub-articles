# How to use QTI Result API

> A REST api to explore TAO results is available. All results follow the [QTI 2.1 standard](https://www.imsglobal.org/question/index.html#version2.1)

* Note: requires TAO >= 3.1

## Request to API

The entry point is located on taoResultServer extension:

```
    http://_your_tao_server_/taoResultServer/QtiRestResults
```

This API is only available via the HTTP GET method for the moment. It has two endpoints.

- `getLatest`: requires two parameters, `testtaker uri` and `delivery uri`
- `getQtiResultXml`: requires two parameters, `delivery uri` and `result identifier`.

## Response from API

All responses are REST compliant.

- **200 - OK**
    Request was correctly handled, there are some results

- **400 - Bad request**
    Error on request sent to API, occurs in case of missing parameter(s) (testtaker and delivery mandatory or deliveryExecution mandatory)<br>
    Error message: *At least one mandatory parameter was required but found missing in your request*

- **401 - Unauthorized**
    Supplied credentials are not valid

- **404 - Not Found**
    Request was correctly handled, there are no result<br>
    Error message: *Provided parameters don't match with any delivery execution.*

- **405 - Method Not Allowed**
    Used method is not allowed

- **406 - Not Acceptable**
    The request can not be accepted by the server.

- **500 - Internal error**
    Should never happen

## Swagger description

https://hub.taocloud.org/restapis/tag/tao-outcome

## Sample code

```php
    // Entry point of QTI results api
    $apiUrl = 'http://taoLocation.com/taoResultServer/QtiRestResults';

    // Parameters required to proceed request, take care to escape uri variable
    $testtakerUri = urlencode('http://tao.local/mytao.rdf#xxxxxxxxxxxx');
    $deliveryUri = urlencode('http://tao.local/mytao.rdf#xxxxxxxxxxxx');

    // Case A: Result id for delivery execution
    $resultId = urlencode('http://tao.local/mytao.rdf#xxxxxxxxxxxx');

    // Case B: Result id for LTI delivery.
    $resultId = 'bf29e71611330b19a723e2bed6f47255';

    // Initialize the cURL request to get the latest results for a given test-taker and delivery
    $process = curl_init($apiUrl . '/getLatest?testtaker=' . $testtakerUri . '&delivery=' . $deliveryUri);

    // OR Initialize the cURL request to get a specific result (by default the result identifier is the same as the delivery execution identifier)
    $process = curl_init($apiUrl . '/getQtiResultXml?delivery=' . $deliveryUri . '&result=' . $resultId);

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

```

## Example of a QTI result

```xml
    <assessmentResult xmlns="http://www.imsglobal.org/xsd/imsqti_result_v2p1">
        <context sourcedId="i146159695175850"/>
        <testResult identifier="rdf#i1461597149361066" datestamp="2016-04-25T15:13:10.692">
            <outcomeVariable identifier="SECTION_EXIT_CODE_assessmentSection-1" cardinality="single" baseType="string">
                <value>700</value>
            </outcomeVariable>
            <outcomeVariable identifier="LtiOutcome" cardinality="single" baseType="float">
                <value>0</value>
            </outcomeVariable>
        </testResult>
        <itemResult identifier="item-1" datestamp="2016-04-25T15:12:44.790" sessionStatus="final">
            <responseVariable identifier="numAttempts" cardinality="single" baseType="integer">
                <candidateResponse>
                    <value>
                        <![CDATA[ 1 ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <responseVariable identifier="duration" cardinality="single" baseType="duration">
                <candidateResponse>
                    <value>
                        <![CDATA[ PT12.336017S ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <outcomeVariable identifier="completionStatus" cardinality="single" baseType="identifier">
                <value>
                    <![CDATA[ completed ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="SCORE" cardinality="single" baseType="float">
                <value>
                    <![CDATA[ 0 ]]>
                </value>
            </outcomeVariable>
            <responseVariable identifier="RESPONSE" cardinality="single" baseType="directedPair">
                <candidateResponse>
                    <value>
                        <![CDATA[ M A ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <outcomeVariable identifier="ITEM_END_TIME_CLIENT" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ 1461597162.52 ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="ITEM_TIMEZONE" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ +02:00 ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="ITEM_START_TIME_CLIENT" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ 1461597157.988 ]]>
                </value>
            </outcomeVariable>
        </itemResult>
        <itemResult identifier="item-2" datestamp="2016-04-25T15:12:59.335" sessionStatus="final">
            <responseVariable identifier="numAttempts" cardinality="single" baseType="integer">
                <candidateResponse>
                    <value>
                        <![CDATA[ 1 ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <responseVariable identifier="duration" cardinality="single" baseType="duration">
                <candidateResponse>
                    <value>
                        <![CDATA[ PT13.052298S ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <outcomeVariable identifier="completionStatus" cardinality="single" baseType="identifier">
                <value>
                    <![CDATA[ completed ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="SCORE" cardinality="single" baseType="float">
                <value>
                    <![CDATA[ 0 ]]>
                </value>
            </outcomeVariable>
            <responseVariable identifier="RESPONSE" cardinality="multiple" baseType="pair">
                <candidateResponse>
                    <value>
                        <![CDATA[ a M ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <outcomeVariable identifier="ITEM_END_TIME_CLIENT" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ 1461597177.703 ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="ITEM_TIMEZONE" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ +02:00 ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="ITEM_START_TIME_CLIENT" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ 1461597169.499 ]]>
                </value>
            </outcomeVariable>
        </itemResult>
        <itemResult identifier="item-3" datestamp="2016-04-25T15:13:09.481" sessionStatus="final">
            <responseVariable identifier="numAttempts" cardinality="single" baseType="integer">
                <candidateResponse>
                    <value>
                        <![CDATA[ 1 ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <responseVariable identifier="duration" cardinality="single" baseType="duration">
                <candidateResponse>
                    <value>
                        <![CDATA[ PT9.128763S ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <outcomeVariable identifier="completionStatus" cardinality="single" baseType="identifier">
                <value>
                    <![CDATA[ completed ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="SCORE" cardinality="single" baseType="float">
                <value>
                    <![CDATA[ 0 ]]>
                </value>
            </outcomeVariable>
            <responseVariable identifier="RESPONSE" cardinality="ordered" baseType="identifier">
                <candidateResponse>
                    <value>
                        <![CDATA[ ContemporaryEra ]]>
                    </value>
                    <value>
                        <![CDATA[ ModernEra ]]>
                    </value>
                    <value>
                        <![CDATA[ Antiquity ]]>
                    </value>
                </candidateResponse>
            </responseVariable>
            <outcomeVariable identifier="ITEM_END_TIME_CLIENT" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ 1461597187.557 ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="ITEM_TIMEZONE" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ +02:00 ]]>
                </value>
            </outcomeVariable>
            <outcomeVariable identifier="ITEM_START_TIME_CLIENT" cardinality="single" baseType="string">
                <value>
                    <![CDATA[ 1461597182.959 ]]>
                </value>
            </outcomeVariable>
        </itemResult>
    </assessmentResult>
```