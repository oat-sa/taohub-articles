<!--
parent:
    title: Fine_tuning_TAO_26_settings_(Alternative_data_storage)
author:
    - 'Joel Bout'
created_at: '2014-08-29 15:24:27'
updated_at: '2014-08-29 15:24:27'
tags:
    - 'Fine tuning TAO 26 settings (Alternative data storage)'
-->

Apache Module mod\_deflate configuration
========================================

A generic sample configuration



    # Force compression for mangled headers.
    # https://developer.yahoo.com/blogs/ydn/pushing-beyond-gzipping-25601.html



    SetEnvIfNoCase ^(Accept-EncodXng|X-cept-Encoding|X{15}|~{15}|-{15})$ ^((gzip|deflate)\s*,?<br/>
s*)+|[X~-]{4,13}$ HAVE_Accept-Encoding
    RequestHeader append Accept-Encoding "gzip,deflate" env=HAVE_Accept-Encoding



    # - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    # Mark certain resources as been compressed in order to:
    #
    # 1) prevent Apache from recompressing them
    # 2) ensure that they are served with the correct
    # `Content-Encoding` HTTP response header


    AddEncoding gzip svgz


    # - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    # Compress all output labeled with one of the following media types.

    # IMPORTANT: For Apache versions below 2.3.7 you don't need to enable
    # `mod_filter` and can remove the `` & ``
    # lines as `AddOutputFilterByType` is still in the core directives.


    AddOutputFilterByType DEFLATE "application/atom+xml" <br/>
    "application/javascript" <br/>
    "application/json" <br/>
    "application/ld+json" <br/>
    "application/manifest+json" <br/>
    "application/rss+xml" <br/>
    "application/vnd.geo+json" <br/>
    "application/vnd.ms-fontobject" <br/>
    "application/x-font-ttf" <br/>
    "application/x-web-app-manifest+json" <br/>
    "application/xhtml+xml" <br/>
    "application/xml" <br/>
    "font/opentype" <br/>
    "image/svg+xml" <br/>
    "image/x-icon" <br/>
    "text/cache-manifest" <br/>
    "text/css" <br/>
    "text/html" <br/>
    "text/plain" <br/>
    "text/vtt" <br/>
    "text/x-component" <br/>
    "text/xml"



