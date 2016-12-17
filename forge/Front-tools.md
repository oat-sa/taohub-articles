---
tags: Forge
---

Front tools
===========

**These tools *are not required* to run TAO, but can be helpful for client side development.**

Grunt
-----

[Grunt](resources/http://gruntjs.com/) helps you to automate tasks like require.js optimization, SASS compiling, test running, code linting, etc.

Grunt runs on node.js, so you need [node.js](resources/https://nodejs.org/en/download/) installed and running.

- For Linux user, you could install it easily node from a native package using [nodesource](resources/https://github.com/nodesource/distributions)

    curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
    sudo apt-get install -y nodejs

- If you want node only for your user, you can install it using [nvm](resources/https://github.com/creationix/nvm)

    curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.31.1/install.sh | bash
    nvm install v6.2.1
    nvm alias default v6.2.1

- The current SASS scripts used in TAO contains a bug, so we can’t use the libsass until it is fixed. You need then to have the sass tool available on your system:\
For Ubuntu/Debian user :

    sudo apt-get install rubygems
    sudo gem install sass

For MacOS user, ruby comes installed to your system, you just have to install sass :

    gem install sass

- Then to install and set up Grunt :

    npm install -g grunt-cli csso
    cd tao/views/build
    npm install

Then you should be able to see available grunt tasks from the `tao/views/build` directory:

    grunt --help
