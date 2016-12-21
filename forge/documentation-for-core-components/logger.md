<!--
parent:
    title: Documentation_for_core_components
author:
    - 'Joel Bout'
created_at: '2011-12-09 18:22:35'
updated_at: '2015-10-28 13:27:52'
tags:
    - 'Documentation for core components'
-->

Logger
======

Valid as of [[TAO\_3\_0|TAO 3.0]]. For previous versions see [[Logger\_2\_2|Logger 2.2]]

{{\>toc}}

Objectives
----------

The purpose of this logger is to improve the code by documenting errors or irregularities that might have been missed otherwise,\
and by assisting developers in solving problems through offering insight into the events that led\
to these errors.

Usage
-----

The common\_Logger class offers a static interface for a log implementation. To spawn a log event you can call the static functions:

    common_Logger::t('LOG MESSAGE', array(TAG1, TAG2));

The function name corresponds to the first letter of the severity letter, which are from the least important to the most important:

-   TRACE (0)
-   DEBUG (1)
-   INFO (2)
-   WARNING (3)
-   ERROR (4)
-   FATAL (5)

The first parameter consists of the error message to be logged, it should never be seen by the end-user and therefore is untranslated.

The second parameter consists of a string or an array of string, that allows us to tag log entries. Example tags are: INSTALL, CLEARFW, GENERIS, TAOITEMS, QTI

Configuration
-------------

It is configured in the log config **/config/generis/log.conf.php** (which will be created during install)

The decision which events should be logged will be taken by using either:

-   **threshold**: indicates the minimum severity an event has to have in order to be logged using this appender
-   **mask**: defines a bit mask, allowing a fine grained control over which events are logged, with the least significant\
    bit(2\^0) corresponding to to the TRACE severity, and the most significant bit(2\^5) corresponding to to the FATAL severity.\
    *Example*: To log everything except TRACE and WARNING, one would use 110110 = 32+16+4+2 = 54
-   **tag**: an array of tags of which ONE tag must be used in the logitem

###SingleFileAppender{#singlefileappender}

‘file’ =\> the absolute path to the logfile\
‘format’ =\> the format of the log entry\
‘max\_file\_size’ =\> maximum size a single log file can reach

upon reaching max\_file\_size, the first half of the log file will be deleted. Default is 1 MB, an entry of 0 disables this feature.

####ArchiveFileAppender{#archivefileappender}

‘file’ =\> the absolute path to the logfile\
‘format’ =\> the format of the log entry\
‘max\_file\_size’ =\> maximum size a single logfile can reach\
‘directory’ =\> directory to which logfiles will be archived to, once they reached max\_file\_size\
‘compression’ =\> the compression algorithm to use for archived files, defaults to ‘zip’ only alternativ at the moment is ‘none’

upon reaching max\_file\_size, the log file will be appended the current date and moved to the directory indicated by\
the configuration parameter ‘directory’ if present or the same directory as the logfile if absent. If this file already exists\
a serial number will be appended to the filename.

###XMLAppender{#xmlappender}

‘file’ =\> the absolute path to the logfile

this fileappender has no limit to it’s size and should not yet be used in production

###UDPAppender{#udpappender}

Warning: *enabling this appender on windows will require uncommenting ’extension=php\_sockets.dll’ in the php.ini*

‘host’ =\> destination host\
‘port’ =\> destination port

the item is JSON formated and send via udp.

Formats
-------

###FileAppenders{#fileappenders}

The Fileappenders (SingelFileAppender, ArchiveFileAppender) append a String to the logfile that can contain the following informations:

-   %d datestring
-   %m description(message)
-   %s severity
-   %r request
-   %f file from which the log was called
-   %l line from which the log was called
-   %t timestamp
-   %u user
-   (%b backtrace)

The default format is: %d [%s] \\‘%m\\’ %f %l\
resulting in: DATE [SEVERITY] MESSAGE ERRORFILE ERRORLINE

###XMLAppender{#xmlappender}

The XMLAppender inserts an xml item into the structure that has the following format:


      
        
          
          
          
          
          
          
        
      

###UDPAppender{#udpappender}

sends an json encoded String of the following array structure:

    array(
        's' => SEVERITY (type int),
        'd' => DESCRIPTION (type string),
        't' => TAGS (type array),
        'f' => FILE (type string),
        'l' => LINE (type int),
        'b' => BACKTRACE (type array)
    )

the logitem will be packed into a json string, and send via UDP

