<!--
authors:
    - "Bertrand Chevrier"
tags:
   - "Frontend":
        - "Frontend Architecture"
-->

# Build 



## Bundling

**Client side source code must be optimized**

There are two distinct modes into TAO :

1. `DEBUG` mode (akka Development mode)
2. `PRODUCTION` mode (akka Bundle mode)

You can change the mode by switching the value of the constant `DEBUG_MODE` into `config/generis.conf.php`

On of the main difference between those two modes is the client side source code is optimized. Per extension, the source code is aggregated into bundles, transformed and optimized :

The bundler is available as a Grunt task in the repository [oat-sa/grunt-tao-bundle](https://github.com/oat-sa/grunt-tao-bundle).

![bundler](../resources/tao-bundler.png)

 - The bundler create bundles per extension and per target (backoffice, frontoffice, separate entry point, etc.)
 - Libraries and the core framework is in a `vendor` bundle
 - The optimizer supports UglifyJs and Babbel.
 - Each extension needs to configure its bundles into the files `views/build/grunt/bundle.js`
 - Bundling is done during the release of an extension, not during it's development.

For example :

```js
module.exports = function(grunt) {      //it's a Grunt configuration so we're in a node.js process
    'use strict';

    grunt.config.merge({                //add it to the configuration
        bundle : {                      //the config entry is always bundle
            taoce : {                   //name the task like the extension, lowercase, by convention
                options : {             //define the bundles options
                    extension : 'taoCe',
                    outputDir : 'loader',
                    bundles : [{
                        name : 'taoCe',
                        default : true
                    }]
                }
            }
        }
    });
    grunt.registerTask('taocebundle', ['bundle:taoce']);    //register a task alias
};
```

Per extension you can generate the bundle using the following command, the task name is `${extensionNameLowerCase}bundle`, so to bundle the extension `taoCe` you'll have :

![bundle taoce](../resources/bundle-taoce.png)


