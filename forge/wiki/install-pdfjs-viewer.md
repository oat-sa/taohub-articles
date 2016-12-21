<!--
author:
    - 'Jean-Sébastien Conan'
created_at: '2016-09-21 15:35:10'
updated_at: '2016-09-21 16:01:18'
tags:
    - Wiki
-->

Install PDFjs viewer
====================

![](http://forge.taotesting.com/attachments/download/4125/pdfjs.svg):https://mozilla.github.io/pdf.js/

Install PDF.js library, using the script
----------------------------------------

For users with a Unix machine, you can use the following bash script to download and install PDF.js.\
TAO 3.0: [PDFJS\_Install\_TAO\_3x.sh](../resources//attachments/download/4123/PDFJS_Install_TAO_3x.sh)

Be sure to have `wget` (or `curl` with 3.0 version), and `unzip` installed and available in your `PATH`. Then just launch it (as a user, not root) from the root of your TAO distribution.

Install PDF.js library manually
-------------------------------

Even if all major browser are able to render PDF files, the way they render them is not consistent across all brands and OS. So a unified viewer is better to ensure a consistent user experience. To do so TAO relies on a third-party library called [PDF.js](https://mozilla.github.io/pdf.js/) and released by the Mozilla Foundation under the Apache 2.0 license.

Because of license compatibility issue, it cannot be included within the default TAO package. That is why you need to install this library separately to use a consistent pdf viewer.

You can download it freely [here](https://mozilla.github.io/pdf.js/getting_started/#download) and unzip it into the following folder: {YOUR\_TAO\_ROOT}/tao/views/js/lib/pdfjs. Your file system should look like this:

    /tao
        [...]
        /views
            [...]
            /js
            [...]
                /lib
                    [...]
                    /pdfjs
                        /build
                            /pdf.js
                            /pdf.worker.js
                        /web
                            /cmaps
                            /images
                            /locale
                            /compatibility.js
                            /compressed.tracemonkey-pldi-09.pdf
                            /debugger.js
                            /l10n.js
                            /viewer.css
                            /viewer.html
                            /viewer.js
                        /LICENSE
                    [...]
Install PDFjs viewer
====================

![](http://forge.taotesting.com/attachments/download/4125/pdfjs.svg):https://mozilla.github.io/pdf.js/

Install PDF.js library, using the script
----------------------------------------

For users with a Unix machine, you can use the following bash script to download and install PDF.js.<br/>

TAO 3.0: [PDFJS\_Install\_TAO\_3x.sh](../resources//attachments/download/4123/PDFJS_Install_TAO_3x.sh)

Be sure to have `wget` (or `curl` with 3.0 version), and `unzip` installed and available in your `PATH`. Then just launch it (as a user, not root) from the root of your TAO distribution.

Install PDF.js library manually
-------------------------------

Even if all major browser are able to render PDF files, the way they render them is not consistent across all brands and OS. So a unified viewer is better to ensure a consistent user experience. To do so TAO relies on a third-party library called [PDF.js](https://mozilla.github.io/pdf.js/) and released by the Mozilla Foundation under the Apache 2.0 license.

Because of license compatibility issue, it cannot be included within the default TAO package. That is why you need to install this library separately to use a consistent pdf viewer.

You can download it freely [here](https://mozilla.github.io/pdf.js/getting_started/#download) and unzip it into the following folder: {YOUR\_TAO\_ROOT}/tao/views/js/lib/pdfjs. Your file system should look like this:

    /tao
        [...]
        /views
            [...]
            /js
            [...]
                /lib
                    [...]
                    /pdfjs
                        /build
                            /pdf.js
                            /pdf.worker.js
                        /web
                            /cmaps
                            /images
                            /locale
                            /compatibility.js
                            /compressed.tracemonkey-pldi-09.pdf
                            /debugger.js
                            /l10n.js
                            /viewer.css
                            /viewer.html
                            /viewer.js
                        /LICENSE
                    [...]

