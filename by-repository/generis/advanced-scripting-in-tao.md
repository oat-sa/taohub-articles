# Advanced Scripting in TAO

> This article explains how to create advanced scripts within TAO.

## A simple Example

```php
<?php
/**
 * A simple Script Tool using the abstract ScriptAction class.
 *
 * It's eay as implementing 3 methods: provideOptions(), provideDescription(), run().
 * Under the hat, it extends the well known oat\oatbox\extension\AbstractAction so
 * ScriptAction based scripts are still __invokable()!
 *
 * Optionally, you can implement a 4th method provideUsage() which enables you to automatically
 * display help about the usage of the script in a nice looking format.
 *
 * As usual, return a Report to end your script.
 */
namespace oat\myExtension\scripts\tools;

use oat\oatbox\extension\script\ScriptAction;
use common_report_Report as Report;

class MyScript extends ScriptAction
{
    protected function provideOptions()
    {
        return [
            'myStringOption' => [
                'prefix' => 's',
                'longPrefix' => 'myString',
                'required' => true,
                'description' => 'A string'
            ],
            'myIntegerOption' => [
                'prefix' => 'i',
                'longPrefix' => 'myInteger',
                'required' => false,
                'cast' => 'integer',
                'defaultValue' => 0,
                'description' => 'An integer'
            ],
            'myFlagOption' => [
                'flag' => true,
                'prefix' => 'f',
                'longPrefix' => 'myFlag',
                'description' => 'A flag'
            ]
        ];
    }

    protected function provideDescription()
    {
        return 'Example - My Dummy Script';
    }

    protected function run()
    {
        // Retrieve mandatory option 'myStringOption'.
        $myString = $this->getOption('myStringOption');
        
        // Retrieve non-mandatory option 'myIntegerOption'. Defaults to 0 if not provided. 
        $myInteger = $this->getOption('myIntegerOption');

        // Determine whether flag 'myFlagOption' is provided.
        $myFlag = $this->hasOption('myFlagOption');

        // Do some stuff...
        // ...
        // ...
        
        // And return a Report!
        return new Report(
            Report::TYPE_SUCCESS,
            'Thanks for using  My Dummy Script!'
        );
    }

    protected function provideUsage()
    {
        // Overriding this method is option. Simply describe which option prefixes have to
        // to be used in order to display the usage of the script to end user.
        return [
            'prefix' => 'h',
            'longPrefix' => 'help',
            'description' => 'Prints a help statement'
        ];
    }
}
```

Below, an example of invoking this script above via CLI:

```bash
sudo -u www-data php index.php "oat\myExtension\scripts\tools" -s "My Super String!" --myInteger 99 --myFlag
```

Below, an example of invoking the usage for the script via CLI:

```bash
sudo -u www-data php index.php "oat\myExtension\scripts\tools" -h
```

will display

```
Example - My Dummy Script

  Required arguments:
    -s myStringOption, --myString myStringOption
      A string
  
  Optional arguments:
    -i myIntegerOption, --myInteger myIntegerOption
      An integer
    -f, --myFlag
      A flag
    -h, --help
      Prints a help statement
```

The scripts remain invokable in source code as in the example below

```php
use oat\myExtension\scripts\tools\MyScript;

$script = new MyScript();
$script([
    '-s', 'My Super String!',
    '--myInteger', 99,
    '--myFlag'
]);
```