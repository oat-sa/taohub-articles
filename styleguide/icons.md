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
