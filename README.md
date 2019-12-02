# Release Manager

This is a project release application, aimed at source control via GitHub or GitLab.
I designed this for myself as a way to have a more graphical interface to my source code repos.

Note: This is an application under development! So many features will not work.

To include:
* Timed releases
* Conditional releases
* Single or multiple server releases
* Release retention and rollback

## Running the source
The back-end of this application is written as a PHP API, with the front-end separated and running as via jQuery, ES6, and Bootstrap.
The intent is to be able to swap out the backend API without disrupting the front-end, or vice-versa.

On a machine with PHP and Composer, the application can be started from it's directory using: composer start

## Additionally
The front-end source is uglified and minified using LESS and UglifierJs
These are tasks running under Grunt
