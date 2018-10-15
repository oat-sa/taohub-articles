# Setup Javascript work station

## 1. Prepare PHP Storm
To install ESLint plugin on PHP Storm go to: File > Settings > Plugins > Browse Repositories and search for ESLint, install and relaunch PHP Storm.

Install Node.js and install ESLint globally with command `npm i -g eslint`.

Configuration file is located at: `tao\views\build\.eslintrc.json`

## 2. Setup end of line characters on Windows / PHPStorm

Go to File > Settings > Editor > Code Style select Line Separator - Unix.

## 3. Editor configuration

Also you can use EditorConfig plugin, which is available for most IDEs and editors, including PHP Storm.

Create file ``.editorconfig`` at the parent location of your project with this content:

````
; .editorconfig

root = true

[**.js]
end_of_line = lf
trim_trailing_whitespace = true

[**.json]
indent_size = 2
end_of_line = lf
trim_trailing_whitespace = true

[**.{html,tpl}]
brace_style = expand
end_of_line = lf
trim_trailing_whitespace = true
````