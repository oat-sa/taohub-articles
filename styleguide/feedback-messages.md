<!--
tags: ["Style Guide:Feedback Messages"]
-->

# Feedback Messages

> Feedback messages can be of four different types, *warning*, *error*, *info* and *success*. They are usually build from a `div` element but most other elements should work as well.

## Creating messages in JavaScript

```javascript
  // Error:
  require(['ui/feedback'], function(feedback){
      feedback().error('An error message');
  });

  // Warning:
  require(['ui/feedback'], function(feedback){
      feedback().warning('This is not good at all');
  });
```

## Message Types

### Warning

<div class="feedback-warning">
  Something might happen      
</div>

```html
  <div class="feedback-warning">
    Something might happen      
  </div>
```

### Error

<div class="feedback-error">
  Something just happened, calm down!        
</div>

```html
  <div class="feedback-error">
    Something just happened, calm down!        
  </div>
```

### Info

<div class="feedback-info">
  We have no idea what it is but we are working on it anyway      
</div>

```html
  <div class="feedback-info">
    We have no idea what is but we are working on it anyway      
  </div>
```

### Success

<div class="feedback-success">
  Everything fine again      
</div>

```html 
  <div class="feedback-success">
    Everything fine again      
  </div>
```

### Smaller feedback bars</h2>

Adding the class `.small` will create feedback messages that are less high. For the meaning of the class `.col-3` see the [chapter about grids](grids.md).

<div class="grid-row" contenteditable="false">
  <div class="feedback-warning small col-3">
    Warning
  </div>
  <div class="feedback-error small col-3">
    Error
  </div>
  <div class="feedback-success small col-3">
    Success
  </div>
  <div class="feedback-info small col-3">
    Info
  </div>
</div>

```html
  <div class="feedback-warning small col-3">
    Warning
  </div>
  <div class="feedback-error small col-3">
    Error
  </div>
  <div class="feedback-success small col-3">
    Success
  </div>
  <div class="feedback-info small col-3">
    Info
  </div>
```
