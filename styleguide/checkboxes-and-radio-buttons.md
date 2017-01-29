<!--
tags: ["Style Guide:Checkboxes and Radio buttons"]
-->

# Checkboxes and Radio buttons

> Real checkboxes and radio buttons and fake ones.


## Checkboxes

<label>Checkbox right <input type="checkbox">
<span class="icon-checkbox"> </span></label> 
```html
	<label>
		Checkbox right
		<input type="checkbox">
		<span class="icon-checkbox"></span>        
	</label>
```

<label><input type="checkbox"> <span class="icon-checkbox">
</span> Checkbox left</label>
```html
	<label>
		<input type="checkbox">
		<span class="icon-checkbox"></span>
		Checkbox left
	</label>
```

<label>Checkbox right (cross as marker) <input type="checkbox"> <span class="icon-checkbox cross"> </span></label> 
```html
	<label>
		Checkbox right (cross as marker)
		<input type="checkbox">
		<span class="icon-checkbox cross"></span>
	</label>
```

<label><input type="checkbox">
<span class="icon-checkbox cross"> </span>
Checkbox left (cross as marker)</label> 
```html
	<label>
		<input type="checkbox">
		<span class="icon-checkbox cross"></span>
		Checkbox left (cross as marker)
	</label>
```

## Radio buttons

<label>Radio button right <input name="ra-test" type="radio">
<span class="icon-radio"> </span></label> 
```html
	<label>
		Radio button right
		<input name="ra-test" type="radio">
		<span class="icon-radio"></span>
	</label>
```

<label><input name="ra-test" type="radio">
<span class="icon-radio"> </span> Radio button left</label>
```html
	<label>
		<input name="ra-test" type="radio">
		<span class="icon-radio"></span>
		Radio button left
	</label>
```

## Labels containing block elements

<!-- radio button with real label -->
<label>
  <input name="ra-test" type="radio">
  <span class="icon-radio"></span>
  Real label on a radio button for direct comparison
</label>

<!-- radio button with fake label -->
<div class="pseudo-label-box">
  <label>
    <input name="ra-test" type="radio">
   <span class="icon-radio"></span>
  </label>
  <div class="label-box">
    <div class="label-content clear">
      <p>Fake label on a radio button</p>
    </div>
  </div>
</div>

<!-- checkbox with real label -->
<label>
  <input name="ra-test" type="checkbox">
  <span class="icon-checkbox"></span>
  Real label on a checkbox for direct comparison
</label>

<!-- checkbox with fake label -->
<div class="pseudo-label-box">
  <label>
    <input name="ra-test" type="checkbox">
   <span class="icon-checkbox"></span>
  </label>
  <div class="label-box">
    <div class="label-content clear">
      <p>Fake label on a checkbox</p>
    </div>
  </div>
</div>

```html
  <!-- radio button with real label -->
  <label>
    <input name="ra-test" type="radio">
    <span class="icon-radio"></span>
    Real label on a radio button for direct comparison
  </label>
  
  <!-- radio button with fake label -->
  <div class="pseudo-label-box">
    <label>
      <input name="ra-test" type="radio">
     <span class="icon-radio"></span>
    </label>
    <div class="label-box">
      <div class="label-content clear">
        <p>Fake label on a radio button</p>
      </div>
    </div>
  </div>
  
  <!-- checkbox with real label -->
  <label>
    <input name="ra-test" type="checkbox">
    <span class="icon-checkbox"></span>
    Real label on a checkbox for direct comparison
  </label>
  
  <!-- checkbox with fake label -->
  <div class="pseudo-label-box">
    <label>
      <input name="ra-test" type="checkbox">
     <span class="icon-checkbox"></span>
    </label>
    <div class="label-box">
      <div class="label-content clear">
        <p>Fake label on a checkbox</p>
      </div>
    </div>
  </div>
```
		
	

Fake labels require some JavaScript to function:
```javascript
	$('.pseudo-label-box').on('click', function() {
		$(this).find('input:radio, input:checkbox').first()[0].checked = true;
	});
```
