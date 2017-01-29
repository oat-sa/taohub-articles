<!--
tags: ["Style Guide:Buttons"]
-->

# Buttons

> Real buttons as well as elements that should look like buttons.

## Regular Buttons

<button class="btn-neutral" type="button">Neutral button</button>
<button type="button">Neutral is also the default</button>
<input class="btn-neutral" value="Same as input element" type="submit">
```html
	<button class="btn-neutral" type="button">Neutral button</button>
	<button type="button">Neutral is also the default</button>
	<input class="btn-neutral" value="Same as input element" type="submit">
```

<button class="btn-info" type="button">Info button</button>
<input class="btn-info" value="Same as input element" type="submit">
```html
	<button class="btn-info" type="button">Info button</button>
	<input class="btn-info" value="Same as input element" type="submit">
```

<button class="btn-success" type="button">Success button</button>
<input class="btn-success" value="Same as input element" type="reset">
```html
	<button class="btn-success" type="button">Success button</button>
	<input class="btn-success" value="Same as input element" type="reset">
```

<button class="btn-warning" type="button">Warning button</button>
<input class="btn-warning" value="Same as input element" type="submit">
```html
	<button class="btn-warning" type="button">Warning button</button>
	<input class="btn-warning" value="Same as input element" type="submit">
```

<button class="btn-error" type="button">Danger button</button>
<input class="btn-error" value="Same as input element" type="submit">
```html
	<button class="btn-error" type="button">Danger button</button>
	<input class="btn-error" value="Same as input element" type="submit">
```

<button class="btn-error" disabled="disabled" type="button">Disabled button</button>
<input class="btn-error" disabled="disabled" value="Same as input element" type="submit">
```html
	<button class="btn-error" disabled="disabled" type="button">Disabled button</button>
	<input class="btn-error" disabled="disabled" value="Same as input element" type="submit">
```

## Small buttons

Adding the class `.small` will create buttons that are less high. This has become the most commonly used way to create buttons within TAO.

<button class="btn-info small" type="button">Button</button>
```html
	<button class="btn-info small" type="button">Button</button>
```

<input class="btn-success small" value="Input" type="submit">
```html
	<input class="btn-success small" value="Input" type="submit">
```

<a class="btn-warning small" href="#">Random element</a>
```html
	<a class="btn-warning small" href="#">Random element</a>
```

<button class="btn-error small" type="button">Icon left</button>
```html
	<button class="btn-error small" type="button">Icon left</button>
```

<p class="btn-error small btn-disabled">Icon right</p>

```html
	<p class="btn-error small btn-disabled">Icon right</p>
```

## Buttons with icons on the left side

<button class="btn-info" type="button">Info button</button>

```html
	<button class="btn-info" type="button">Info button</button>
```

<button class="btn-success" type="button">Success button</button>

```html
	<button class="btn-success" type="button">Success button</button>
```

<button class="btn-warning" type="button">Warning button</button>

```html
	<button class="btn-warning" type="button">Warning button</button>
```

<button class="btn-error" type="button">Danger button</button>

```html
	<button class="btn-error" type="button">Danger button</button>
```

## Buttons with icons on the right side

Move the icon behind the text and add the class `.r`. This is not exactly elegant and might change in  
the future. This API however will be kept as legacy code.

<button class="btn-info" type="button">Info button</button>

```html
	<button class="btn-info" type="button">Info button</button>
```

<button class="btn-success" type="button">Success button</button>

```html
	<button class="btn-success" type="button">Success button</button>
```

<button class="btn-warning" type="button">Warning button</button>

```html
	<button class="btn-warning" type="button">Warning button</button>
```

<button class="btn-error" type="button">Danger button</button>

```html
	<button class="btn-error" type="button">Danger button</button>
```

## Buttons made from random elements

While the CSS rules work on about every random element JavaScript might be needed to achieve certain functionality.

<a class="btn-button">&lt;a&gt; button</a>

```html
	<a class="btn-button">&lt;a&gt; button</a>
```

<div class="btn-error">&lt;div&gt; button</div>
```html
	<div class="btn-error">&lt;div&gt; button</div>
```

<span class="btn-info"><span> button</span>

```html
	<span class="btn-info">&lt;span&gt; button</span>
```

<b class="btn-success">&lt;b&gt; button</b>

```html
	  <b class="btn-success">&lt;b&gt; button</b>
```

Buttons made from elements other than `button` or `input` must have the class `btn-disabled`. The behavior is identical to that of a real `button:disabled` or `input:disabled`.

<i class="btn-success disabled" type="button">Disabled button</i>

```html
	<i class="btn-success disabled" type="button">Disabled button</i>
```
