
# Convert TAO PCIs to IMS PCIs
## File structure
- move all PCI files to `ims` folder (ex: `parccTei/views/js/pciCreator/ims/myPCI`)
- rename `pciCreator.js` to `imsPciCreator.js`
- rename `pciCreator.json` to `imsPciCreator.json`

## Update manifest (imsPciCreator.json) content
- add this as the first line

		"model" : "IMSPCI"
- in the **"runtime"** section
	- adapt so it looks like the following code sample. We only declare the following elements: *hook*, *modules* (the requireJs configuration) and *src*. The latter contains **only** the PCI entry point (the main runtime) that will be used for PCI bundling.
	- pay close attention to paths ('./' or nothing) and to file extensions (or lack of)
	- if the PCI use other JS files, you can remove them as they should already be required by the main runtime (but the path will need to be adapted, see next section)
	- if you have any other assets (CSS, SVG...), take note of them as they will need to be referenced in the PCI entry point (see next section)

				"runtime" : {
					"hook" : "runtime/graphLineAndPointInteraction.min.js",
					"modules" : {
					    "graphLineAndPointInteraction/runtime/graphLineAndPointInteraction.min" : [
						"runtime/graphLineAndPointInteraction.min.js"
					    ]
					},
					"src" : [
					    "./runtime/graphLineAndPointInteraction.js"
					]
				    },

- in the **"creator"** section, reference the correct creator hook

		"hook": "imsPciCreator.js",

## Bundle PCI
- remove handling of the prompt (in tpl, runtime, creator states...). This most probably will trigger the removal of `containerEditor` and of the portableLib `OAT\util\html`, but not always
- replace any reference to shared librairies to their equivalent in `portableLib`
- make sure any JS files that is part of the PCI get a proper requireJS path

		'parccTei/pciCreator/ims/graphLineAndPointInteraction/runtime/wrappers/setOfPoints',
		'parccTei/pciCreator/ims/graphLineAndPointInteraction/runtime/wrappers/points',
    
- require any CSS/SVG/... in the main runtime. Ex:

		'text!parccTei/pciCreator/ims/graphNumberLineInteraction/runtime/img/open-arrow.svg',
		'css!parccTei/pciCreator/ims/graphLineAndPointInteraction/runtime/css/graphLineAndPointInteraction'
		
- figure out a way to deal with other meadia file like `svg`, they can for example be bundled thanks to the requireJS `text!` loader
- Launch the bundle script (see [specific documentation](https://hub.taocloud.org/articles/pcipic-development))

		grunt portableelement -e=parccTei -i=xxx

## Register the PCI
- create install registration script and reference it in the extension manifest
- register PCI in the update script
- run taoUpdate
- add the PCI to your `debug_portable_element.conf.php` so the `data` folder gets updated when opening the item authoring (see [specific documentation](https://hub.taocloud.org/articles/pcipic-development)).

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


