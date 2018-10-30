<!--
created_at: '2016-09-21 15:35:10'
updated_at: '2017-05-11 08:30:00'
authors:
    - 'Jean-Sébastien Conan'
tags:
    - 'Frontend'
    - 'Library'
    - 'JavaScript'
    - 'PDF'
-->

Install PDFjs viewer
====================

![PDF.js logo](../resources/third-party/pdfjs.svg) https://mozilla.github.io/pdf.js/

> PDF.js is a web based viewer for PDF documents.
> Using such a viewer brings a better user experience as it should display consistently on each browser.

Install PDF.js library, using the script
----------------------------------------

For users with a Unix machine, you can use the following bash script to download and install PDF.js.

TAO 3.0: [PDFJS_Install_TAO_3x.sh](../resources/third-party/PDFJS_Install_TAO_3x.sh)

Be sure to have `wget` (or `curl` with 3.0 version), and `unzip` installed and available in your `PATH`. Then just launch it (as a user, not root) from the root of your TAO distribution.

Install PDF.js library manually
-------------------------------

Even if all major browsers are able to render PDF files, the way they render them is not consistent across all brands and OS. So a unified viewer is better to ensure a consistent user experience. To do so TAO relies on a third-party library called [PDF.js](https://mozilla.github.io/pdf.js/) and released by the Mozilla Foundation under the Apache 2.0 license.

Because of license compatibility issue, it cannot be included within the default TAO package. That is why you need to install this library separately to use a consistent pdf viewer.

You can download it freely [here](https://mozilla.github.io/pdf.js/getting_started/#download) and unzip it into the following folder: {YOUR_TAO_ROOT}/tao/views/js/lib/pdfjs. Your file system should look like this:

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

