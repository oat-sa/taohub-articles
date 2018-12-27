<!--
tags: ["Style Guide:Icons"]
-->


# Icons

> As from version 3.0 on TAO uses a custom font to display icons. More recent versions also offer basic support for SVG icons.

## General Usage
Adding an icon is as simple as adding the class `.icon-*` to an element where `*` stands for the name of the icon. Usually an extra `span` element is used.

## Creating icon elements in PHP
Each time the icon set changes the class `tao_helpers_Icon` is being updated automatically. It provides convenient ways to create icons programmatically.

One way to do this is to use the method `tao_helpers_Icon::iconNameToCamelCase($options=array())`
```php
	tao_helpers_Icon::iconCheckbox();
```
Optionally this method accepts a hash table with HTML attributes. You can also change the tag name by setting `array('element' =&gt; 'myFavoriteHtmlElement')`.

```php
    tao_helpers_Icon::iconCheckbox(
		array(
			'element'      => 'b',
			'class'        => 'art',
			'title'        => __('Ceci n’est pas une pipe'),
			'data-painter' => 'René Magritte'
		)
	);
```
*Note: While the above way to change the element technically works there is no guarantee that the result looks exactly as intended. The preferred way is to embed the default `span`, even when this means you use an additional element.*

Another possibility is to use the class constant `tao_helpers_Icon::CLASS_ICON_NAME_TO_UPPER_CASE`

## How to add a new icon to the TAO font

1.  Check out the latest `develop` branch of `extension-tao-devtools` and install it in a fresh instance of TAO.
2.  Go to the [Icomoon app](icomoon.io/app).
3.  Click 'Import icons'. The file you need to upload here, containing all the TAO icon definitions, is `taoDevTools/fontConversion/assets/selection.json`. Once uploaded, you should see over 200 icons appear on screen in the web app.
4.  Now you can find the new icon you want to add to this selection. You can search on Icomoon for something free or open-source (Font Awesome is preferred), or even upload your own SVG icon.
[!../resources/icomoon-tao-icons-plus1.png]
5.  Once the new non-TAO icon(s) are added to the selection, you must edit their metadata (with the pencil tool). Set the grid size to 32, and the tag and name to whatever name you want it to have on TAO.
[!../resources/icomoon-dialog.png]
6.  Next, click 'Generate Font' and 'Download', which will give you a zip file.
7.  Log in to TAO as admin, and navigate to 'Tools' > 'TAO Icon Font'. Here you will upload the zip file you just got. After refreshing the page, you should see a placeholder for your new icon in the grid.
8.  Some files have been automagically changed: `tao/helpers/class.Icon.php` and some SCSS files in `tao/views/scss/inc/fonts`. You will therefore need to run the SCSS compilation task for the extension: `npx grunt taosass`
9.  You should now be able to test your icon anywhere on TAO.
10.  Commit your changes to `extension-tao-devtools` (1 file) and make a PR to `develop`.
11.  Commit your changes to `tao-core` (~9 files) and make a PR to `develop`.

## Using icons in SCSS

In this scenario you have a class `.foo` that for some reasons should use the code of `.icon-bar`.

```scss
	@import 'inc/bootstrap';
	.foo {
		@extend %icon-bar;
	}
```

*Note: Never extend CSS class `.icon-bar` directly, always reference the SCSS variable `%icon-bar` instead!*

## List of all existing icons along with their class name

The CSS class for all icons is `.icon-` followed by the corresponding identifier below. You can also hover over each field to display the CSS class.
