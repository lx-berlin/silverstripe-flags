# silverstripe-flags

A very simple module for Silverstripe 3.0 that adds up to 5 flags to any DataObject.
The flags have by default no impact on your code. They are just markers for the administrator.
For example the administrator could set the red flag for those records that need revision.

![screenshot flag module in SS3 CMS](http://netefx.de/flag_module.png)

## Requirements

Silverstripe 3.0

## Features

- adds up to 5 flags to any DataObject (Red,Orange,Yellow,Green,Blue) 
- those flags are visible in your modeladmin with each flag being an action that you can enable/disable with a click

## Install

- download the module and unzip it. Make sure the folder name is "flags".
- add to your mysite/_config.php e.g.: `Object::add_extension('Product', 'FlagExtension');`
- By default you will get just a red flag. Add `public static $flags = array("Green","Red");` to your DataObject if you want other (more then one) flags.
- run /dev/build

## Usage

The flags don´t do anything by default, but of course you can use them in your code like: 

`$Products = Product::get()->filter("GreenFlag",1);`

## Changelog

v1.0.0 (2012-11-07) : 
initial version
