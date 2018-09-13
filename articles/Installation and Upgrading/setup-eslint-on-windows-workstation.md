# ESLint on Windows work station

To install ESLint plugin on PHP Storm go to: File > Settings > Plugins > Browse Repositories and search for ESLint, install and relaunch PHP Storm.

Install Node.js and install ESLint globally with command `npm i -g eslint`.

To setup ESLint properties go to: File > Settings > Language & Frameworks > Code quality tools > ESLint. Enable it and select ESLint package location.
Select ESLint configuration file on `package-tao/tao/views/build/.eslintrc.json`. 

Also edit *.eslintrc.json* file and change the line `"linebreak-style":      ["error", "unix"]`  to `"linebreak-style":      ["error", "windows"]`. 
This change will allow CRLF line breaks on PHP Storm.