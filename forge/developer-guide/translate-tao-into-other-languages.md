<!--
author:
    - 'Cyril Hazotte'
created_at: '2010-12-02 16:13:49'
updated_at: '2013-10-11 16:59:23'
tags:
    - 'Developer Guide'
-->

Translate TAO into other languages
==================================



How TAO internalization works
-----------------------------

The TAO platform rely on two different languages configuration that can be configured separately in User Settings. Those two different languages configuration address different type of content that may translated in TAO. So, a user can decide to change either its Interface Language or its Data Language:

-   The Interface Language configuration handle all messages that came from the platform features.
-   The Data Language concerns business related data and meta-data.

Here is an example both UI Language and Data Language are in English.<br/>

![](../resources//attachments/download/2593/S%C3%A9lection_053.png)

Here UI Language have been switched to French\
![](../resources//attachments/download/2592/S%C3%A9lection_054.png)

Here both UI and Data Language are in French\
![](../resources//attachments/download/2600/S%C3%A9lection_055.png)

Here only Data Language is in French\
![](../resources//attachments/download/2599/S%C3%A9lection_051.png)

### User Interface

All the message sent to the user are gather in `messages.po` using *Gettext* translation files. To summarize, the *PO* files are text files that contains couple of lines with the string identifier in English and a line for the string to be translated. We use the English texts as identifiers, it’s the reason why it’s the identifier for the translations. So the English is the base for the translation.

By opening a base file, you can see:

    msgid  "Welcome to TAO"
    msgstr ""

To translate the string `"Welcome to TAO"` to French (for example), you have to write the translation between the quotes of the `msgstr`:

    msgid  "Welcome to TAO"
    msgstr "Bienvenue dans TAO"

This is it!

\> **Be careful**:<br/>

\>\* If you let a *msgstr* empty, the English identifier will be displayed.<br/>

\>\* Never change the identifier, neither a space, a dot or a letter. If it’s the case, the translated string will not be displayed.<br/>

\>\* It’s possible that some strings are not in the software anymore. The translations files are cleaned only once by release.<br/>

\>\* Save your files using UTF-8 encoding.

### Data

Data are stored in the knowledge base and could be translate for content created by the user tranks to the translate button feature that create an alternate value in a different language, that why in that previous example “Elections in the United States” have been translated into “Elections américaines”.

For build-in content, those translation are store in the knowledge base during the installation. We use RDF file to store in each extensions folder all content that require translation. For instance the following example is extracted from taoItems/locales/fr-FR/taoItem.rdf and deals with the property Item Content Label and Comment that in previous example had been translated into “Contenu de l’item” in French.


      
        
        Contenu de l'item
        
        Contenu de l'item
      

All RDF files in any locales folder of any TAO extension respect this format and may be translated.

The translation process
-----------------------

You can contribute to the translation effort of TAO in the dedicated platform http://translate.taotesting.com . We choose to use the open source toolkit [Pootle](http://translate.sourceforge.net/wiki/). Pootle user howto is available [here](http://translate.sourceforge.net/wiki/users/howto) .

![](../resources//attachments/download/2596/S%C3%A9lection_057.png):http://translate.taotesting.com/

You can then help us provide translation in

1.  German
2.  Spanish
3.  English
4.  French
5.  Dutch
6.  Luxembourgish
7.  Swedish
8.  Finish
9.  Italian
10. Polish
11. Portuguese
12. Danish
13. Hungarian

Just choose your language and then you can suggest translation. We strongly recommend you to register to Pootle in order to gain access to more advanced feature.

When a translation in new language is good enough, we also start the translation of data into this language as explain before but for now we have not any collaborative tools to handle RDF translation. So, you may simply edit with a text editor rdf file and send us back, we will review them and integrate them into TAO.

There is a also [dedicated section](http://forge.taotesting.com/projects/tao/boards/3) of the forum to speak about translation, if you have any questions or feedback or if you want to take the lead on a new language translation. Do not hesitate to contact us. You may also contact us to start a translation in a new language. We will then generate the new translation file and make them available in Pootle.

Going further
-------------

If you want to understand how the translations are implemented into the TAO Framework you can have a look at the section dedicated to the [[Internationalization]].

See also:

-   [the Gettext manual](http://www.gnu.org/software/gettext/manual/gettext.html)
-   [the PO file format](http://www.gnu.org/software/gettext/manual/gettext.html#PO-Files)


