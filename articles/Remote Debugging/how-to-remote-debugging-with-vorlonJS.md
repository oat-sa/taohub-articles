<!--
   tags:
       Debugging:
           - "Remote debugging with VorlonJS"
-->
# Remote debugging with VorlonJS

> This article explains how to remotely debugging and testing your JavaScript using `vorlon.js`. While working with a Mac and an iPad might be straight forward, achievieving the same thing with a PC is more complicate. Here is one possible approach.

## Server (your local machine)

Install VorlonJS server from npm
```console
$ npm i -g vorlon
```

Then, run the server
```console
$ vorlon
$ The Vorlon server is running
```

The server is now running and you have the ability to listen to clients.
To actually see the clients linked with Vorlon, you can go now to Vorlon dashboard by opening `http://localhost:1337/dashboard`

## Client (remote device)
To link your client page with the Vorlon server, you need to add the following script tag to your page. 

```javascript
<script src="http://YOUR_LOCAL_MACHINE:1337/vorlon.js"></script>
````

Open your client app and see the client appearing on the Vorlon dashboard.
