* The `$_SERVER` variable we use to get the `HTTP_REFERER`, like `$_SERVER['HTTP_REFERER']` isn't 
  reliable since it is sent from the client browser and can be easily tweaked.
* **A good read**: https://stackoverflow.com/questions/6023941/how-reliable-is-http-referer

**An example of spoof below:(tried using [Postman](https://www.getpostman.com/))**

![HTTP REFERER SPOOFING](https://github.com/vivek-23/notes/blob/master/http_referer.PNG)
