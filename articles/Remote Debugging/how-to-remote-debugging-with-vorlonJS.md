<!--
   tags:
       Debugging:
           - "Remote debugging with VorlonJS"
-->
# Remote debugging with VorlonJS

> This article explains how to remotely debugging and testing your JavaScript using `vorlon.js`. While working with a Mac and an iPad might be straight forward, achievieving the same thing with a PC is more complicate. Here is one possible approach.

## Vorlon.js
Vorlon.js is a tool built using all open source tech to allow remotely load, inspect, test and debug JavaScript code, running on any device with a web browser.<br/>
It is a small web server you can run from your local machine or on a server, that serves a dashboard, which is the interface to communicate with remote devices.<br/>

With the dashboard you can debug and test remote JavaScript applications, basically like you hit F12 in your browser.<br/>
Some of the default plugins are:<br/>
 - the Interactive Console that will stream messages from the client;
 - the DOM Explorer to help you inspect the DOM and modify its properties and the CSS;
 - the Modernizr that shows the supported browser features;
 - the XHR panel to help you analyze the calls sent by your device.
 - the My Device panel that displays you information coming from the client such as the user agent, the size of the screen, the pixel per points, etc.

## How to get started

### Install Vorlon

Install VorlonJS server from npm (you can install it globally or locally)
```bash
npm i -g vorlon
```

### Start Vorlon server (local machine or server)
```bash
$ vorlon
$ The Vorlon server is running
```

The server is now running and you have the ability to listen to clients.
To actually see the clients linked with Vorlon, you can go now to Vorlon dashboard by opening `http://localhost:1337/dashboard`

### Insert script in your client app (remote device)
To link your client page with the Vorlon server, you need to add the following script into your page in the `<head>` tag section. 
It is advisable to load the script before all the others.

```html
<script src="http://YOUR_LOCAL_MACHINE:1337/vorlon.js"></script>
````
### Start debugging
Open your client app, go to the dashboard at `http://YOUR_LOCAL_MACHINE:1337/dashboard` and explorer the features.

## Proxy
To debug a site already in production for which the Vorlon script has not been inserted, it is possible to use the Vorlon proxy. It is a separate dashboard and is accessible at `http://YOUR_LOCAL_MACHINE:1337/httpproxy`. The proxy will inject the Vorlon client script when you give it a target link, and you can start the debug.
<br/>
<br/>
<br/>
If you want to know more, check out the [documentation page](http://www.vorlonjs.io/documentation/) or the [introductory video](http://vorlonjs.com/#getting-started).
