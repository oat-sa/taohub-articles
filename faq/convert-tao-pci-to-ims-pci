# Convert TAO PCIs to IMS PCIs

A proposed step by step.

## File structure
- move all PCI files to `ims` folder (ex: `parccTei/views/js/pciCreator/ims/myPCI`)
- rename `pciCreator.js` to `imsPciCreator.js`
- rename `imsPciCreator.json` to `imsPciCreator.json`

## Update manifest content
- add `"model" : "IMSPCI"`
- runtime section
specify minified in hook
create module entry for requiere js resolver
put all source files in “src” with the main runtime first
creator section
rename hook to imsPciCreator.json
Remove prompt, containerEditor and html renderer
Bundle PCI
replace shared lib references with portable libs references
require any CSS directly in the runtime
launch the bundle script
grunt portableelement -e=parccTei -i=xxx
Register the PCI
registration script 
manifest update
update script
Add PCI to debug_portable element script 


Update API
Adapt runtime to IMS V1 specifications (use model)
Update unit test
remove extra require config in test.html
update test sample with new item XML
php /tao/package-act/taoTool.php --qti-to-json /tao/tao/parccTei/views/js/test/samples/

test in authoring
test in:
preview
delivery (state restoring)
