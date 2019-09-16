<!--
authors:
    - "Bertrand Chevrier"
tags:
    Frontend Architecture:
        - "Libraries"
-->
# Libraries

> List main libraries used into TAO and the rules to evaluate new libraries.

The following libraries are used into TAO : 

| Library  | Version | License | Used for |  Could be replaces by | 
| -------- | ------- | ------- | -------- |---------------------- |
| [require.js](https://requirejs.org)  | 2.3.6  | MIT | Module and asset loading, dependency injection, configuration and bundling | `import` / `export`, browserify, rollup, SystemJs, webpack, etc.|
| [jQuery](https://jquery.com)  | 1.9.1  | MIT | DOM Manipulation, Ajax Requests | Native APIs |
| [jQueryUi](https://jqueryui.com)  | 1.9.2  | MIT |  _DEPRECATED_ TAO installer and item creator drag and drop | Integrated componentsi, interact |
| [interact](https://interactjs.io)  | 1.3.4  | MIT | Drag and Drop, Gestures and resizing|  |
| [popper](https://popper.js.org)  | 1.14.5  | MIT | Tooltip, poppers, relative positioning |  |
| [lodash](https://lodash.com)  | 2.4.1 | MIT | Data manipulation | ES2015+ built-ins (partially)  |
| [handlebars](https://handlebarsjs.com)  | 1.3.1 | MIT | Template and data binding |   |
| [QUnit](https://qunitjs.com)  | 2.9.1 | MIT | Testing |   |
| [Grunt](https://gruntjs.com)  | 1.0.0 | MIT | Task runner | npm scripts  |
| [moment](https://momentjs.com)  | 2.11.1 | MIT | Date, time, duration, timezone and localization   |   |
| [d3](https://d3js.org)  | 3.5.16 | MIT | Data visualization   |   |
| [c3](https://c3js.org)  | 0.4.23 | MIT | Chart and plot |   |
| [CKEditor](https://ckeditor.com)  | 4.4.8 TAO-1 (OAT Fork, upstream 4.4.8) | GPL |  Item Creator, WYSIWYG / HTML editor |  Anything else |
| [MathJax](https://www.mathjax.org)  | 2.6.1 | Apache 2 | Rendering Math Expressions |  katex |
| [Raphael](http://raphaeljs.com)  | 2.1.2 | MIT | _DEPRECATED_ SVG & Graphic Interaction  |  Native APIs |
| [Async](https://github.com/caolan/async)  | 1.5.0 | MIT |  _DEPRECATED_ Async flow  | `Promise` `async/await` |
| [ESlint](https://eslint.org)  | 5.0.0 | MIT | JavaScript code linter  | |
| [Babel](https://babeljs.io)  | 7.4.3 | MIT |  Transpile JavaScript  | |
| [SASS](https://sass-lang.com)  | node-sass 4.9.3 / libsass 3.5.4 | MIT |  Compile SCSS to CSS  | |

A dedicated npm package enforces you to use the correct version of the main libraries : https://github.com/oat-sa/tao-core-libs-fe

#### New libraries

> If you add a library, please remove one...

If none of the libraries available in TAO help you to solve a problem, it's possible to add a new one, after some evaluation, based on the following criteria :
- *Size matter* : the smallest possible
- *No or few dependency* : no we won't include a framework to run only a part of it.
- *License* : it should be compatible with GPLv2 (Apache licenses aren't compatible for example)
- *Alive* : the library should be still maintain and active (in some situation we can think taking the ownership if the library is vital for our business)
- *Clean API* : the library should expose a clean API that won't constrain us in using it
 

