
# Convert TAO PCIs to IMS PCIs
## File structure
- move all PCI files to `ims` folder (ex: `parccTei/views/js/pciCreator/ims/myPCI`)
- rename `pciCreator.js` to `imsPciCreator.js`
- rename `pciCreator.json` to `imsPciCreator.json`

## Update manifest (imsPciCreator.json) content
- add this as the first line

		"model" : "IMSPCI"
- adapt the runtime section so it looks like the following:
*Pay close attention to file extensions, or lack of sometimes, and to the way path are set. All dependencies should be in the src entry. If you have any CSS, remove it and require it directly from the main interaction runtime (see next section).*

		"runtime" : {
		        "hook" : "runtime/graphLineAndPointInteraction.min.js",
		        "modules" : {
		            "graphLineAndPointInteraction/runtime/graphLineAndPointInteraction.min" : [
		                "runtime/graphLineAndPointInteraction.min.js"
		            ]
		        },
		        "src" : [
		            "./runtime/graphLineAndPointInteraction.js",
		            "./runtime/wrappers/lines.js",
		            "./runtime/wrappers/points.js",
		            "./runtime/wrappers/segments.js",
		            "./runtime/wrappers/setOfPoints.js",
		            "./runtime/wrappers/solutionSet.js"
		        ]
		    },

- reference the correct creator hook in the Creator section:

		"hook": "imsPciCreator.json",

## Bundle PCI
- remove handling of the prompt (in tpl, runtime, creator states...). This most probably will trigger the removal of `containerEditor` and of the portableLib `OAT\util\html`, but not always
- replace any reference to shared librairies to their equivalent in `portableLib`
- require any CSS in the main runtime. Ex:

		'css!graphLineAndPointInteraction/runtime/css/graphLineAndPointInteraction'

- Launch the bundle script (see [specific documentation](https://hub.taocloud.org/articles/pcipic-development))

		grunt portableelement -e=parccTei -i=xxx

## Register the PCI
- create install registration script and reference it in the extension manifest
- register PCI in the update script
- run taoUpdate
- add the PCI to your `debug_portable_element.conf.php` so the `data` folder gets updated when opening the item authoring (see [specific documentation](https://hub.taocloud.org/articles/pcipic-development)).
- !!! It looks like for now, bundling is necessary to see changes in authoring

At this stage, you should be able to drag the PCI in the item authoring. It will complain, however, that it lacks the `.getInstance()` method.

## Update API
- adapt PCI runtime API to IMS V1 specifications (see example in [reference implementation](https://github.com/oat-sa/extension-tao-itemqti-pci/blob/7374649fb2f7a4fce5e01850b55713919a120482/views/js/pciCreator/ims/likertCompact/likert/runtime/js/likertInteraction.js))
- update test sample with new item XML (converted to JSON). You can use [this gist](https://gist.github.com/no-chris/9cb7c67b59ee89e6c95e76f218ccf367) for this purpose:

		php taoTool.php --qti-to-json /tao/tao/parccTei/views/js/test/samples/xxx.xml
		
- update unit test. If it's an old test (= PARCC), you'll need to update the test setup with the new portableElement registry. Don't forget to remove now useless requireJs config in `test.html`
- the main difference is the absence of a `.setState()` function. Set the state during the `.render()` call of the itemRunner

		.render($container, { state: state })

## Test
The PCI should work in:
- item authoring
- item preview
- delivery (with state restoring)


