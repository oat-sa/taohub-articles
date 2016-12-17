---
tags: Forge
---

RestResults
===========

Version
-------

Available since TAO 2.6

Endpoint
--------

There are two endpoints one for TAO 2.6 version and the other since TAO 3.0.\
If you are using TAO 2.6 use the following URL :

    http://[Your tao 2.6 Host name]/taoResults/RestResults

else for TAO 3.0 and above use the URL below :

    http://[Your tao 3.0 Host name]/taoResultServer/RestResults

Encoding
--------

    Accept: application/xml

    Accept: application/json

Exception handling
------------------

As the other rest services, you may expect http standard error messages such as 401, 400, 403, … depending on the validity of your request

GET result
----------

\# Retrieve List of Delivery Results

    Accept: application/json



    {  
       "success":true,
       "data":[  
          {  
             "uri":"http:\/\/tao26\/tao26.rdf#i1401263502507166",
             "properties":[  
                {  
                   "predicateUri":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#Identifier",
                   "values":[  
                      {  
                         "valueType":"resource",
                         "value":"http:\/\/tao26\/tao26.rdf#i1401263502655265"
                      }
                   ]
                },
                {  
                   "predicateUri":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#resultOfDelivery",
                   "values":[  
                      {  
                         "valueType":"resource",
                         "value":"http:\/\/tao26\/tao26.rdf#i1401263469976162"
                      }
                   ]
                },
                {  
                   "predicateUri":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#resultOfSubject",
                   "values":[  
                      {  
                         "valueType":"resource",
                         "value":"http:\/\/tao26\/tao26.rdf#i140126348250764"
                      }
                   ]
                },
                {  
                   "predicateUri":"http:\/\/www.w3.org\/1999\/02\/22-rdf-syntax-ns#type",
                   "values":[  
                      {  
                         "valueType":"resource",
                         "value":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#DeliveryResult"
                      }
                   ]
                },
                {  
                   "predicateUri":"http:\/\/www.w3.org\/2000\/01\/rdf-schema#label",
                   "values":[  
                      {  
                         "valueType":"literal",
                         "value":"A label for this data set arising from the execution of a test by a test taker"
                      }
                   ]
                }
             ]
          }
       ],
       "version":"2.6-beta2"
    }


1.  Retrieve all data about one delivery Result

<!-- -->

    Accept: application/json
    uri: http://tao26/tao26.rdf#i1401263502507166


    {  
       "success":true,
       "data":{  
          "http:\/\/tao26\/tao26.rdf#i1401263507808067":[  
             {  
                "value":"1",
                "identifier":"numAttempts",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.76885800 1401263507",
                "cardinality":"single",
                "basetype":"integer"
             },
             {  
                "value":"<'MiddleAges'; 'Prehistory'; 'ContemporaryEra'; 'ModernEra'; 'Antiquity'>",
                "identifier":"RESPONSE",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.81834000 1401263507",
                "cardinality":"ordered",
                "basetype":"identifier"
             },
             {  
                "value":"completed",
                "identifier":"completionStatus",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#OutcomeVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.79241000 1401263507",
                "cardinality":"single",
                "basetype":"identifier"
             },
             {  
                "value":"PT5S",
                "identifier":"duration",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.78083300 1401263507",
                "cardinality":"single",
                "basetype":"duration"
             },
             {  
                "value":"0",
                "identifier":"SCORE",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#OutcomeVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.80524700 1401263507",
                "cardinality":"single",
                "basetype":"float"
             }
          ],
          "http:\/\/tao26\/tao26.rdf#i1401263511454873":[  
             {  
                "value":"9",
                "identifier":"RESPONSE",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.27154400 1401263511",
                "cardinality":"single",
                "basetype":"integer"
             },
             {  
                "value":"0",
                "identifier":"SCORE",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#OutcomeVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.26193700 1401263511",
                "cardinality":"single",
                "basetype":"float"
             },
             {  
                "value":"completed",
                "identifier":"completionStatus",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#OutcomeVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.25223900 1401263511",
                "cardinality":"single",
                "basetype":"identifier"
             },
             {  
                "value":"PT4S",
                "identifier":"duration",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.24330400 1401263511",
                "cardinality":"single",
                "basetype":"duration"
             },
             {  
                "value":"1",
                "identifier":"numAttempts",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.23387700 1401263511",
                "cardinality":"single",
                "basetype":"integer"
             }
          ],
          "http:\/\/tao26\/tao26.rdf#i140126352144279":[  
             {  
                "value":"[Tr Mo; Ga Ju; Ea Ne]",
                "identifier":"RESPONSE",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.05822100 1401263521",
                "cardinality":"multiple",
                "basetype":"pair"
             },
             {  
                "value":"1",
                "identifier":"numAttempts",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.02042500 1401263521",
                "cardinality":"single",
                "basetype":"integer"
             },
             {  
                "value":"1",
                "identifier":"SCORE",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#OutcomeVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.04830100 1401263521",
                "cardinality":"single",
                "basetype":"float"
             },
             {  
                "value":"completed",
                "identifier":"completionStatus",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#OutcomeVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.03844000 1401263521",
                "cardinality":"single",
                "basetype":"identifier"
             },
             {  
                "value":"PT9S",
                "identifier":"duration",
                "type":{  
                   "uriResource":"http:\/\/www.tao.lu\/Ontologies\/TAOResult.rdf#ResponseVariable",
                   "label":"",
                   "comment":"",
                   "debug":""
                },
                "epoch":"0.02949700 1401263521",
                "cardinality":"single",
                "basetype":"duration"
             }
          ]
       },
       "version":"2.6-beta2"
    }

