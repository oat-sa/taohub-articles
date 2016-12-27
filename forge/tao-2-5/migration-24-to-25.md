<!--
parent: 'TAO 2 5'
created_at: '2013-06-04 14:36:21'
updated_at: '2014-03-11 10:59:37'
authors:
    - 'Joel Bout'
tags:
    - 'TAO 2.4'
    - 'TAO 2.5'
-->

Migration 2.4 to 2.5
====================

Generis
-------

The implementation of `getPropertiesValues` varied between soft and hard mode. In soft it would not contain any keys for properties without values, in hard it would contain the key pointing to an empty array. As of 2.5 both implementations will return an empty array for properties without values. It is suggested to use `empty()` to check if a vaule is set in order to ensure backwards compatibility.

Session management has been delegated to `common_session_SessionManager`, but the class `core_kernel_classes_Session` still exists for backward compatibility.

Extension’s Changes
-------------------

Many changes occurs, many extensions have been split into 2 or 3 to improve modularity.<br/>

taoCoding had been removed.<br/>

ltiProvider have been reorganised into taoLti and taoLtiBasicOutcomes

Items
-----

The Item API has been reworked and while versions are still working, they should be considered deprecated.

Delivery
--------

In order to allow the test and delivery models to be expendable the Tao 2.5 Delivery model has changed significantly from 2.4

Upgrading
---------

A new update procedure now allow you to smothly upgrade from 2.4 to 2.5, [Installation and Upgrading](../administrator-guide/installation-and-upgrading.md)


