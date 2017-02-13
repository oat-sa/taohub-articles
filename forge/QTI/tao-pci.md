<!--
parent: QTI
created_at: '2014-08-14 17:40:54'
updated_at: '2016-11-17 15:55:57'
authors:
    - 'Somsack Sipasseuth'
tags:
    - QTI
-->



﻿h1. Portable Custom Interaction Best Practice Change Proposal: Changes and Recommendations Based on an Experimental Implementation

Authors:<br/>

Jérôme Bogaerts (Open Assessment Technologies, LU)<br/>

Somsack Sipasseuth (Open Assessment Technologies, LU)<br/>

Version: Public Draft\
Version Date: 10 October 2014\
Release: 1.0

Summary:
--------

This proposal changes and recommendations about IMS Portable Custom Interaction Best Practice is adapted from the original work from IMS and the Pacific Metrics. It proposes changes and recommendations on various aspects of the specification, based on a working prototype of Portable Custom Interaction into the TAO Computer Based Assessment Platform, developed by Open Assessment Technologies.<br/>

The goal of the proposal is to emphasize the software components and their APIs, which compose the cornerstones of the specification, in order to provide software developers guidance to author Portable Custom Interactions.<br/>

Finally, this proposal wants to leverage the AMD (Asynchronous Module Definition) paradigm by recommending to implement Portable Custom Interactions as AMD modules.

Introduction
------------

This proposal for IMS Portable Custom Interaction (PCI) Best Practice specification is based upon the original work of IMS and the proposal of Pacific Metrics.<br/>

To verify the technical feasibility of the basis documents, several prototypes were implemented at Open Assessment Technologies. During the prototyping phase, we identified key issues and developed guidance on how to make PCI more Delivery Engine and Item authors friendly : enabling it to be flexible enough to fit in as much delivery engines as possible in the market and widely adopted by Portable Custom Interaction authors as well.<br/>

Since version alpha 3.0.0, TAO has incorporated an experimental PCI specification support implementing the content of this proposal. The motivations that drive this proposal are the balance between development cost and end-user interests (portability, features, ease of authoring) - two essential components to any decision maker considering to adopt or implement the PCI specification. To achieve this goal, Open Assessment Technologies wants through this proposal attempt, leverage the AMD paradigm by recommending to implement Portable Custom Interactions as AMD modules, which will definitely encourage interaction developers to package and share their implementations in an appropriate way, fostering the adoption of the IMS Portable Custom Interaction (PCI) Best Practice specification.<br/>

The concept map below illustrates the numerous concepts and the process that helped to shape this proposal, to give readers an overview of all the things being considered while writing this proposal attempt.<br/>

![](http://forge.taotesting.com/attachments/download/3452/pciMindMap.png)

Example Implementation
----------------------

An interaction has been implemented to validate the experimental support of PCI in the TAO Platform. It is a simple “likert scale” interaction that will be used as an example to illustrate this proposal.<br/>

The screenshot below shows a QTI assessmentItem component with three instances of the “Likert Scale Portable Custom Interaction” instantiated with different configuration options.<br/>

Figure 2: A QTI assessmentItem containing 3 Portable Custom Interaction instances\
![](http://forge.taotesting.com/attachments/download/3449/sampleRendering.png)

Interaction Rendering
---------------------

### Clarification about Concepts

The initial IMS Portable Custom Interaction (PCI) specification introduces the notion of Communication Bridge. In the documentation however, it is difficult to concretely grasp what this bridge actually is and does. There indeed seems to be a confusion between the Rendering Engine and the Communication Bridge itself. From our understanding, the bridge should be the global qtiCustomInteractionContext object and the Rendering Engine is therefore something totally different, out of the scope of this document. In this proposal, Open Assessment Technologies considers the Rendering Engine as the hosting platform, and the Communication Bridge as the global qtiCustomInteractionContext. This improves the understandability of the specification, and reduces its learning curve. Finnaly, it makes tangible the initial Interaction Rendering Conceptual Diagram.<br/>

Figure 3: The initial Interaction Rendering Conceptual Diagram.<br/>

![](http://forge.taotesting.com/attachments/download/3450/renderingConcept.png)

Before going further, let’s first redefine in depth the role and responsibility of each component involved in interaction rendering process for a better understanding of this proposal.<br/>

1. The Custom Interaction Hook component brings all the code required to identify, render and execute a Custom Interaction instance. All required methods must be implemented. A custom interaction is first registered in the Communication Bridge as a Custom Interaction Hook. It represents the prototype of future Custom Interaction Instances. This hook is uniquely identified by its typeIdentifier. A Custom Interaction Hook is to be cloned to produce a Custom Interaction Instance each time it has to be rendered. It is useful to make the distinction between the Custom Interaction Hook (or prototype) from its instances because there may be more than one occurrence of such custom interaction within a single QTI assessmentItem. In this document, a Custom Interaction Hook refers to the prototype whilst Custom Interaction instances refer to its clone (which is intended to be initialized and executed at rendering time). The Custom Interaction Hook, is the former Custom Interaction in Figure 3.

2\. The Communication Bridge component, as known as the qtiCustomInteractionContext object, is the unique way for a given custom interaction and the Rendering Engine to communicate with each other. All required methods must be implemented. Since it is where the Custom Interaction Hooks get registered, it also serve as a registry for them.

3\. The Rendering Engine makes the Communication Bridge available in the JavaScript scope of every Custom Interaction Instance. The Rendering Engine provides an implementation of the Communication Bridge which in turn, uses the methods exposed by Custom Interaction Hooks to fulfill its duty. Vendors are free on the implementation of the Rendering Engine itself because with this approach, it is invisible to Custom Interaction Hooks. On the other hand, Custom Interaction Hooks will have access to the Communication Bridge by dependency injection.

### Interaction Rendering Sequence

The new sequence diagram below clearly depicts the responsibilities of each component. It also reflects the content of this proposal and the current experimental implementation in the TAO Platform.<br/>

Figure 4. Interaction Rendering Sequence Diagram\
![](http://forge.taotesting.com/attachments/download/3451/pciSequence.png)

The next three sections will go into the implementation details of the communication bridge, a sample PCI hook and the rendering engine.

Portable Custom Interaction APIs
--------------------------------

Open Assessment Technologies recommends to clearly define the APIs (Application Programming Interface), rather than describing existing implementations. This may cause misunderstandings about what is mandatory to be implemented or not to support Portable Custom Interactions. However, Open Assessment Technologies admits it was an excellent starting point. The following section might be a good lever between recommendation and standardization. Information about the implementation from Open Assessment Technologies is given later in this document.

### Communication Bridge API

As discussed in the previous sections of this proposal, the qtiCustomInteractionContext object is actually an instance of the Communication Bridge. The following skeleton describes the Communication Bridge API, which provide the methods available to Custom Interaction Hooks to communicate with the hosting platform.<br/>

As this proposal is built upon the AMD (Asynchronous Module Definition) paradigm, it is implemented as an AMD module, to be required as an AMD dependency by Custom Interaction Hook implementations.<br/>

Table 1. Communication Bridge Skeleton


     1:define([], function(){
     2:
     3:  /**
     4:   * The qtiCustomInteractionContext object to be injected in any
     5:   * Portable Custom Interaction Hook implementation.
     6:   *
     7:   * @type Object
     8:   */
     9:  var qtiCustomInteractionContext = {
    10:
    11:    /**
    12:     * - Communication Bridge API: register
    13:     *
    14:     * This method is called by Custom Interaction Hooks to register
    15:     * with the Rendering Engine for later cloning. This method is called
    16:     * by Custom Interaction Hooks during the loading of the JavaScript
    17:     * implementation.
    18:     *
    19:     * @param {Object} customInteractionHook A Custom Interaction Hook object.
    20:     */
    21:     register : function(customInteractionHook){
    22:       // register the Custom Interaction Hook for future
    23:       // instanciation/cloning...
    24:     },
    25:
    26:    /**
    27:     * - Communication Bridge API: notifyReady
    28:     *
    29:     * This method must be called by a Custom Interaction Hook Instance
    30:     * to inform it is ready to be used.
    31:     *
    32:     * @param {Object} customInteractionHookInstance A Custom Interaction
    33:     *                 Hook Instance.
    34:     */
    35:    notifyReady : function(customInteractionHookInstance){
    36:      // Do something in reaction to the "readyness" of the
    37:      // the custom interaction instance, for instance, notify the rendering engine...
    38:    },
    39:
    40:    /**
    41:     * - Communication Bridge API: notifyDone
    42:     *
    43:     * The notifyDone method is optionally called by a Custom Interaction
    44:     * Hook instance to notify its end. The method exists in the event a
    45:     * custom interaction has an indeterminate end.
    46:     *
    47:     * @param {Object} customInteractionHookInstance A Custom Interaction
    48:     *                 Hook Instance.
    49:     */
    50:    notifyDone : function(customInteractionHookInstance){
    51:      // So something in reaction to the end of the custom interaction
    52:      // instance, for instance, notify the rendering engine...
    53:    }
    54:  };
    55:
    56:  return qtiCustomInteractionContext;
    57:});

#### Revoking the Initialization Role

As shown in Figure 4, Open Assessment Technologies recommend redistributing the responsibility of initializing an interaction to the Rendering Engine. Indeed, the vendor certainly has an existing initialization function for built-in QTI interactions so it seems legitimate to let the delivery engine decide the right time to call the initialize() method on Custom Interaction Instances.<br/>

To redistribute the initialization responsibility to the Rendering Engine in the implementation from Open Assessment Technologies, the global object implements a getter function (which is not part of the Communication Bridge API) to retrieve previously registered Custom Interaction Hooks. The function createPciInstance() (which is also not part of the Communication Bridge API, but part of our own implementation) therefore returns the clone of a previously registered Custom Interaction Hook, to provide an up and running Custom Interaction Instance object.

#### Notification

The notifyReady() and notifyDone() functions now require their unique argument to be a Custom Interaction instance object, in place of an identifier. Giving the Custom Interaction Instance object instead of an identifier also makes qtiCustomInteractionContext implementation able to collect useful information from the Custom Interaction Instances. Finally, from a cosmetic perspective, it makes the API more elegant.<br/>

Simply put, the qtiCustomInteractionContext object should only serve as a registry to available PCI Hooks. Moreover, The functions exposed by the qtiCustomInteractionContext object might be useful to Rendering Engines wanting to implement QTI built-in interactions in a PCI way.

### Custom Interaction Hook API

The following section describes a Custom Interaction Hook skeleton. It clearly depicts what are the methods to be implemented by a Portable Custom interaction author to be compliant with the specification. In other words, it exposes the Custom Interaction Hook API. The changes described in this proposal focus on three aspects:

1\. Make Custom Interaction Hooks pure AMD modules.

2\. Provide the qtiCustomInteractionContext (the Communication Bridge) object to Custom Interaction Hooks as an AMD dependency to avoid any collision at runtime.

3\. Inject the shared libraries (c.f. Pacific Metric proposal) needed by the Custom Interaction Hook implementations as AMD dependencies.

4\. Modify slightly the existing API, giving more control to integrated platforms hosting Portable Custom Interaction Instances, especially from an authoring perspective.

Point 1. , 2. and 3. make the Portable Custom Interaction specification entirely based on AMD modules, from Custom Interaction Hook implementations to shared libraries. On the other hand, point 4. makes the Custom Interaction Hook API more fine-grained. In this way, the client code of Custom Interaction Hooks and Instances are in control to manage the interaction lifecycle.<br/>

The following source code is a Custom Interaction Hook skeleton. It acts as a strong basis for any new Custom Interaction Hook implementation but describes the proposed Custom Interaction Hook API as well.


    Table 2. Custom Interaction Hook Skeleton
      1:/**
      2:* A Custom Interaction Hook implemented as an AMD Module.
      3:*
      4:* The qtiCustomInteractionContext object, along with the shared libraries
      5:* referenced in the XML definition of the item (c.f. Pacific Metrics proposal),
      6:* are injected into the Custom Interaction Hook implementation as AMD
      7:* dependencies.
      8:*
      9:* To make the magic happen, the AMD dependencies related to shared libraries
     10:* use the same names than the  elements found in the XML definition
     11:* of the item.
     12:*/
     13:define(['qtiCustomInteractionContext',
     14:        'IMSGlobal/jquery_2_1_1',
     15:        'IMSGlobal/sprintf_1_0_0'],
     16:        function(
     17:        qtiCustomInteractionContext,
     18:        $,
     19:        sprintf){
     20:
     21:   var myCustomInteractionHook = {
     22:
     23:     /**
     24:      * - Custom Interaction Hook API: id
     25:      * The unique identifier provided at instanciation time, identifying the
     26:      * Custom Interaction Hook Instance at runtime.
     27:      */
     28:     id : -1,
     29:
     30:     /**
     31:      * Custom Interaction Hook API: getTypeIdentifier
     32:      *
     33:      * @returns {String} The unique identifier of the Custom Interaction Hook
     34:      */
     35:     getTypeIdentifier : function(){
     36:       return 'myCustomInteractionTypeId';
     37:     },
     38:
     39:     /**
     40:      * - Custom Interaction Hook API: initialize
     41:      *
     42:      * This method initializes the Custom Interaction Hook Instance.
     43:      * The Id parameter is the custom is a system generated id.
     44:      * The XMLNode parameter is the custom interaction root XML node
     45:      * displayed by the rendering engine. The config parameter may be
     46:      * undefined or a JSON object representing the configuration.
     47:      *
     48:      * @param {String} id
     49:      * @param {Node} dom
     50:      * @param {Object} config
     51:      */
     52:     initialize : function(id, dom, config){
     53:       this.id = id;
     54:       this.dom = dom;
     55:       this.config = config || {};
     56:
     57:       // Do something with dom, config...
     58:     },
     59:
     60:     /**
     61:      * - Custom Interaction Hook API: setResponse
     62:      *
     63:      * This method can be called multiple times, once, or not at all. The
     64:      * given response data must be compliant with the baseType and cardinality
     65:      * of the response declaration referenced by the
     66:      * qti:customInteraction->responseIdentifier attribute.
     67:      *
     68:      * @param {Object} response A response object in the PCI JSON format.
     69:      */
     70:     setResponse : function(response){
     71:         // Do something with response...
     72:     },
     73:
     74:     /**
     75:      * - Custom Interaction Hook API: getResponse
     76:      *
     77:      * This method can be called multiple times, once, or not at all.
     78:      * The response data must correspond with the baseType and cardinality
     79:      * of the respponse declaration referenced by the
     80:      * qti:customInteraction->responseIdentifier attribute.
     81:      *
     82:      * @returns {Object} A response object in the PCI JSON format.
     83:      */
     84:     getResponse : function(){
     85:         // return something PCI JSON format compliant...
     86:     },
     87:
     88:     /**
     89:      * - Custom Interaction Hook API: resetResponse
     90:      *
     91:      * This method can be called multiple times, once, or not at all.
     92:      * The reason of this new method in the API is that a rendering engine
     93:      * would like to provide a "reset responses" feature to the candidate.
     94:      */
     95:     resetResponse : function(){
     96:         // Reset the response and reflect the change on the internal state
     97:         // and/or DOM...
     98:     },
     99:
    100:     /**
    101:      * - Custom Interaction Hook API: destroy
    102:      *
    103:      * The destroy method is called when the rendering engine decides
    104:      * the interaction must disappear. This is the last chance for the
    105:      * Custom Interaction Hook instance to clean up anything that might
    106:      * "pollute" the rendering environment in the future.
    107:      *
    108:      * Open Assessment Technologies do not recommend to ask the implementor
    109:      * to clean the DOM in this method for performance reason. Indeed,
    110:      * destroying each item related DOM one by one requests a lot of
    111:      * redrawings to the browsers. We therefore recommend to delegate this
    112:      * to the rendering engine itself, on an item basis.
    113:      *
    114:      * Because event listeners will be destroyed automatically when the
    115:      * interaction disappears from the DOM, we do not expect a lot of code
    116:      * for this method in implementations.
    117:      */
    118:     destroy : function(){
    119:       // Do some clean-up...
    120:     },
    121:
    122:     /**
    123:      * - Custom Interaction Hook API: setSerializedState
    124:      *
    125:      * This method can be called to set the serialized state of the item.
    126:      * The state must be formatted as JSON data and may represent any
    127:      * information required to give the opportunity to the interaction
    128:      * to restore its internal state and/or its DOM representation.
    129:      *
    130:      * @param {Object} A JSON data object.
    131:      */
    132:     setSerializedState : function(state){
    133:       // Store the state and eventually, update the internal state
    134:       // of the interaction or its DOM...
    135:     },
    136:
    137:     /**
    138:      * - Custom Interaction Hook API: getSerializedState
    139:      *
    140:      * This method can be called to save the serialized state of the item.
    141:      *
    142:      * The state must be formatted as JSON data and may represent any
    143:      * information required to resume the interaction later on.
    144:      *
    145:      * @returns {Object} A JSON data object.
    146:      */
    147:     getSerializedState : function(){
    148:       // Return an object representing the internal state of the
    149:       // interaction.
    150:     },
    151:
    152:     /**
    153:      * - Custom Interaction Hook API: resetSerializedState
    154:      *
    155:      * This method can be called multiple times, once, or not at all.
    156:      *
    157:      * The reason of this new method in the API is that a rendering engine
    158:      * would like to provide, for instance,  a "restart simulation"
    159:      * feature to the candidate.
    160:      */
    161:     resetSerializedState: function(){
    162:       // Reset the state of the custom interaction in an appropriate
    163:       // way...
    164:     }
    165:
    166:     /**
    167:      * Custom Interaction Hook implementors are of course free to add
    168:      * their own methods to organize their interactions, or meet the requirements
    169:      * of a particular platform extending the PCI standard for specific
    170:      * projects or purpose.
    171:      */
    172:  };
    173:
    174:  // The Custom Interaction Hook registers to the qtiCustomInteractionContext
    175:  // object. The owner of the qtiCustomInteractionContext object is now able
    176:  // to clone it into Custom Interaction Hook Instances at will.
    177:  qtiCustomInteractionContext.register(myCustomInteractionHook);
    178:
    179:});

For the sake of code clarity, Open Assessment Technologies proposes splitting the initialization process in three distinct steps: initialization, state management and response management. The three of them fundamentally are different operations so should be separated. It also provides more control to client code to manipulate Custom Interaction Hook Instances. A good example of such a client-code would be an authoring tool.<br/>

Another advantage of this is to allow the Rendering Engine to dynamically change the state or the response without being required to destroy and reinitialize the whole interaction (while previewing and authoring interactions for instance). This would be particularly useful to complex Custom Interaction Hook implementations where the actual initialization process is a heavy operation.<br/>

We therefore recommend having the following methods and attributes in the Communication Bridge API, making a rendering engine able to manage the lifecycle of Custom Interaction Hook Instances:

-   initialize(id, dom, config)
-   Represents the initialization phase of an interaction. At this moment, a unique id is given to the Custom Interaction Hook Instance, along with the dom node for its own rendering and a config object reflecting the configuration options of the interaction.
-   setSerializedState(state)
-   getSerializedState()
-   resetSerializedState()
-   Represents the state management of an interaction. This give the opportunity to Rendering Engine to retrieve and/or control the state of the interactions if needed, in order to deal with the interaction lifecycle.
-   setResponse(response)
-   getResponse()
-   resetResponse()
-   Represents the response management of an interaction. As for the state management, these methods enables the Rendering Engine to retrieve and/or control the response of interactions if needed.
-   destroy()

Implementers will do all necessary clean-up to performed when the Rendering Engine decides to destruct an initialized Custom Interaction Hook Instance.

id\
Implementers of Custom Interaction Hooks will make the id attribute public to make the Rendering Engine able to identify Custom Interaction Hook Instance.<br/>

The modifications in this section provide a nice and clean programmatic interface to implement the Communication Bridge and:<br/>

 1. Allow the Rendering Engine providing the necessary communication channels to Custom Interaction Hooks.<br/>

 2. Enable Custom Interaction Hooks to register to the Rendering Engine but also notify it for some through the notifyDone() and notifyReady() methods.

Item XML Definition
-------------------

We agree with the proposal from Pacific Metrics in general. We adapted our sample implementation of likert scale interaction based on theirs. We insist on adding clear XML namespaces to keep the XML clear and clean.<br/>

What about the entry point? Because a QTI assessmentItem might contain multiple custom interactions, the entry-point/hook to be used by a custom interaction should be described. pci:portableCustomInteraction-<br/>
>entryPoint ?<br/>

What about local shared libraries definition? Allowing both absolute and relative URL would make the trick.<br/>

What about custom-interaction-specific CSS : a PCI provider might want to propose a default CSS to render its PCI out of the item context, which is different from the item stylesheet which is aimed at defining the style of the whole item (including or not the style of the its interactions)

Table 4. Item XML Definition












          This is a sample PCI.










                0
                5
                Not at all
                Very much
                Do you like movies










          Here is another one.











              0
              7
              Can't stand it :(
              Absolutely ! :)
              Do you like video games ?










        Here is yet another one.










            0
            Do you like reading ?
            9
            Hate it
            Love it
















### PCI Configuration - Properties

We agree with Pacific Metrics about the need for more a structured way to store configuration parameter in the XML and have implemented as such. All the values in the <entry> will be passed to the PCI initialize function as strings. It will be up to the PCI implementer to check their validity or re-interpret the value if necessary.<br/>

Table 5. XML PCI Properties



      0
      5
      Not at all
      Very much



Call of eval() indeed should be avoided to prevent bad JavaScript inclusion. This also enables validation of configuration parameters if necessary.<br/>

On top of that, authoring tool implementers need a structured way to store interaction configuration parameters to make it “authorable”.

### PCI Markup

In the original recommendation, there is no mention of the XML namespace used by HTML markups in PCI. In the example of the original recommendation:

Table 6. PCI Original Markup Recommendation





It looks more like a W3C XHTML or HTML5 than the XHTML subset described in the QTI 2.1 specification: the style attribute is indeed forbidden in QTI, preventing any XSD validator to successfully validate the file.<br/>

The question that naturally raises is which HTML namespace(s) does PCI actually support? This section will try to answer that question by comparing the XHTML subset of QTI, XHTML and XHTML 5 or any exotic markup flavour.<br/>

We consider (by experience) that validating the content of <pci:markup> would be difficult, and force the markup to be in a particular flavour too much restrictive. The only thing we can provide are recommendations.<br/>

However, In the Open Assessment Technologies implementations of Portable Custom Interactions, we chose and recommend the XHTML5 solution.

#### XHTML Subset from QTI

Using QTI-XHTML (as defined in QTI 2.1) may be a first and simple answer because QTI 2.1 already defines a clear subset of XHTML. This also means that PCI developers need to be careful about their markup usage. The advantage is that all HTML markups will share the same namespace (the one of QTI) which would help preventing confusions. On the other hand, the XHTML subset of QTI seems too small to accommodate for all the possibilities that current web technologies offer.<br/>

Using the XHTML subset of QTI as a markup language for Portable Custom Interactions.

Table 7. XHTML Subset of QTI as a Markup Language for Portable Custom Interactions












#### XHTML and XHTML 5

Since the role of PCI recommendation is to propose a way to create item that extends far beyond anything available currently in the QTI standard, it appears that HTML 5 is a good candidate. HTML5 is the growing leading web standard and likely the dominant one in the future. Moreover, its XML serialization format, XHTML 5, enables PCI implementers to take advantage of current technologies. HTML5 indeed standardizes new elements like <video>, <audio>, <canvas> to allow more possibilities in term of item creation. However, XHTML is still perfectly a valid solution but less rich than XHTML5.<br/>

It would also means that an XSD needs to be written if we want to it be possibly validated, which is going to be very difficult. A solution to this validation issue may simply not to validate the content of <pci:markup>.<br/>

This means placing the responsibility of html markup definition and validation on each individual PCI implementer.

Table 9. XHTML 5 with Namespace as Markup Language








Libraries Inclusion and AMD
---------------------------

The libraries embedded in a custom interaction must be fully AMD compliant and must not write anything in the global scope.

JSON Representation
-------------------

### JSON Schema Revision

The original JSON Schema (shipped with the previous version of “IMS Portable Custom Interaction Best Practice”), aiming at validating the response returned by custom interactions, unfortunately does not work as expected with JSON Schema Lint.<br/>

Moreover, it does not enable production of embedded NULL values as parts of the response payload. Beyond the use of the QTI Base Types and Multiple, Ordered and Record containers in the context of Portable Custom Interactions, the JSON representation of values suits very well the needs of built-in QTI interactions and efficient data transmission between client and server sides. Because of this but also the existence of the QTI customOperator, we consider important to make possible the use of scalar NULL values and hybrid containers such as [1, 2, NULL, 3] or [“A” =<br/>
> 1, “B” =<br/>
> NULL, “C” =<br/>
> 2].<br/>

By rewriting the JSON format using JSON Schema Draft 4, the following changes can be applied:<br/>

 1. The ‘Point’ base type is modified to contain only two values, instead of 2 or 3 in the previous version. Indeed, the QTI 2.1 specification says about the Point base type that “A point value represents an integer tuple corresponding to a graphic point. The two integers correspond to the horizontal (x-axis) and vertical (y-axis) positions respectively. The up/down and left/right senses of the axes are context dependent”.<br/>

 2. Pair and DirectedPair values must now be composed of Identifier values instead of plain strings.<br/>

 3. The author attribute is removed because it is not a JSON Schema concept. Authors are now referenced in the content of the description attribute.<br/>

 4. Use of JSON Schema’s additionalProperties attribute to prevent the use of other keys than base, list and record but also prevent the use of nonexistent base types.<br/>

 5. Character escaping in duration’s regular expression.<br/>

 6. Make possible the use of NULL for base types, list items, and record values.<br/>

The JSON Schema Proposal implementing the above changes is available in Appendix A – JSON Schema. This proposal aims at being backward compatible with existing JSON Response Data.

JSON Representation Examples Revision
-------------------------------------

Because it is now possible to express the NULL value within this proposal, the JSON examples in the Appendix A of the original version of IMS Portable Custom Interaction Best Practice should be updated.

### QTI Base Types to JSON Representation

Table A.1. QTI Base Types to JSON Representation\
QTI Base Type\
 JSON Representation\
 NULL\
 { [base]() null }<br/>

 Boolean\
 { [base]() { [boolean]() true } }<br/>

 Integer\
 { [base]() { [integer]() 123 } }<br/>

 Float\
 { [base]() { [float]() 23.23 } }<br/>

 String\
 { [base]() { [string]() “string” } }<br/>

 Point\
 { [base]() { [point]() [10, 20] } }<br/>

 Pair\
 { [base]() { [pair]() [“A”, “B”] } }<br/>

 Directed Pair\
 { [base]() { [directedPair]() [“a”, “b”] } }<br/>

 Duration\
 { [base]() { [duration]() “P10Y3M20DT4H30M25S” } }<br/>

 File\
 { [base]() { [file]() { [data]() “cGxlYXN1cmUu”, [mime]()<br/>

 “text/plain”, [name]() “hello­world.txt” } } }<br/>

 URI\
 { [base]() { [uri]() “http://www.imsglobal.org” } }<br/>

 IntOrIdentifier\
 { [base]() { [intOrIdentifier]() “_identifier” } }<br/>

 Identifier\
 { [base]() { [identifier]() “_identifier” } }

The modifications applied on table A.1 are the following:<br/>

 1. Added an example of NULL value.<br/>

 2. The File base type example now emphases the existence of the name attribute.<br/>

 3. The sample Duration changes to match the regular expression of the original JSON schema (ISO 8601 durations).

### QTI Multiple/Ordered Cardinality to JSON Representation

Table A.2 QTI Multiple/Ordered Cardinality to JSON Representation\
QTI Base Type\
 JSON Representation\
 Boolean\
 {[list]() { [boolean]() [true, false,true, true]}}<br/>

 Integer\
 { [list]() { [integer]() [2, 3, 5, 7, 11, 13] } }<br/>

 Float\
 { [list]() { [float]() [3.1415926, 12.34, 98.76] } }<br/>

 String\
 { [list]() { [string]() [“Another”, “And Another”] } }<br/>

 Point\
 { [list]() { [point]() [[123, 456], [640, 480]] } }<br/>

 Pair\
 { [list]() { [pair]() [[“A”, “B”], [“D”, “C”]] } }<br/>

 Directed Pair\
 { [list]() { [directedPair]() [[“A”, “B”], [“C”, “D”]] } }<br/>

 Duration\
 { [list]() { [duration]() [“P10Y3M20DT4H30M25S”] } }<br/>

 File\
 { [list]() { [file]() [{[data]() “cGx1YXN1cmUu”, [mime]() “text/plain” }] } }<br/>

 URI\
 { [list]() { [uri]() [“http://www.imsglobal.org”, “http://www.w3.org”] } }<br/>

 IntOrIdentifier\
 { [list]() { [intOrIdentifier]() [2, “_id”] } }<br/>

 Identifier\
 { [list]() { [identifier]() [“_id1”, “id2”, “ID3”] } }

The modifications applied on table A.2 is that the Duration example is modified to match the regular expression of the JSON Schema.

### QTI Record Cardinality to JSON Representation

Table A.3. QTI Record Cardinality to JSON Representation\
QTI Base Type\
 JSON Representation\
 Record\
 {<br/>

 [record]() [<br/>

 {<br/>

 [name]() “rock”,<br/>

 [base]() {<br/>

 [boolean]() true\
 }<br/>

 },<br/>

 {<br/>

 [name]() “paper”,<br/>

 [list]() {<br/>

 [string]() [“p”,“a”,“p”,“e”,“r”]<br/>

 }<br/>

 },<br/>

 {<br/>

 [name]() “scissors”,<br/>

 [list]() {<br/>

 [integer]() [1, 2, 3, 4]<br/>

 }<br/>

 },<br/>

 {<br/>

 [name]() “empty”<br/>

 [base]() null\
 }<br/>

 ]<br/>

}

The only modification done is that The record entry named “empty” now a NULL “base” instead of being omitted.

Appendix A - JSON Schema
------------------------

Table A.4. JSON Schema Revision


    {
        "id": "#",
        "$schema": "http://json-schema.org/draft-04/schema#",
        "description": "Portable Custom Interaction Base Types JSON Representation Schema by Michael Aumock (maumock@pacificmetrics.com), Jérôme Bogaerts (jerome@taotesting.com), Somsack Sipasseuth (sam@taotesting.com).",
        "type": "object",

        "definitions": {
            "base": {
                "type": [
                    "object",
                    "null"
                ],
                "properties": {
                    "boolean": { "$ref": "#/definitions/boolean" },
                    "integer": { "$ref": "#/definitions/integer" },
                    "float": { "$ref": "#/definitions/float" },
                    "string": { "$ref": "#/definitions/string" },
                    "uri": { "$ref": "#/definitions/uri" },
                    "identifier": { "$ref": "#/definitions/identifier"},
                    "point": { "$ref": "#/definitions/point" },
                    "pair": { "$ref": "#/definitions/pair"},
                    "directedPair": { "$ref": "#/definitions/pair" },
                    "duration": { "$ref": "#/definitions/duration" },
                    "file": { "$ref": "#/definitions/file" },
                    "intOrIdentifier": {
                        "oneOf": [
                            { "$ref": "#/definitions/integer" },
                            { "$ref": "#/definitions/identifier" }
                        ]
                    }
                },
                "additionalProperties": false
            },

            "list": {
                "type": "object",
                "properties": {
                    "boolean": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/boolean" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "integer": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/integer" },
                                { "type": "null" }
                            ]
                        }

                    },
                    "float": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/float" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "string": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/string" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "uri": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/uri" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "identifier": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/identifier" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "point": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/point" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "pair": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/pair" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "directedPair": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/pair" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "duration": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/duration" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "file": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/file" },
                                { "type": "null" }
                            ]
                        }
                    },
                    "intOrIdentifier": {
                        "type": "array",
                        "items": {
                            "oneOf": [
                                { "$ref": "#/definitions/integer" },
                                { "$ref": "#/definitions/identifier" },
                                { "type": "null" }
                            ]
                        }
                    }
                },
                "additionalProperties": false
            },

            "record": {
                "type": "array",
                "items": { "$ref": "#/definitions/recordRow" }
            },

            "recordRow": {
                "type": "object",
                "properties": {
                    "name": {
                        "type": "string"
                    },
                    "base": { "$ref": "#/definitions/base" },
                    "list": { "$ref": "#/definitions/list" }
                },
                "required": [
                    "name"
                ],
                "additionalProperties": false
            },

            "boolean": {
                "type": "boolean"
            },
            "integer": {
                "type": "integer",
                "maximum": 2147483647,
                "minimum": -2147483647
            },
            "float": {
                "type": "number"
            },
            "string": {
                "type": "string"
            },
            "uri": {
                "type": "string",
                "format": "uri"
            },
            "identifier": {
                "type": "string",
                "pattern": "^[_a-zA-Z][\\w-\\.#\\[\\]]*$"
            },
            "point": {
                "type": "array",
                "maxItems": 2,
                "minItems": 2,
                "items": { "$ref": "#/definitions/integer" }
            },
            "pair": {
                "type": "array",
                "maxItems": 2,
                "minItems": 2,
                "items": { "$ref": "#/definitions/identifier" }
            },
            "duration": {
                "type": "string",
                "pattern": "^P([\\d]+([,\\.][\\d]+)?Y)?([\\d]+([,\\.][\\d]+)?M)?([\\d]+([,\\.][\\d]+)?W)?([\\d]+([,\\.][\\d]+)?D)?(T([\\d]+([,\\.][\\d]+)?H)?([\\d]+([,\\.][\\d]+)?M)?([\\d]+([,\\.][\\d]+)?S)?)?$"
            },
            "file": {
                "properties": {
                    "data": { "$ref": "#/definitions/base64" },
                    "mime": { "$ref": "#/definitions/mime" },
                    "name": { "$ref": "#/definitions/string" }
                },
                "required": [
                    "data",
                    "mime"
                ],
                "additionalProperties": false
            },
            "base64": {
                "type": "string",
                "pattern": "^[a-zA-Z0-9\\+/]+(?:[=]{0,2})$"
            },
            "mime": {
                "type": "string",
                "pattern": "^[a-zA-Z-]+/[-\\w\\+\\.]+$"
            }
        },

        "properties": {
            "base": { "$ref": "#/definitions/base" },
            "list": { "$ref": "#/definitions/list" },
            "record": { "$ref": "#/definitions/record" }
        },
        "additionalProperties": false
    }


