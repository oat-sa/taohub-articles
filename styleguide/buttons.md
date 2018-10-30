<!--
tags: ["Style Guide:Buttons"]
-->

# Buttons

> Real buttons and elements that should look like buttons.

## Regular Buttons
<div>
<button class="btn-neutral" type="button">Neutral button</button>
<button type="button">Neutral is also the default</button>
<input class="btn-neutral" value="Same as input element" type="submit">
</div>

```html
	<button class="btn-neutral" type="button">Neutral button</button>
	<button type="button">Neutral is also the default</button>
	<input class="btn-neutral" value="Same as input element" type="submit">
```

<div>
<button class="btn-info" type="button">Info button</button>
<input class="btn-info" value="Same as input element" type="submit">
</div>

```html
	<button class="btn-info" type="button">Info button</button>
	<input class="btn-info" value="Same as input element" type="submit">
```

<div>
<button class="btn-success" type="button">Success button</button>
<input class="btn-success" value="Same as input element" type="reset">
</div>

```html
	<button class="btn-success" type="button">Success button</button>
	<input class="btn-success" value="Same as input element" type="reset">
```

<div>
<button class="btn-warning" type="button">Warning button</button>
<input class="btn-warning" value="Same as input element" type="submit">
</div>

```html
	<button class="btn-warning" type="button">Warning button</button>
	<input class="btn-warning" value="Same as input element" type="submit">
```
<div>
<button class="btn-error" type="button">Danger button</button>
<input class="btn-error" value="Same as input element" type="submit">
</div>

```html
	<button class="btn-error" type="button">Danger button</button>
	<input class="btn-error" value="Same as input element" type="submit">
```

<div>
<button class="btn-error" disabled="disabled" type="button">Disabled button</button>
<input class="btn-error" disabled="disabled" value="Same as input element" type="submit">
</div>

```html
	<button class="btn-error" disabled="disabled" type="button">Disabled button</button>
	<input class="btn-error" disabled="disabled" value="Same as input element" type="submit">
```

## Small buttons

Adding the class `.small` will create buttons that are less high. This has become the most commonly used way to create buttons within TAO.

<div>
<button class="btn-info small" type="button">Button</button>
</div>

```html
	<button class="btn-info small" type="button">Button</button>
```

<div>
<input class="btn-success small" value="Input" type="submit">
</div>

```html
	<input class="btn-success small" value="Input" type="submit">
```

<div>
<a class="btn-warning small" href="#">Random element</a>
</div>

```html
	<a class="btn-warning small" href="#">Random element</a>
```

<div>
<button class="btn-error small" type="button"><span class="icon-edit"></span>Icon left</button>
</div>

```html
	<button class="btn-error small" type="button"><span class="icon-edit"></span>Icon left</button>
```

<div>
<p class="btn-error small btn-disabled">Icon right<span class="icon-edit r"></span></p>
</div>

```html
	<p class="btn-error small btn-disabled">Icon right<span class="icon-edit r"></span></p>
```

## Buttons with icons on the left side

<div>
<button class="btn-info" type="button">Info button</button>
</div>

```html
	<button class="btn-info" type="button">Info button</button>
```

<div>
<button class="btn-success" type="button">Success button</button>
</div>

```html
	<button class="btn-success" type="button">Success button</button>
```

<div>
<button class="btn-warning" type="button">Warning button</button>
</div>

```html
	<button class="btn-warning" type="button">Warning button</button>
```

<div>
<button class="btn-error" type="button">Danger button</button>
</div>

```html
	<button class="btn-error" type="button">Danger button</button>
```

## Buttons with icons on the right side

Move the icon behind the text and add the class `.r`. This is not exactly elegant and might change in  
the future. This API however will be kept as legacy code.

<div>
<button class="btn-info" type="button">Info button</button>
</div>

```html
	<button class="btn-info" type="button">Info button</button>
```

<div>
<button class="btn-success" type="button">Success button</button>
</div>

```html
	<button class="btn-success" type="button">Success button</button>
```

<div>
<button class="btn-warning" type="button">Warning button</button>
</div>

```html
	<button class="btn-warning" type="button">Warning button</button>
```

<div>
<button class="btn-error" type="button">Danger button</button>
</div>

```html
	<button class="btn-error" type="button">Danger button</button>
```

## Buttons made from random elements

While the CSS rules work on about every random element JavaScript might be needed to achieve certain functionality.

<div>
<a class="btn-button">&lt;a&gt; button</a>
</div>

```html
	<a class="btn-button">&lt;a&gt; button</a>
```

<div>
<div class="btn-error">&lt;div&gt; button</div>
</div>

```html
	<div class="btn-error">&lt;div&gt; button</div>
```

<div>
<span class="btn-info"><span> button</span>
</div>

```html
	<span class="btn-info">&lt;span&gt; button</span>
```

<div>
<b class="btn-success">&lt;b&gt; button</b>
</div>

```html
	  <b class="btn-success">&lt;b&gt; button</b>
```

Buttons made from elements other than `button` or `input` must have the class `btn-disabled`. The behavior is identical to that of a real `button:disabled` or `input:disabled`.

<div>
<i class="btn-success disabled" type="button">Disabled button</i>
</div>

```html
	<i class="btn-success disabled" type="button">Disabled button</i>
```
