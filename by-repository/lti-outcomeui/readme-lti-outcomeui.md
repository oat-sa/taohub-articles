# Readme: Lti Outcomeui

The LTI Outcome extension allows to manage results via LTI

The endpoint to preview a result by deliveryId and item reference:
`https://YOUR_DOMAIN/ltiOutcomeUi/ItemResultPreviewer/launch?resultId=YOUR_RESULT_URI&itemRef=YOU_ITEM_REF`

ItemRef can be easily find by delivery by the `getQtiResults` described <a href="https://hub.taocloud.org/restapis/tao-outcome/qti-result-rest-api#!/result/get_taoResultServer_QtiRestResults_getQtiResultXml">here</a>

The expected roles is:
* `Instructor`