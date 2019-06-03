var x = {};
x['name'] = 'vivek';
console.log(x['name']); // prints 'vivek'

delete x['name'];
console.log(x['name']); // prints undefined

/*

The JavaScript delete operator removes a property from an object; if no more 
references to the same property are held, it is eventually released automatically.

Source: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/delete

*/
