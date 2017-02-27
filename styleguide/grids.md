<!--
tags: ["Style Guide:Grids"]
-->


# Grids

> The grid is based on a responsive 12-column system. This means that each column has a width between 1/12 and 12/12 of its parent container. You create a column by assigning the `.col-*` to an element where `*` stands for the number of units you wish to use. Grid columns must sit inside grid rows `div.grid-row` and the whole set of rows in `div.grid-container`.

## Examples with blocks in the same size
  
<div class="grid-container">
  <div class="grid-row">
    <div class="col-12">.col-12</div>
  </div>
  <!-- next row -->
  <div class="grid-row">
    <div class="col-6">.col-6</div>
    <div class="col-6">.col-6</div>
  </div>
  <!-- next row -->
  <div class="grid-row">
    <div class="col-4">.col-4</div>
    <div class="col-4">.col-4</div>
    <div class="col-4">.col-4</div>
  </div>
  <!-- next row -->
  <div class="grid-row">
    <div class="col-3">.col-3</div>
    <div class="col-3">.col-3</div>
    <div class="col-3">.col-3</div>
    <div class="col-3">.col-3</div>
  </div>
  <!-- next row -->
  <div class="grid-row">
    <div class="col-2">.col-2</div>
    <div class="col-2">.col-2</div>
    <div class="col-2">.col-2</div>
    <div class="col-2">.col-2</div>
    <div class="col-2">.col-2</div>
    <div class="col-2">.col-2</div>
  </div>
  <!-- next row -->
  <div class="grid-row">
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
    <div class="col-1">.col-1</div>
  </div>
</div>

```html
  <div class="grid-container">
    <div class="grid-row">
      <div class="col-12">.col-12</div>
    </div>
    <!-- next row -->
    <div class="grid-row">
      <div class="col-6">.col-6</div>
      <div class="col-6">.col-6</div>
    </div>
    <!-- next row -->
    <div class="grid-row">
      <div class="col-4">.col-4</div>
      <div class="col-4">.col-4</div>
      <div class="col-4">.col-4</div>
    </div>
    <!-- next row -->
    <div class="grid-row">
      <div class="col-3">.col-3</div>
      <div class="col-3">.col-3</div>
      <div class="col-3">.col-3</div>
      <div class="col-3">.col-3</div>
    </div>
    <!-- next row -->
    <div class="grid-row">
      <div class="col-2">.col-2</div>
      <div class="col-2">.col-2</div>
      <div class="col-2">.col-2</div>
      <div class="col-2">.col-2</div>
      <div class="col-2">.col-2</div>
      <div class="col-2">.col-2</div>
    </div>
    <!-- next row -->
    <div class="grid-row">
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
      <div class="col-1">.col-1</div>
    </div>
  </div>
```

## Examples with blocks in the different sizes
  
<div class="gris-container">
  <div class="grid-row">
    <div class="col-6">.col-6</div>
    <div class="col-4">.col-4</div>
    <div class="col-2">.col-2</div>
  </div>
  <!-- next row -->
  <div class="grid-row">
    <div class="col-6">.col-6</div>
    <div class="col-1">.col-1</div>
    <div class="col-3">.col-3</div>
    <div class="col-2">.col-2</div>
  </div>
</div>

```html
  <div class="gris-container">
    <div class="grid-row">
      <div class="col-6">.col-6</div>
      <div class="col-4">.col-4</div>
      <div class="col-2">.col-2</div>
    </div>
    <!-- next row -->
    <div class="grid-row">
      <div class="col-6">.col-6</div>
      <div class="col-1">.col-1</div>
      <div class="col-3">.col-3</div>
      <div class="col-2">.col-2</div>
    </div>
  </div>
```

## Examples with incomplete rows</h2>
  
  <div class="grid-container">
    <div class="grid-row">
      <div class="col-6">.col-6</div>
      <div class="col-4">.col-4</div>
    </div>
    <div class="grid-row">
      <div class="col-3">.col-6</div>
      <div class="col-2">.col-4</div>
    </div>
  </div>

```html
  <div class="grid-container">
    <div class="grid-row">
      <div class="col-6">.col-6</div>
      <div class="col-4">.col-4</div>
    </div>
    <div class="grid-row">
      <div class="col-3">.col-6</div>
      <div class="col-2">.col-4</div>
    </div>
  </div>
```

## Examples with nested rows</h2>
  
Avoid the addition of `margin-bottom` by using the class `grid-row` to a column that contains other grid rows.

<div class="grid-container">
  <div class="grid-row">
    <div class="col-6 grid-container">
      <div class="grid-row">
        <div class="col-6">.col-6</div>
        <div class="col-4">.col-4</div>
        <div class="col-2">.col-2</div>
      </div>
    </div>
    <div class="col-4 grid-container">
      <div class="grid-row">
        <div class="col-6">.col-6</div>
        <div class="col-4">.col-4</div>
        <div class="col-2">.col-2</div>
      </div>
    </div>
  </div>
</div>

```html 
  <div class="grid-container">
    <div class="grid-row">
      <div class="col-6 grid-container">
        <div class="grid-row">
          <div class="col-6">.col-6</div>
          <div class="col-4">.col-4</div>
          <div class="col-2">.col-2</div>
        </div>
      </div>
      <div class="col-4 grid-container">
        <div class="grid-row">
          <div class="col-6">.col-6</div>
          <div class="col-4">.col-4</div>
          <div class="col-2">.col-2</div>
        </div>
      </div>
    </div>
  </div>  
```
