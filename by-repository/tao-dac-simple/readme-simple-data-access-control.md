# Readme: Simple Data Access Control

Simple Data Access Control allows the restriction of which user can access which resources, in the way compatible with
Advanced Search.

Access Privileges are granted either to users directly or to roles, applying to all users who have that specific role.

Privileges are given per resource, so that in order to remove the write access to all items within a class, the new
access rights need to be applied recursively to all resources by checking "recursive" before saving the changes.

Privileges are additive, meaning that if:

* Role A has write and read access to Item 1
* User X has read access to Item 1
* And User X has the Role A

Then User X he will have read and write access to Item 1

## How to enable ACL management

In order to see the `Access control` button on the backoffice panel a few changes are necessary.

### Enable this in the actions

Change the `actions/structures.xml` file by adding the attribute `allowClassActions="true"` in the `actions` node:

```xml
<?xml version="1.0" encoding="utf-8"?>
<structures>
    <structure>
        <sections>
            <section>
                <trees><!-- Something here --></trees>
                <actions allowClassActions="true">
                    <action><!-- Something here --></action>
                </actions>
            </section>
        </sections>
    </structure>
</structures>
```

### Enable ACL in an endpoint

Add the annotation `requiresRight` with proper `field` and `grant level` to check permissions:

```php
class MyController extends tao_actions_SaSModule
{
    /**
     * @requiresRight id READ
     */
    public function editInstance()
    {
      //...
    }
}
```

### Checking ACL internally (without annotations) in the endpoint

If extending `tao_actions_RdfController` we can use the method `hasWriteAccess`:

```php
class MyController extends tao_actions_SaSModule
{
    public function editItem()
    {
        $item = $this->getCurrentInstance();
            
        if ($this->hasWriteAccess($item->getUri())) {
            // Do something
        }
    }
}
```

Or we can use the `DataAccessControl` implementation directly:

```php
$user = $this->getSession()->getUser();
$item = $this->getCurrentInstance();
$dataAccessControl = new \oat\tao\model\accessControl\data\DataAccessControl();

$canWrite = $dataAccessControl->hasPrivileges($user, [$item->getUri() => 'WRITE']);
$canRead = $dataAccessControl->hasPrivileges($user, [$item->getUri() => 'READ']);
```

## Permissions save strategies

Currently, we have the following saving/propagating permissions strategies:

- [SyncPermissionsStrategy](./model/SyncPermissionsStrategy.php) (Default): Overwrites existent permissions with the 
  new ones provided by the user.
- [SavePermissionsStrategy](./model/SavePermissionsStrategy.php): Merges existing permissions with the new ones 
  provided by the user.
  
**IMPORTANT**: Saving with _recursive_ option is very dangerous, cause will 
override permissions for all subclasses and resources. 

The permission strategy is configured here `config/taoDacSimple/PermissionsService.conf.php`. Example:

```php
<?php
return new oat\taoDacSimple\model\PermissionsServiceFactory(
    [
        'save_strategy' => 'oat\\taoDacSimple\\model\\SyncPermissionsStrategy',
        'recursive_by_default' => false
    ]
);
```