<!--
parent: 'Items'' API'
created_at: '2011-03-04 11:29:03'
updated_at: '2014-03-07 13:51:15'
authors:
    - 'Joel Bout'
tags:
    - 'Items'' API'
-->



![](http://forge.taotesting.com/attachments/download/760/attention.png)**This page is deprecated since TAO 2.5 please visit Item API**

Item Scoring
============

TAO provides a response matching API for items, called the Item Scoring API. There are two available modes for response matching:

-   matching on server side (PHP): ensures the response security, since the right answers will be kept on the server
-   client side (Javascript): ensures interoperability, so you can “plug” and “unplug” your item into and out of TAO easily

todo
----

-   Initialization : Initialize in server mode : Exemple : Explain correctly the default behavior. Make a link to the result exploitation documentation.
-   Explain outcome variables

Initialization
--------------

Firstly you need to include the API, you can either:

-   download the TAO API standalone package {{:developers:tao:tao_extension_item:taoMatchingApi.zip|here}}
-   use the version included in the TAO distribution at /taoItems/views/js/taoMatching/taoMatching.min.js

and ensure that it is included into your html page

Secondly you need to initialize the matching engine. The matching can take several parameters. Depending on these parameters the engine will be initialized in client mode or in server mode.

### Initialize in client mode

To initialize the response matching engine on client side, add the following code (javascript) to your own script.

    matchingInit ({
        "data"    :   {
            "rule"          : [string]
            , "corrects"    : [TaoMatchingVariable]
            , "maps"        : [TaoMappingVariables]
            , "outcomes"    : [TaoMatchingVariable]
            , "responses"   : [TaoMatchingVariable]
        }
    });

By setting the parameter **data** the matching API will be initialized in local client mode. You can define the matching data directly during the initialization or later through the provided API functions.

*rule* (Item Scoring API\#Rules|TaoMatchingRule) : The rule that will be used to evaluate the user’s responses;

*corrects* (Item Scoring API\#Variables|TaoMatchingVariable) : The correct responses of the item;

*maps* (Item Scoring API\#Mapping-Variables|TaoMappingVariable[<br/>
*]) : The mapping responses of the item;

*outcomes* (Item Scoring API\#Variables|TaoMatchingVariable[<br/>
*]) : The outcome variables of the item;

*responses* (Item Scoring API\#Variables|TaoMatchingVariable[<br/>
*]) : The user’s responses;

##### Example

For instance, a single qti *choice interaction* is initialized on the local matching engine as follows.

    matchingInit ({
        "data"    :   {
            "rule"          : TAO_MATCHING.RULE.MATCH_CORRECT
            , "corrects"    : [{"identifier":"RESPONSE", "value":"identifier1"}]
            , "outcomes"    : [{"identifier":"SCORE", "type":"double"}]
        }
    });

*rule* : Here the matching engine will evaluate the user’s response with the predefined template rule Item Scoring API\#Match-Correct-Template|TAO_MATCHING.RULE.MATCH_CORRECT.

*corrects* : Based on the given correct variable **RESPONSE** initialized with the value **identifier1**, the rule is waiting for a user’s response of type string and with single cardinality. See how the template rule works (Item Scoring API\#Match-Correct-Template|TAO_MATCHING.RULE.MATCH_CORRECT)

*outcomes* : Initialization of an outcome variable identified by **SCORE** with a type double. See how the template rule works (Item Scoring API\#Match-Correct-Template|TAO_MATCHING.RULE.MATCH_CORRECT)

### Initialize in server mode

By setting the parameter **url** the matching API will be initialized in remote server mode. This provides you a secure way to evaluate the user’s responses.

    matchingInit ({
        url         : "YOUR_MATCHING_ENGINE_REMOTE_URL"
        , params    : {}
    });

*url* (string) : The url of the remote matching engine.

*params* (object): The parameters be sent to the remote matching engine. You can set as many parameters as you want in this attribute.

##### Example

    matchingInit ({
        url         : "/taoDelivery/ResultDelivery/evaluate"
        , params    : {
            token   : getToken ()
        }
    });

*url* (string) : Here we call the default TAO Delivery service to evaluate the user’s responses. This service will record the input (user’s responses), **compare them against the defined correct responses on the server** and record the output (outcome variables) in the TAO Result Module.

*params* (object): In TAO environment the attribute **token** reserved and used to exchange an identification token to the remote matching engine.

Variables
---------

### Definition

All variables (corrects, outcomes & responses) are defined following the model :

    {
        "identifier":[string]
        , "value":[TaoValueFormat]
    }

*identifier* (string) : Identifier of the variable;

*value* (Item Scoring API\#Value-Format|taoValueFormat) : Value of the variable;

*type* (string) (optional) : One of the available types of variable : string, float, integer, tuple, list. For the known types if the value has been defined, the type will be infered based on it;

### Value format

The value of a variable accept the following representation :

#### Scalar types

*string* :

    {
        "identifier":"RESPONSE"
        , "value":"my response"
    }

*float* :

    {
        "identifier":"RESPONSE"
        , "value":3.1415
    }

*integer* :

    {
        "identifier":"RESPONSE"
        , "value":123456
    }

*boolean* :

    {
        "identifier":"RESPONSE"
        , "value":true
    }

#### Container types

*list* : The container list accepts a list of variables of the same type.

    {
        "identifier":"RESPONSE"
        , "value":[
            "val1"
            , "val2"
            , "val3"
        ]
    }

*tuple* : The container tuple accepts an ordered list of variables of the same type.

    {
        "identifier":"RESPONSE"
        , "value":{
            "0":   true
            , "1": false
            , "2": true
        }
    }

#### List of containers

*list of list* :

    {
        "identifier":"RESPONSE"
        , "value":[
            [1,2]
            , [3,4]
            , [5,6]
        ]
    }

*list of tuple* :

    {
        "identifier":"RESPONSE"
        , "value":[
            {
                "0":1
                , "1":2
            }
            , {
                "0":3,
                "1":4
            }
            , {
                "0":5
                , "1":6
            }
        ]
    }

### Mapping Variables

#### Definition

Mapping variables are special variables used to create a mapping from a source of any base type to a single float. Based on the specification of QTI a mapping variable allows test creator to :

-   **Map** users’ answer with a value set
-   **Control** the lower and upper value of the result
-   To that, **allow** item creator to manage the *default value* to use if no map entry is found for a source value.

Mapping variables are defined following the model :

    {

    bq. "identifier":[string]
    bq. , "defaultValue":[float]
    bq. , "lowerBound":[float]
    bq. , "upperBound":[float]
    bq. , "value":[MapEntry][*]

    }

*identifier* (string) : Identifier of the variable to map;

*value* (Item Scoring API\#Map-Entry|mapEntry) : The map is defined by a set of mapEntries, each of which maps a single value from the source set onto a single float;

*defaultValue* (float) : The default value from the target set to be used when no explicit mapping for a source value is given.

*lowerBound* (float) : (Optional) The lower bound for the result of mapping a container. If unspecified there is no lower-bound.

*upperBound* (float) : (Optional) The upper bound for the result of mapping a container. If unspecified there is no upper-bound.

#### Examples

By example for a multiple choice item where the instruction is to select the correct elements which are used to form the water.

We purpose to the test taker the following choices :

-   Hydrogen
-   Helium
-   Carbon
-   Oxygen
-   Nitrogen
-   Chlorine

But we want a special behavior :

-   –1 for each bad choice
-   +1 for each good choice
-   –2 for the mercure which is a very dangerous element.

Moreover to avoid very bad score we want to limit the lower score to –1.

Look at the example below which explains how to use the mapping variable to solve our problem :

    {
    "identifier":"RESPONSE"
    , "defaultValue":-1
    , "lowerBound":-1
    , "value":[{"key":"Hydrogen", "value":1}, {"key":"Oxygen", "value":1}, {"key":"mercure", "value":-2}]
    }

### Map Entry

Map entry are special variables used by the mapping variable to create a mapping from a source variable to a single float. Map entry variables are defined following the model :

    {

    bq. "key":[TaoValueFormat]
    bq. , "value":[float]

    }

*key* (Item Scoring API\#Value-Format|taoValueFormat) : The value be used to map a source value;

*value* (float) : The value to use if the source match the key;

Rules
-----

### Templates

#### Match Correct Template

The match correct response processing template uses the Item Scoring API\#Custom-Rules|match operator to match the value of a response variable (idenfitified by RESPONSE) with its correct value (identified by RESPONSE). It sets the outcome variable SCORE to either 0 or 1 depending on the outcome of the test. A response variable called RESPONSE must have been declared and have an associated correct value. Similarly, the outcome variable SCORE must also have been declared. The template applies to responses of any baseType and cardinality though bear in mind the limitations of matching more complex data types.

Note that the match correct template is strongly linked to the behavior of the Item Scoring API\#Custom-Rules|match operator : the correct variables and user’s responses associated to the same identifier (RESPONSE) must be the same type, the outcome variable SCORE will be set to 0 otherwise.

This template rule is defined with the constant *TAO_MATCHING.RULE.MATCH_CORRECT*.

*template code* :

    if (match(null, getResponse("RESPONSE"), getCorrect("RESPONSE"))){
        setOutcomeValue("SCORE", 1);
    } else {
        setOutcomeValue("SCORE", 0);
    }

#### Map Response Template

The map response processing template uses the Item Scoring API\#Custom-Rules|mapResponse operator to map the value of a response variable (idenfitified by RESPONSE) onto a value for the outcome SCORE. Both variables must have been declared and RESPONSE must have an associated mapping. The template applies to responses of any baseType and cardinality.

This template rule is defined in the constant *TAO_MATCHING.RULE.MAP_RESPONSE*.

*template code* :

    if(isNull(null, getResponse("RESPONSE"))) {
        setOutcomeValue("SCORE", 0);
    } else {
        setOutcomeValue("SCORE", mapResponse(null, getMap("RESPONSE"), getResponse("RESPONSE")));
    }

#### Examples

##### Single choice interaction

For instance, a single choice interaction is initialized in the local matching engine as follows :

    matchingInit ({
        "data"    :   {
            "rule"          : TAO_MATCHING.RULE.MATCH_CORRECT
            , "corrects"    : [{"identifier":"RESPONSE", "value":"identifier1"}]
            , "outcomes"    : [{"identifier":"SCORE", "type":"double"}]
        }
    });

With regard to the behavior of the template “match correct”, please note that the engine expects a user’s response (identified by RESPONSE) of the same type as the correct variable (identified by RESPONSE). After the user’s responses have been collected, the **matchingSetResponses** is called to notify the matching engine the new user’s responses.

    matchingSetResponses ([
        {"identifier":"RESPONSE", "value":"identifier1"}
    ]);

After that you just have to launch the response matching by calling the **matchingEvaluate()** method.

    matchingEvaluate ();

After the evaluation of the user’s response done you could get the outcome variables as follows :

    var outcomes = matchingGetOutcomes ();
    // {
    //    "SCORE" : {"identifier":"SCORE", "value":1}
    // }

##### Multiple choice interaction

    matchingInit ({
        "data"    :   {
            "rule"          : TAO_MATCHING.RULE.MATCH_CORRECT
            , "corrects"    : [{"identifier":"RESPONSE", "value":["identifier1", "identifier2"]}]
            , "outcomes"    : [{"identifier":"SCORE", "type":"double"}]
        }
    });

After collecting the user’s responses.

    matchingSetResponses ([
        {"identifier":"RESPONSE", "value":["identifier1", "identifier2"]}
    ]);
    // ["identifier2", "identifier1"]
    // ["identifier2", "identifier12"]

After that you just have to launch the evaluation by calling the **matchingEvaluate()** method.

    matchingEvaluate ();

After the evaluation of the user’s response, you can get the outcome variables as follows :

    var outcomes = matchingGetOutcomes ();
    // { "SCORE" : {"identifier":"SCORE", "value":1} }
    // 1 with ["identifier2", "identifier1"] the list is not ordered
    // 0 with ["identifier2", "identifier12"] the user's response is not exact

##### Map a text

In the case of free text entry you will need to map the user’s responses with a set of predefined responses. The template Item Scoring API\#Map-Response-Template|MAP_RESPONSE could be relevant in such a case.

    matchingInit ({
        "data"    :   {
            "rule"          : TAO_MATCHING.RULE.MAP_RESPONSE
            , "corrects"    : [{"identifier":"RESPONSE", "value":"Paris"}]
            , "maps"        : [{
                "identifier":"RESPONSE"
                , "value":
                [
                    {"key":"Paris", "value":1}
                    , {"key":"paris", "value":0.8}
                    , {"key":"Pari", "value":0.6}
                    , {"key":"pari", "value":0.4}
                    , {"key":"pas riz", "value":0.1}
                ]
            }]
            , "outcomes"    : [{"identifier":"SCORE", "type":"double"}]
        }
    });

After collecting the user’s responses.

    matchingSetResponses ([{"identifier":"RESPONSE", "value":"Paris"}]);
    // paris
    // Pari
    // pari
    // pas riz
    // Lyon

    matchingEvaluate ();

    var outcomes = matchingGetOutcomes ();
    // {"SCORE" : {"identifier":"SCORE", "value":1}}
    // 0.8 for paris
    // 0.6 for Pari
    // 0.4 for pari
    // 0.1 for paris
    // 0 for Lyon

### Custom Rules

The real power is Item Scoring API\#Custom-Rules|here. The TAO Matching API provides a set of operators to evaluate an item and its variables. Whatever the rule it can be interpreted both on client and server side.

*Set of available operators* :

        /**
         * The and operator takes one or more sub-expressions each with a base-type
         * boolean and single cardinality. The result is a single boolean which is
         * if all sub-expressions are true and false if any of them are false.
         * @param  array options
         * @return boolean
         */
        and : function(options, (expr1 ... exprN))
        /**
         * Create a variable functions of the arguments.
         * Create either scalar or container from the value :
         * createVariable (null, 3.1415);
         * createVariable (null, Array ("TAO", "Test Assisté par Ordinateur"))
         * Create container following the options.type and the arguments of the
         * createVariable (Array("type"=>"list"), "TAO", "Test Assisté par
         * @param  array options
         * @return taoItems_models_classes_Matching_Variable
         */
        , createVariable : function (options, (value1 ... valueN))
        /** The contains function takes two sub-expressions. The first one has
         * a cardinality  (either list or tuple).
         * The second one could have any base type and could have the same
         * cardinality than the first expression or it could have a single
         * cardinality.
         * The result is a single boolean with a value of true if the container
         * given by the first sub-expression contains the value given by the
         * second sub-expression and false if it doesn't. Note that the contains
         * operator works differently depending on the cardinality of the two
         * sub-expressions.
         * For unordered containers the values are compared without regard for
         * ordering, for example, [A,B,C] contains [C,A]. Note that [A,B,C]
         * does not contain [B,B] but that [A,B,B,C] does. For ordered containers
         * the second sub-expression must be a strict sub-sequence within the
         * first. In other words, [A,B,C] does not contain [C,A] but it does
         * contain [B,C].
         * @param  options
         * @param  expr1
         * @param  expr2
         * @return taoItems_models_classes_Matching_bool
         */
        , contains : function (options, expr1, expr2)
        /**
         * The divide operator takes 2 sub-expressions which both
         * have single cardinality and numerical base-types. The
         * result is a single float that corresponds to the first
         * expression divided by the second expression. If either
         * of the sub-expressions is NULL then the operator
         * results in NULL.
         * @param  options
         * @param  expr1
         * @param  expr2
         */
        , divide : function (options, expr1, expr2)
        /**
         * The equal operator takes two sub-expressions which must both have single
         * and have a numerical base-type. The result is a single boolean with a
         * of true if the two expressions are numerically equal and false if they
         * not.
         * @param  array options
         * @param  expr1
         * @param  expr2
         * @return boolean
         */
        , equal : function(options, expr1, expr2)
        /**
         * Get a correct variable from its identifier
         * @param  string id
         * @return taoItems_models_classes_Matching_Variable
         */
        , getCorrect : function(identifier)
        /**
         * Get a mapping variable from its identifier
         * @param  string id
         * @param  string type
         * @return taoItems_models_classes_Matching_Map
         */
        , getMap : function(identifier, type)
        /**
         * Get an outcome variable from its identifier
         * @param  string id
         * @return taoItems_models_classes_Matching_Variable
         */
        , getOutcome : function(identifier)
        /**
         * Get a variable from its identifier
         * @param  string id
         * @return taoItems_models_classes_Matching_Variable
         */
        , getVariable : function(identifier)
        /**
         * Get a response variable from its identifier
         * @param  string id
         * @return taoItems_models_classes_Matching_Variable
         */
        , getResponse : function(identifier)
        /**
         * The gt operator takes two sub-expressions which must
         * both have single cardinality and have a numerical
         * base-type. The result is a single boolean with a value
         * of true if the first expression is numerically greater
         * than the second and false if it is less than or equal
         * to the second.
         * @param  options
         * @param  expr1
         * @param  expr2
         * @return boolean
         */
        , gt : function (options, expr1, expr2)
        /**
         * The gte operator takes two sub-expressions which must
         * both have single cardinality and have a numerical base-type.
         * The result is a single boolean with a value of true if the first
         * expression is numerically less than or equal to the second
         * and false if it is greater than the second.
         * @param  options
         * @param  expr1
         * @param  expr2
         * @return boolean
         */
        , gte : function (options, expr1, expr2)
        /**
         * The integer divide operator takes 2 sub-expressions which
         * both have single cardinality and base-type integer. The result
         * is the single integer that corresponds to the first expression
         * (x) divided by the second expression (y) rounded down to
         * the greatest integer (i) such that i<=(x/y).
         * @param  options
         * @param  expr1
         * @param  expr2
         * @return int
         */
        , integerDivide : function (options, expr1, expr2)
        /**
         * The isNull operator takes a sub-expression with any base-type and
         * The result is a single boolean with a value of true if the sub-expression
         * NULL and false otherwise.
         * @param  array options
         * @param  Variable var
         * @return boolean
         */
        , isNull : function(options, matchingVar)
        /**
         * The lt operator takes two sub-expressions which must both
         * have single cardinality and have a numerical base-type. The
         * result is a single boolean with a value of true if the first
         * expression is numerically less than the second and false if
         * t is greater than or equal to the second.
         * @param  options
         * @param  expr1
         * @param  expr2
         * @return boolean
         */
        , lt : function (options, expr1, expr2)
        /**
         * The lte operator takes two sub-expressions which must both
         * have single cardinality and have a numerical base-type. The
         * result is a single boolean with a value of true if the first
         * expression is numerically less than or equal to the second
         * and false if it is greater than the second.
         * @param  options
         * @param  expr1
         * @param  expr2
         * @return boolean
         */
        , lte : function (options, expr1, expr2)
        /**
         * This expression looks up the value of a responseVariable and then
         * it using the associated mapping, which must have been declared. The
         * is a single float. If the response variable has single cardinality then
         * value returned is simply the mapped target value from the map. If the
         * variable has single or multiple cardinality then the value returned is
         * sum of the mapped target values. This expression cannot be applied to
         * of record cardinality.
         *
         * For example, if a mapping associates the identifiers {A,B,C,D} with the
         * {0,1,0.5,0} respectively then mapResponse will map the single value 'C'
         * the numeric value 0.5 and the set of values {C,B} to the value 1.5.
         *
         * If a container contains multiple instances of the same value then that
         * is counted once only. To continue the example above {B,B,C} would still
         * to 1.5 and not 2.5.
         *
         * @param  array options
         * @param  Map map
         * @param  Variable expr
         * @return double
         */
        , mapResponse : function(options, mappingVar, matchingVar)
        /**
         * This expression looks up the value of a responseVariable that must be of
         * point , and transforms it using the associated areaMapping. The
         * is similar to mapResponse except that the points are tested
         * against each area in turn. When mapping containers
         * each area can be mapped once only. For example, if the
         * candidate identified two points that both fall in the same
         * area then the mappedValue is still added to the
         * calculated total just once.
         * @param  array options
         * @param  AreaMap map
         * @param  Variable expr
         * @return double
         */
        , mapResponsePoint : function(options, mappingVar, matchingVar)
        /**
         * The match operator takes two sub-expressions which must both have the
         * type and cardinality. The result is a single boolean with a value of true
         * the two expressions represent the same value and false if they do not.
         * @param  array options
         * @param  expr1
         * @param  expr2
         * @return boolean
         */
        , match : function(options, expr1, expr2)
        /**
         * The not operator takes a single sub-expression with a
         * base-type of boolean and single cardinality. The result is a
         * single boolean with a value obtained by the logical negation
         * of the sub-expression's value.
         * @param  options
         * @param  expr
         * @return boolean
         */
        , not : function (options, expr)
        /**
         * The or operator takes one or more sub-expressions each with a base-type
         * boolean and single cardinality. The result is a single boolean which is
         * if any of the sub-expressions are true and false if all of them are
         * If one or more sub-expressions are NULL and all the others are false then
         * operator also results in NULL.
         * @param  options
         * @return boolean
         */
        , or : function(options, (expr1 ... exprN))
        /**
         * The product operator takes 1 or more sub-expressions which
         * all have single cardinality and have numerical base-types.
         * The result is a single float or, if all sub-expressions are of
         * integer type, a single integer that corresponds to the
         * product of the numerical values of the sub-expressions.
         * @param  options
         */
        , product : function (options)
        /**
         * Selects a random integer from the specified range [min,max] satisfying
         * + step * n for some integer n. For example, with min==2, max=11 and step==3
         * values {2,5,8,11} are possible.
         * @param  options
         * @return int
         */
        , randomInteger : function (options)
        /**
         * Selects a random float from the specified range [min,max].
         * @param  options
         * @return double
         */
        , randomFloat : function (options)
        /**
         * The round operator takes a single sub-expression which
         * must have single cardinality and base-type float. The
         * result is a value of base-type integer formed by rounding
         * the value of the sub-expression. The result is the integer
         * n for all input values in the range [n-0.5,n+0.5). In other
         * words, 6.8 and 6.5 both round up to 7, 6.49 rounds down
         * to 6 and -6.5 rounds up to -6.
         * @param  options
         * @param  expr
         */
        , round : function (options, expr)
        /**
         * The setOutcomeValue sets the value of an outcomeVariable.
         * @param  string id
         * @param  value
         * @return mixed
         */
        , setOutcomeValue : function(identifier, value)
        /**
         * The subtract operator takes 2 sub-expressions which all have
         * single cardinality and numerical base-types. The result is a
         * single float or, if both sub-expressions are of integer type, a
         * single integer that corresponds to the first value minus the
         * second.
         * @param  options
         * @param  expr1
         * @param  expr2
         */
        , subtract : function (options, expr1, expr2)

        /**
         * The sum operator takes 1 or more sub-expressions which all
         * have single cardinality and have numerical base-types. The
         * result is a single float or, if all sub-expressions are of integer
         * type, a single integer that corresponds to the sum of the
         * numerical values of the sub-expressions.
         * @param  options
         */
        , sum : function (options)

#### Examples

##### Partial scoring on tuple

Let think about a formula one racing. Where the question could be :

    The following F1 drivers finished on the podium in the first ever Grand Prix of Bahrain 2005. Can you rearrange them into the correct finishing order?
    F1 drivers : DriverA, DriverB, DriverC

The correct response for this interaction is a tuple of string where the drivers are correctly ordered. *DriverC* arrived in first position, *DriverB* in second position and *DriverA* in third position. The following *tuple* variable called *RESPONSE* represents the right answer.

    {
        "identifier":"RESPONSE"
        , "value" : {
            "0":"DriverC"
            , "1":"DriverB"
            , "2":"DriverA"
        }
    }

But we want to give some points to the test takers who give a partial answer : *DriverC* arrived in first position, *DriverA* in second position and *DriverB* in third position. To do that we need to create our specific rule :

    if (match(null, getResponse("RESPONSE"), getCorrect("RESPONSE"))) {
        setOutcomeValue("SCORE", 1);
    }
    else if (match(null, getResponse("RESPONSE"), createVariable({"type":"tuple"}, "DriverC", "DriverA", "DriverB"))) {
        setOutcomeValue ("SCORE", 0.5);
    }
    else {
        setOutcomeValue("SCORE", 0);
    }

*See below the full example* :

    var myRule = 'if (match(null, getResponse("RESPONSE"), getCorrect("RESPONSE"))) { 
        setOutcomeValue("SCORE", 1); 
    }  
    else if (match(null, getResponse("RESPONSE"), createVariable({"type":"tuple"}, "DriverC", "DriverA", "DriverB"))) { 
        setOutcomeValue ("SCORE", 0.5); 
    }  
    else { 
        setOutcomeValue("SCORE", 0); 
    }';

    var correct = {
        "identifier":"RESPONSE"
        , "value" : {
            "0":"DriverC"
            , "1":"DriverB"
            , "2":"DriverA"
        }
    };

    matchingInit ({
        "data"    :   {
            "rule"          : myRule
            , "corrects"    : correct
            , "outcomes"    : [{"identifier":"SCORE", "type":"float"}]
        }
    });

    matchingSetResponses ([
        {"identifier":"RESPONSE", "value":{"0":"DriverC", "1":"DriverA", "2":"DriverB"}}
    ]);
    //{"0":"DriverC", "1":"DriverA", "2":"DriverB"} defined as the user's response

    matchingEvaluate ();

    var outcomes = matchingGetOutcomes ();
    // { "SCORE" : {"identifier":"SCORE", "value":0.5} }
    // 1 with the right answer {"0":"DriverC", "1":"DriverB", "2":"DriverA"}

