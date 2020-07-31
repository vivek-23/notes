```
This is about Apache content negotiation.

A MultiViews search is where the server does an implicit filename pattern match, and choose from amongst the results.

For example, if you have a file called configuration.php (or other extension) in root folder and you set up a rule in your htaccess for a virtual folder called configuration/ then you'll have a problem with your rule because the server will choose configuration.php automatically (if MultiViews is enabled, which is the case most of the time).

If you want to disable that behaviour, you simply have to add this in your htaccess
Options -MultiViews

This way, your rule will be now evaluated because content negotiation is disabled.

Edit
On some shared hostings, the negotiation module might not be enabled. That would give you then a 500 error. To avoid this error, you can, by default, encapsulate the directive in an IfModule block.

<IfModule mod_negotiation.c>
    Options -MultiViews
</IfModule>
```
Link: https://stackoverflow.com/questions/25423141/what-exactly-does-the-multiviews-options-in-htaccess
