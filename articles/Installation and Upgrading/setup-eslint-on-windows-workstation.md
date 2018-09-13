# ESLint on Windows work station

## 1. Prepare PHP Storm
To install ESLint plugin on PHP Storm go to: File > Settings > Plugins > Browse Repositories and search for ESLint, install and relaunch PHP Storm.

Install Node.js and install ESLint globally with command `npm i -g eslint`.

## 2. Setup end of line characters on Windows / PHPStorm
On PHP Storm select line seperator LF Unix.

Also run Git commands that will globally select default line separator LF. If you want to adjust settings of single repos don't use *--global*
```
# Disable automatic CRLF normalization
git config --global core.autocrlf false

# Set line separator LF
git config --global core.eol lf
```

## 3. Download repositories
After ESLint preparation you can safely download TAO Package.