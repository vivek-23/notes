const params = new URLSearchParams();
params.append('x1',x1);
params.append('x2',x2);
params.append('x2',x3);

console.log(params.toString());

/*

  This is how we make query parameters in Javascript. We could have done the usual string split but doing it this standard way provides 
  us a urlencode functionality by default and also will automatically get additional features assigned to it if Javascript developers 
  make any new useful updates to this function.
  
  Standard Doc: https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams

*/
