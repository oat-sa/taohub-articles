<!--
created_at: '2013-01-31 10:59:26'
updated_at: '2013-01-31 10:59:26'
authors:
    - 'Joel Bout'
tags: {  }
-->

TaoConnector
============

TaoConnector is a PHP library which can be used by an external project to communicate with tao. Tao does not require to be installed on the same server for this to work. It has been developed to work with Tao 2.4

Basic usage
-----------

This should cover most use cases and consists of the following classes

### taoUserService

used to:

-   authenticate the user and establish a session for further calls
-   get basic informations about the connected user (‘id’, ‘login’(optional), ‘first_name’(optional), ‘last_name’(optional), ‘email’(optional), ‘lang’, ‘roles’)
-   change user preferences (password, preferred language)

functions:

-   available without authentication:
    -   **startSession**(login, password) returns an array of informations about the user if successful.
        (sessions started this way store the user-URI and token in the php session)



-   require authentication:
    -   **getInfo**() info of the current user, including the roles
    -   **getRoles**() the roles of the current user
    -   **setLanguage**(languageCode) 2 letter uppercase code (‘EN’, ‘FR’, …)
    -   **changePassword**(oldPassword, newPassword)

### taoAdminService

taoAdminService extends taoUserService by functionalities that might not be available to every user

-   require authentication:
    -   **getUserInfo**(userUri) returns informations about a user, including his roles
    -   **getAllUsers**()
    -   **getAllRoles**()
    -   **getUserRoles**(userUri) returns a list of the roles of a specific user
    -   **getRoleUsers**(roleUri) returns a list of the users that have the specified role

### taoSessionRequiredException

taoSessionRequiredException is thrown whenever a functions is accessed that requires authentication without\
providing a valid login first.

Advanced usage
--------------

The following functions are used internally and are prone to change. These are NOT required when using **startSession** provided by taoUserService.

If the project needs to manage the token manually it can use the function in order to restore an earlier session.

**** **initRestSession**(taoUrl, userUri, token, skipVerify = false) connects the library using a token after validating the token.<br/>

(sessions restored via initRestSession do not store the token in the session)

If the library needs to connect to multiple instances of tao at once, taoConnection can be used. However the developer needs to keep track of the instances of taoConnection himself.

-   In order to create a new connection:
    -   **taoConnection::spawnAnonymous()**
    -   followed by **authenticate(login, password)**
-   Restoring an authenticated session:
    -   **taoConnection::restore(serverUrl, userUri, userToken)**


