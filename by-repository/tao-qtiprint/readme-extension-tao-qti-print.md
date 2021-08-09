# Readme: extension-tao-qti-print

Custom runner and CSS for Item printing

This extension is a companion for booklets and tests results printing.

The booklets are using particular version of interactions, specially designed to be printed. They are forked version of regular interactions.
Obviously, not all interactions are compatible with booklets. In the current state of work, only these interactions are compatible:
- choice
- inline choice
- match
- text entry
- extended text entry

The test results printing is using the regular interactions, with a dedicated CSS specially designed for printing purpose.
However, for obvious reasons, some interactions are not compatible (upload, media), and they are to be replaced by a table listing the raw responses.

Note: the print CSS theme is lying here, as the QTIPrint is the only consumer for now. 
When printing will be needed elsewhere, we should consider to have a dedicated place for all printing CSS.