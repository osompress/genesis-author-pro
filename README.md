# Genesis Author Pro
Contributors: nick_thegeek, dreamwhisper, laurenmancke
Tags: genesis, authors, books
Requires at least: 3.9
Tested up to: 4.1.1
Stable tag: 0.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a book library to any Genesis child theme to tactfully display book details in single and archive views

## Description

The Genesis Author Pro plugin creates a library which allows you to add books to your site. The books can have custom information added including:
* Featured Text
* Price
* ISBN
* Publisher
* Editor
* Edition
* Publish Date
* Available Editions
* Three custom buttons

In addition to the custom data that can be entered about the book there are 3 taxonomies created including "Author," "Series," and "Tags" which allow you to sort and organize the books in your library.

The Genesis Author Pro Featured Book widget will allow you to select a book from the library and feature it in any widgeted area of the site. Optional output from the widget includes:
* Widget Title
* Book Title
* By Line
* Book Image
* Featured Text
* Content options including: Full content, limited content and the excerpt for a custom synopsis.
* Price
* Custom link to the single book page

The Author is handled via the custom taxonomy instead of following the post author. This allows you to have multiple book authors and put books in the library without creating new members on the site. Multiple authors should be output in the byline without the Oxford comma like:
* John Doe
* Jane Doe and John Doe
* Jane Doe, John Doe, and John Smith

The publish date is a text aware date field that attempts to understand standard date formats such as
* January 1, 1999
* 1 Jan 1999
* 1 1 1999
* 1999 1 1

There are instances where the returned date may not correctly match. 10 10 1999 might be interpreted as October 10, 1999 instead of the intended 10 October 1999. Typing out the month or month abbreviation instead of numeric representation of the month should resolve any discrepancies.

The date will be stored in a computer readable format and then output following the date format set in the WordPress options.

Templates are built into the plugin with default CSS to create the basic layout for all child themes. Templates follow standard WP template hierarchy so if the template is in the child theme that will override the template in the plugin. Templates include:
* single-books.php
* archive-books.php
* taxonomy-book-authors.php
* taxonomy-book-series.php
* taxonomy-book-tags.php


## Installation


1. Upload `genesis-author-pro` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress


## Changelog

### 0.9 
* Initial Public Release

## Upgrade Notice

### 0.9 
Initial Public Release 
