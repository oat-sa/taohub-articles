<!--
tags: ["Style Guide:Tables"]
-->

# Tables	

> The most common use for tables in TAO is the Match Interaction					

## Default setup

Tables need to have the class `matrix` to look like this. All tables need to be properly constructed with `thead` and `tbody`. Odd and even rows have alternating colors.

<table class="matrix">
  <thead>
    <tr>
      <th></th>
      <th>Column header</th>
      <th>Column header</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Row header</th>
      <td>Odd row</td>
      <td>Odd row</td>
    </tr>
    <tr>
      <th>Row header</th>
      <td>Even row</td>
      <td>Even row</td>
    </tr>
    <tr>
      <th>Row header</th>
      <td>Odd row</td>
      <td>Odd row</td>
    </tr>
  </tbody>
</table>

```html
	<table class="matrix">
	  <thead>
	    <tr>
	      <th></th>
	      <th>Column header</th>
	      <th>Column header</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <th>Row header</th>
	      <td>Odd row</td>
	      <td>Odd row</td>
	    </tr>
	    <tr>
	      <th>Row header</th>
	      <td>Even row</td>
	      <td>Even row</td>
	    </tr>
	    <tr>
	      <th>Row header</th>
	      <td>Odd row</td>
	      <td>Odd row</td>
	    </tr>
	  </tbody>
	</table>
```

## Numeric data
If your table contains numeric data you might want to align them on the right side. You can do this either per cell `td.numeric`, per row `tr.numeric` or per column `col.numeric`.

<table class="matrix">
  <colgroup>
    <col>
    <col>
    <col class="numeric">
  </colgroup>
  <thead>
    <tr>
      <th></th>
      <th>Column header</th>
      <th>Column with class <i>numeric</i></th>
    </tr>
  </thead>
  <tbody>
    <tr class="numeric">
      <th>Row with class <i>numeric</i></th>
      <td>1234</td>
      <td>1234</td>
    </tr>
    <tr>
      <th>Cells with class <i>numeric</i></th>
      <td class="numeric">1234</td>
      <td class="numeric">1234</td>
    </tr>
  </tbody>
</table>

```html
	<table class="matrix">
	  <colgroup>
	    <col>
	    <col>
	    <col class="numeric">
	  </colgroup>
	  <thead>
	    <tr>
	      <th></th>
	      <th>Column header</th>
	      <th>Column with class <i>numeric</i></th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr class="numeric">
	      <th>Row with class <i>numeric</i></th>
	      <td>1234</td>
	      <td>1234</td>
	    </tr>
	    <tr>
	      <th>Cells with class <i>numeric</i></th>
	      <td class="numeric">1234</td>
	      <td class="numeric">1234</td>
	    </tr>
	  </tbody>
	</table>
```
