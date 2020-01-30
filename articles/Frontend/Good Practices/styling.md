<!--
authors:
    - "Jean-Sébastien Conan"
tags:
    Frontend Architecture:
        - "Good practices"
-->

# Styling

> This document describes good practices regarding styling.

**Description** -
In order to prevent trivial issues due to bad design, this article will propose
a list of good practices to apply. For each presented situation an example will
be provided for both bad and good solutions, with some explanation around them.

**Disclaimer** -
Regarding the provided examples, in order to make them more readable, only the
addressed topic will be represented, and good practices unrelated with it might
not be always presented in the code. Please also keep in mind that the provided
examples are not final solutions, only illustrations.

<!-- TOC depthFrom:1 depthTo:6 withLinks:1 updateOnSave:1 orderedList:0 -->

- [Styling](#styling)
	- [Use explicit class names](#use-explicit-class-names)
		- [Bad example: building class names with parent selector](#bad-example-building-class-names-with-parent-selector)
		- [Good example: finite class names and inheritance with parent selector](#good-example-finite-class-names-and-inheritance-with-parent-selector)
	- [Use dedicated class names](#use-dedicated-class-names)
		- [Bad example: unspecific class names](#bad-example-unspecific-class-names)
		- [Good example: specific class names](#good-example-specific-class-names)

<!-- /TOC -->

## Use explicit class names
SASS and LESS are providing some useful shortcuts, but could also lead to
unreadable and unmaintainable code. The parent selector (`&`) is a very useful
tool, but it must be reserved to chain classes, not to build complex names.
Using the parent selector to build complex names prevents to retrieve easily
the class names. This is hard to maintain as it introduces some mess in the
code.

### Bad example: building class names with parent selector
The following snippet shows how messy the code could be with a misuse of the
parent selector. Can you quickly see what will be the outcome of that?

```scss
.sidebar {
    &-list {
        .node {
        }
    }
}
.dashboard-sidebar {
    &-collapse {
    }
    &.sidebar {
        &-open {
        }
    }
    &-open {
    }
    .filter-school {
        &-container {
        }
        &-border {
        }

        &__error-message {
        }
    }
}
```

### Good example: finite class names and inheritance with parent selector
A proper implementation, keeping the same class names, will be:

```scss
.sidebar-list {
    .node {
    }
}
.dashboard-sidebar-collapse {
}
.dashboard-sidebar-open {
}
.dashboard-sidebar {
    &.sidebar-open {
    }
    .filter-school-container {
    }
    .filter-school-border {
    }
    .filter-school-error-message {
    }
}
```

## Use dedicated class names
Always prefer specific and well defined class name to match a component part.
Using generic name could lead to conflicts as they could be broadly used for
different purposes. Unless, of course, the intent is to have a generic behavior,
like `disabled` or `hidden`. But when we talk about scope class, it is better
to rely on unique and self-explaining names. Please avoid also verbose styling,
like Bootstrap use to do. This has the same downside as hardcoding the style
within the markup. It couples hard meaning to the design, and this is not easy
to apply proper design later on.

### Bad example: unspecific class names
This HTML markup makes use of redundant class name, in different context,
making difficult to apply consistent rules. `dashboard-sidebar` should be the
root class for the component, and in this context `container`, `root` and `list`
are both useless and too generic as they could mean anything. Please also not
the misuse of class names with `wide-margin`, `align-left`, and `align-right`,
that all are related to enforcing style. A better approach would have been to
rely on a single class name to apply the expected style.

```html
<div class="dashboard-sidebar container wide-margin">
    <div class="dashboard-sidebar root align-left"></div>
    <div class="dashboard-sidebar list align-right"></div>
</div>
```

### Good example: specific class names
Here is a better solution, even if not the only one. `dashboard-sidebar` is the
root class that will define the main component style. `dashboard-sidebar-root`
should define the style of the related part in the component, the same for
`dashboard-sidebar-list`.

```html
<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-root"></div>
    <div class="dashboard-sidebar-list"></div>
</div>
```
