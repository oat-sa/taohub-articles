# Testing LTI with the IMS LTI Tool Consumer emulator

> This article explains how to use TAO LTI applications with the IMS LTI Tool Consumer emulator

## Tasks within TAO

- In the TAO main menu select *Settings (the gears) -> LTI consumers*. 
- Set the label for instance to *IMS*, the *key* and the *secret* to any value. 
- Click on *Create*.
- Open *Deliveries* and select LTI. This creates a URL in the *Launch URL* field. 
- Go back to your newly created LTI consumer and paste the URL in the *Callback URL* field.


## Tasks on the LTI emulator

- Open the [IMS LTI Tool Consumer emulator](http://lti.tools/test/tc.php).
- Complete the *Registration settings* with the values from your *LTI consumer*. 
- Add the role *Learner* in *User Data > Roles*. 

If you need to add custom parameters check *Display optional parameters* and fill in your parameters, using the following syntax:

```ini
    proctored=<true | false>
    max_attempts=<integer>
    theme=<string theme_id>
```
Certain extensions may have there own configuration options. 

Eventually click on *Save data*, then on *Launch TP*.

## Act as a Proctor

The LTI Proctoring extension makes the proctoring interface available via LTI

The endpoint (Launch URL) for this service to proctor a specific delivery is:
`https://YOUR_DOMAIN/ltiProctoring/ProctoringTool/launch?delivery=YOUR_DELIVERY_URI`

or

`https://YOUR_DOMAIN/ltiProctoring/ProctoringTool/launch/{"delivery":"YOUR_URI"}(base64 encoded)`

This can be auto-generated for the test taker experience using the LTI button in the deliveries section in the TAO admin user-interface. If using this method you will have to manually update the path to target proctoring.

Alternatively all deliveries can be proctored by omitting the delivery parameter
`https://YOUR_DOMAIN/ltiProctoring/ProctoringTool/launch`

The expected role of the proctor is:
`urn:lti:role:ims/lis/TeachingAssistant`, which means you need to set *User Data > Roles* to *TeachingAssistant*

## Running Client Diagnostics as a Proctor

- Set the *Launch URL* to `https://YOUR_DOMAIN/ltiClientdiag/ClientdiagTool/launch`
- Set *User Data > Roles* to *TeachingAssistant*