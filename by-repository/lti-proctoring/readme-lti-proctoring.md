# Readme: Lti Proctoring

The LTI Proctoring extension makes the proctoring interface available via LTI

The endpoint for this service to proctor a specific delivery is:
`https://YOUR_DOMAIN/ltiProctoring/ProctoringTool/launch?delivery=YOUR_DELIVERY_URI`

or

`https://YOUR_DOMAIN/ltiProctoring/ProctoringTool/launch/{"delivery":"YOUR_URI"}(base64 encoded)`

This can be auto-generated for the test taker experience using the LTI button in the deliveries section in the TAO admin user-interface. If using this method you will have to manually update the path to target proctoring.

Alternatively all deliveries can be proctored by omitting the delivery parameter
`https://YOUR_DOMAIN/ltiProctoring/ProctoringTool/launch`

The expected role of the proctor is:
`urn:lti:role:ims/lis/TeachingAssistant`