<!--
tags: ["Style Guide:Block Elements"]
-->

# Block Elements

> Headings, paragraphs, lists etc.

## Headings

# Heading 1

## Heading 2

### Heading 3

#### Heading 4

##### Heading 5

###### Heading 6
```html
	<h1>Heading 1</h1>
	<h2>Heading 2</h2>
	<h3>Heading 3</h3>
	<h4>Heading 4</h4>
	<h5>Heading 5</h5>
	<h6>Heading 6</h6>
```
## Paragraphs

Regular text
```html
	<p>Regular text</p>
```
## Lists

Not all classes work in every browser, see [MDN](https://developer.mozilla.org/en-US/docs/Web/CSS/list-style-type#Browser_compatibility) for a comprehensive list.

There is also support for list styles on elements other than `<ul>` or `<ol>`, though not for all styles. To use them prefix the class-name with `list-style-`, the symbols will appear on direct child elements only.


`plain` or `none` means no padding, no margin, no bullets
```html
	<ul class="plain">
		<li>No padding, no margin, no bullets</li>
	</ul>
	// or
	<ul class="none">
		<li>No padding, no margin, no bullets</li>
	</ul>  
```

● `disc` (or no class at all on `<ul>`)
```html
	<ul>
		<li>No class at all</li>
	</ul>
	// or
	<ol class="disc">
		<li>Disc</li>
	</ol>

	// on other elements
	<div class="list-style-disc">
		<div>Element with list style</div>
	</div>
```
             
○ `circle` 
```html
	<ul class="circle">
		<li>Circle</li>
	</ul>

	// on other elements
	<div class="list-style-circle">
		<div>Element with list style</div>
	</div>   
```

■ `square`
```html
	<ul class="square">
		<li>Square</li>
	</ul>

	// on other elements
	<div class="list-style-square">
		<div>Element with list style</div>
	</div>
```  

1. `decimal` (or no class at all on `<ol>`)
```html
	<ol>
		<li>No class at all</li>
	</ol>
	<ul class="decimal">
		<li>Decimal</li>
	</ul>

	// on other elements
	<div class="list-style-decimal">
		<div>Element with list style</div>
	</div>  
``` 

01. `decimal-leading-zero`
```html
	<ol class="decimal-leading-zero">
		<li>Decimal Leading Zero</li>
	</ol>

	// on other elements
	<div class="list-style-decimal-leading-zero">
		<div>Element with list style</div>
	</div>  
```  

a. `lower-alpha` or `lower-latin`
```html
	<ol class="lower-alpha">
		<li>Lower Alpha</li>
	</ol>
	// or 
	<ol class="lower-latin">
		<li>Lower Latin</li>
	</ol>

	// on other elements
	<div class="list-style-lower-alpha">
		<div>Element with list style</div>
	</div> 
	// or 
	<div class="list-style-lower-latin">
		<div>Element with list style</div>
	</div>  
``` 

A. `upper-alpha` or `upper-latin`
```html
	<ol class="upper-alpha">
		<li>Upper Alpha</li>
	</ol>
	// or        
	<ol class="upper-latin">
		<li>Upper Alpha</li>
	</ol> 

	// on other elements
	<div class="list-style-upper-alpha">
		<div>Element with list style</div>
	</div> 
	// or 
	<div class="list-style-upper-latin">
		<div>Element with list style</div>
	</div>   
```

i. `lower-roman`
```html
	<ol class="lower-roman">
		<li>Lower Roman</li>
	</ol>

	// on other elements
	<div class="list-style-lower-roman">
		<div>Element with list style</div>
	</div>   
```

I. `upper-roman`
```html
	<ol class="upper-roman">
		<li>Upper Roman</li>
	</ol>

	// on other elements
	<div class="list-style-upper-roman">
		<div>Element with list style</div>
	</div>   
```

α. `lower-greek`
```html
	<ol class="lower-greek">
		<li>Lower Greek</li>
	</ol>

	// on other elements
	<div class="list-style-lower-greek">
		<div>Element with list style</div>
	</div>   
```

ա. `armenian`
```html
	<ol class="armenian">
		<li>Armenian</li>
	</ol>

	// on other elements
	<div class="list-style-armenian">
		<div>Element with list style</div>
	</div>   
```

ა. `georgian`
```html
	<ol class="georgian">
		<li>Georgian</li>
	</ol>

	// on other elements
	<div class="list-style-georgian">
		<div>Element with list style</div>
	</div>   
```

א. `hebrew` (`<ul>` and `<ol>` only)
```html
	<ol class="hebrew">
		<li>Hebrew</li>
	</ol>
```

あ、`hiragana` (`<ul>` and `<ol>` only)
```html
	<ol class="hiragana">
		<li>Hiragana</li>
	</ol>  
```

い、`hiragana-iroha` (`<ul>` and `<ol>` only)
```html
	<ol class="hiragana-iroha">
		<li>Hiragana Iroha</li>
	</ol>  
```

ア、 `katakana` (`<ul>` and `<ol>` only)
```html
	<ol class="katakana">
		<li>Katakana</li>
	</ol>  
```

イ、`katakana-iroha` (`<ul>` and `<ol>` only)
```html
	<ol class="katakana-iroha">
		<li>Katakana Iroha</li>
	</ol>  
```
