(function () {
    var aName = "Barry";
})();
// Variable name is not accessible from the outside scope
aName // throws "Uncaught ReferenceError: aName is not defined"


var result = (function () {
    var name = "Barry"; 
    return name; 
})(); 
// Immediately creates the output: 
console.log(result); // "Barry"

/*

An IIFE (Immediately Invoked Function Expression) is a JavaScript function that runs as soon as it is defined.

It is a design pattern which is also known as a Self-Executing Anonymous Function and contains two major parts. 
The first is the anonymous function with lexical scope enclosed within the Grouping Operator (). This prevents accessing 
variables within the IIFE idiom as well as polluting the global scope.

The second part creates the immediately executing function expression () through which the JavaScript engine will directly 
interpret the function.

The function becomes a function expression which is immediately executed. The variable within the expression can not be 
accessed from outside it.

Assigning the IIFE to a variable stores the function's return value, not the function definition itself.

*/
